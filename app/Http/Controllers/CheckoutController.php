<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Course;
use App\Http\Requests\PaymentRequest;
use App\Mail\PaymentDone;
use App\Mail\PaymentWaiting;
use App\Payment;
use App\Trail;
use App\User;
use Auth;
use Carbon\Carbon;
use Cookie;
use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use PagarMe\Client;
use Session;

class CheckoutController extends Controller
{
    const INDIVIDUAL = 'cpf';
    const BUSINESS = 'cnpj';
    const CALLBACK_URL = 'https://www.institutoacesso.com.br/pagarme/callback';
    const COOKIE_EXPIRATION_TIME = (60 * 24 * 30);

    /** @var Client $pagarme */
    private $pagarme;

    /** @var User $user */
    private $user;

    /**
     * CheckoutController constructor.
     */
    public function __construct()
    {
        $this->middleware(
            function ($request, $next) {
                $this->user = Auth::user();
                $this->pagarme = new Client(config('app.pagarme'));
                return $next($request);
            }
        );
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = $this->user;
        $cart = [];
        $coupon = [];
        $items = [];
        $valor_total = 0;
        $coupon_discount = 1;

        if (Cookie::has('cart')) {
            $items = [];
            $valor_total = 0;
            $cart = json_decode(Cookie::get('cart'), true);
            if (count($cart) > 0) {
                foreach ($cart as $type => $cart_items) {
                    foreach ($cart_items as $cart_item) {
                        if ($type == 'trail') {
                            $item = Trail::find(
                                $cart_item,
                                [
                                    'id',
                                    'title',
                                    'slug',
                                    'old_price',
                                    'price',
                                    'discount',
                                    'cover_details',
                                    'cover'
                                ]
                            );
                            $item->price = round($item->price * (1 - ($item->discount / 100)), 2);
                        } else {
                            $item = Course::find(
                                $cart_item,
                                [
                                    'id',
                                    'title',
                                    'slug',
                                    'category_title',
                                    'category_slug',
                                    'old_price',
                                    'price',
                                    'image'
                                ]
                            );
                        }
                        $item->type = $type;
                        $item->title = mb_strtoupper($item->title);
                        $valor_total += $item->price;
                        $item->price = number_format($item->price, 2, ',', '.');
                        $items[] = $item;
                    }
                }
            }
        }

        if (Cookie::has('coupon')) {
            $coupon = json_decode(Cookie::get('coupon'), true);
            if (!empty($coupon)) {
                $coupon_discount = (1 - ($coupon['discount'] / 100));
            }
        }

        return view('pages.checkout.index', compact('items', 'user', 'valor_total', 'coupon', 'coupon_discount'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function plan($slug)
    {
        $plan = Plan::where('slug', $slug)->first();
        if ($plan === null) {
            return redirect(route('home'));
        }

        $user = $this->user;
        $coupon = [];
        $valor_total = $plan->amount;
        $coupon_discount = 1;

        if (Cookie::has('coupon')) {
            $coupon = json_decode(Cookie::get('coupon'), true);
            if (!empty($coupon)) {
                $coupon_discount = (1 - ($coupon['discount'] / 100));
            }
        }

        return view('pages.checkout.plan.index', compact('plan', 'user', 'valor_total', 'coupon', 'coupon_discount'));
    }

    /**
     * @param  PaymentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment(PaymentRequest $request)
    {
        try {
            $paymentData = $request->all();

            if ($paymentData['payment_method'] == 'credit_card') {
                $payment = $this->paymentCard($paymentData);
            } else {
                $payment = $this->paymentBankSlip($paymentData);
            }

            if ($payment->status != 'refused') {
                $forgetCookies[] = Cookie::forget('coupon');

                if (!array_key_exists('plan', $paymentData)) {
                    $forgetCookies[] = Cookie::forget('cart');
                }

                return redirect()
                    ->route('checkout.confirmation', ['order' => $payment->order_id])
                    ->withCookies($forgetCookies);
            }
            return back();
        } catch (Exception $ex) {
            if ($ex->getMessage() == 'cupom inválido') {
                Session::flash('flash_message', 'Cupom inválido.');
                Session::flash('flash_type', 'danger');
                return back()
                    ->withCookie(Cookie::forget('coupon'))
                    ->withInput();
            }

            Session::flash('flash_message', 'Ocorreu um erro ao efetuar o pagamento.');
            Session::flash('flash_message_detail', $ex->getMessage());
            Session::flash('flash_type', 'danger');
            return back();
        }
    }

    /**
     * @param $paymentData
     * @return Payment
     * @throws \Throwable
     */
    private function paymentCard($paymentData)
    {
        try {
            DB::beginTransaction();

            $couponUsed = null;

            if (Cookie::has('coupon')) {
                $cookie_coupon = json_decode(Cookie::get('coupon'), true);
                if (!empty($cookie_coupon)) {
                    $couponUsed = Coupon::where('id', $cookie_coupon['id'])->first();

                    if ($couponUsed === null || ($couponUsed->times_used >= $couponUsed->limit)) {
                        throw new Exception('cupom inválido');
                    }
                }
            }

            $isPlan = false;
            if (array_key_exists('plan', $paymentData)) {
                $isPlan = true;
                $plan = Plan::where('slug', $paymentData['plan'])->first();
                if ($plan !== null) {
                    $installments = ($paymentData['cc_installments'] > $plan->months) ? $plan->months : $paymentData['cc_installments'];
                    $paymentData['cc_installments'] = $installments;
                }
            }

            $customer = $this->getCustomer();
            $cartItems = ($isPlan === true) ? $this->getPlanItem($paymentData['plan']) : $this->getCartItems();
            $cardExpirationDate = "{$paymentData['cc_expiry_month']}-{$paymentData['cc_expiry_year']}";
            $cardExpirationDateFormat = Carbon::createFromFormat('m-Y', $cardExpirationDate)->format('my');
            $orderId = $this->generateOrderId();
            $this->updateUserProfile($paymentData);

            $transaction = $this->pagarme->transactions()->create(
                [
                    'amount'               => $cartItems['amount'],
                    'async'                => false,
                    'payment_method'       => $paymentData['payment_method'],
                    'card_holder_name'     => $paymentData['cc_holder'],
                    'card_cvv'             => $paymentData['cc_cvv'],
                    'card_number'          => $paymentData['cc_number'],
                    'card_expiration_date' => $cardExpirationDateFormat,
                    'customer'             => $customer,
                    'billing'              => [
                        'name'    => $this->user->name,
                        'address' => [
                            'country'       => $paymentData['country'],
                            'street'        => $paymentData['street'],
                            'street_number' => $paymentData['street_number'],
                            'state'         => $paymentData['state'],
                            'city'          => $paymentData['city'],
                            'neighborhood'  => $paymentData['neighborhood'],
                            'zipcode'       => only_numbers($paymentData['zipcode']),
                        ],
                    ],
                    'items'                => $cartItems['items_transaction'],
                    'reference_key'        => $orderId,
                    'installments'         => $paymentData['cc_installments'],
                    'postback_url'         => self::CALLBACK_URL,
                ]
            );

            if (!empty($transaction->errors)) {
                throw new Exception(
                    $transaction->errors[0]->message ?? 'Ocorreu um erro ao efetuar o pagamento! Tente novamente mais tarde.'
                );
            }

            $dateCreated = Carbon::parse($transaction->date_created)->setTimezone('America/Sao_Paulo')->format(
                'Y-m-d H:i:s'
            );
            $dateUpdated = Carbon::parse($transaction->date_updated)->setTimezone('America/Sao_Paulo')->format(
                'Y-m-d H:i:s'
            );
            $paymentArray = [
                'user_id'        => $this->user->id,
                'order_id'       => $orderId,
                'external_id'    => $transaction->id,
                'payment_method' => $paymentData['payment_method'],
                'amount'         => ($cartItems['amount'] / 100),
                'installments'   => $paymentData['cc_installments'],
                'card_brand'     => $transaction->card_brand,
                'status'         => $transaction->status,
                'refuse_reason'  => $transaction->refuse_reason,
                'status_reason'  => $transaction->status_reason,
                'date_created'   => $dateCreated,
                'date_updated'   => $dateUpdated,
            ];

            if ($couponUsed !== null) {
                $paymentArray['coupon_id'] = $couponUsed->id;
                $paymentArray['discount'] = $couponUsed->discount;
            }

            $payment = Payment::create($paymentArray);

            if ($transaction->status == 'paid') {
                $newUserId = 0;
                foreach ($cartItems['items'] as $item) {
                    $iped_user = [
                        'course_type'    => $item->type == 'plan' ? 4 : 3,
                        'course_plan'    => $item->type == 'plan' ? $item->months : ($item->type == 'trail' ? 3 : 2),
                        'user_id'        => $newUserId,
                        'user_name'      => $this->user->name,
                        'user_cpf'       => $this->user->profile->document_number,
                        'user_email'     => $this->user->email,
                        'user_password'  => decrypt($this->user->profile->platform_password),
                        'user_country'   => 34,
                        'user_cellphone' => $this->user->profile->phone,
                        'user_info'      => $this->user->id,
                        'group_id'       => config('app.iped_group'),
                    ];

                    if ($newUserId === 0) {
                        $iped_user['user_genre'] = $this->user->profile->sex == 'male' ? 1 : 0;
                    }

                    if ($item->type == 'trail') {
                        $courses = $item->courses->pluck('course_id')->toArray();
                        $iped_user['course_id'] = $courses;
                        $payment->trails()->attach($item->id);
                    } else {
                        if ($item->type == 'plan') {
                            $iped_user['course_id'] = 0;
                            $payment->plans()->attach($item->id);
                        } else {
                            $iped_user['course_id'] = $item->course_id;
                            $payment->courses()->attach($item->id);
                        }
                    }

                    $newUserId = $this->ipedUserRegistration($iped_user);
                }

                if ($couponUsed !== null) {
                    $couponUsed->increment('times_used');
                }

                Mail::send(new PaymentDone($this->user));
            } else {
                if ($transaction->status != 'refused') {
                    Mail::send(new PaymentWaiting($this->user));
                } else {
                    Session::flash('flash_message', 'Transação recusada, não autorizada.');
                    Session::flash('flash_type', 'danger');
                }
            }

            DB::commit();
            return $payment;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @return array
     */
    private function getCustomer()
    {
        $customer = $this->pagarme->customers()->get(
            [
                'id' => $this->user->profile->external_id,
            ]
        );

        $customerArray = [
            'name'          => $customer->name,
            'email'         => $customer->email,
            'external_id'   => $customer->external_id,
            'type'          => $customer->type,
            'country'       => $customer->country,
            'birthday'      => $customer->birthday,
            'phone_numbers' => $customer->phone_numbers,
            'documents'     => [
                [
                    'type'   => $customer->document_type,
                    'number' => $customer->documents[0]->number,
                ],
            ],
        ];

        return $customerArray;
    }

    /**
     * @return array
     */
    private function getPlanItem($slug)
    {
        $items = [];
        $itemsTransaction = [];
        $valor_total = 0;
        $discount = 1;

        $item = Plan::where('slug', $slug)->first();
        if ($item === null) {
            return back();
        }

        if (Cookie::has('coupon')) {
            $coupon = json_decode(Cookie::get('coupon'), true);
            if (count($coupon) > 0) {
                $discount = 1 - ($coupon['discount'] / 100);
            }
        }

        $item->price = $item->amount;
        $item->type = 'plan';
        $valor_total = $item->amount * $discount;
        $itemsTransaction[] = [
            'id'         => strval($item->id),
            'title'      => $item->title,
            'unit_price' => intval(round(($item->amount * $discount), 2) * 100),
            'quantity'   => 1,
            'tangible'   => false,
        ];
        $items[] = $item;

        return [
            'amount'            => intval($valor_total * 100),
            'items_transaction' => $itemsTransaction,
            'items'             => $items,
        ];
    }

    /**
     * @return array
     */
    private function getCartItems()
    {
        $items = [];
        $itemsTransaction = [];
        $valor_total = 0;
        $discount = 1;

        if (Cookie::has('coupon')) {
            $coupon = json_decode(Cookie::get('coupon'), true);
            if (count($coupon) > 0) {
                $discount = 1 - ($coupon['discount'] / 100);
            }
        }

        if (Cookie::has('cart')) {
            $cart = json_decode(Cookie::get('cart'), true);
            if (count($cart) > 0) {
                foreach ($cart as $type => $cart_items) {
                    foreach ($cart_items as $cart_item) {
                        if ($type == 'trail') {
                            $item = Trail::find($cart_item, ['id', 'title', 'price', 'discount']);
                            $item->price = round($item->price * (1 - ($item->discount / 100)), 2);
                            $item->title = "Trilha do conhecimento - {$item->title}";
                        } else {
                            $item = Course::find($cart_item, ['id', 'course_id', 'title', 'price']);
                        }
                        $item->type = $type;
                        $valor_total += ($item->price * $discount);
                        $itemsTransaction[] = [
                            'id'         => strval($item->id),
                            'title'      => $item->title,
                            'unit_price' => intval(round(($item->price * $discount), 2) * 100),
                            'quantity'   => 1,
                            'tangible'   => false,
                        ];
                        $items[] = $item;
                    }
                }
            }
        }

        return [
            'amount'            => intval($valor_total * 100),
            'items_transaction' => $itemsTransaction,
            'items'             => $items,
        ];
    }

    /**
     * @return string
     */
    private function generateOrderId()
    {
        $paymentsToday = Payment::whereDate('created_at', '=', date('Y-m-d'))->count();
        $orderId = date('Ym').mt_rand(100000, 999999).'-'.($paymentsToday + 1);

        while (DB::table('payments')->where('order_id', $orderId)->exists()) {
            $orderId = date('Ym').mt_rand(100000, 999999).'-'.($paymentsToday + 1);
        }

        return $orderId;
    }

    /**
     * Update user's profile
     * @param $userData
     */
    private function updateUserProfile($userData)
    {
        $this->user->profile->street = $userData['street'];
        $this->user->profile->street_number = $userData['street_number'];
        $this->user->profile->neighborhood = $userData['neighborhood'];
        $this->user->profile->city = $userData['city'];
        $this->user->profile->state = $userData['state'];
        $this->user->profile->zipcode = only_numbers($userData['zipcode']);
        $this->user->profile->complement = $userData['complement'];
        $this->user->profile->save();
    }

    /**
     * @param $userData
     * @return mixed
     * @throws Exception
     */
    private function ipedUserRegistration($userData)
    {
        $iped = new IpedAPIController();
        $iped_user_response = $iped->user_registration($userData);

        if (isset($iped_user_response->STATE) && ($iped_user_response->STATE == 1 || $iped_user_response->STATE == 2)) {
            $newUserId = $iped_user_response->REGISTRATION->user_id;
            $this->user->profile->user_token = $iped_user_response->REGISTRATION->user_data[0]->user_token;
            $this->user->profile->platform_user_id = $newUserId;
            $this->user->profile->save();
        } else {
            throw new Exception($iped_user_response->ERROR);
        }

        return $newUserId;
    }

    /**
     * @param $payment
     */
    private function paymentBankSlip($payment)
    {
        //
    }

    /**
     * @param $order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function confirmation($order)
    {
        $payment = Payment::where('order_id', $order)->first();
        if ($payment === null) {
            return redirect('/');
        }

        $payment->load('trails', 'courses');

        $items['trail'] = $payment->trails;
        $items['course'] = $payment->courses;

        return view('pages.checkout.confirmation', compact('items', 'payment'));
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCoupon(Request $request)
    {
        $cookie = [];
        $expires = 60 * 24 * 1;

        $coupon = $this->checkCoupon($request->code);
        $type = $request->get('type', 'course');

        if ($coupon === null) {
            Session::flash('flash_message', 'Cupom indisponível');
            Session::flash('flash_type', 'danger');
        } else {
            Session::flash('flash_message', 'Cupom aplicado com sucesso!');
            Session::flash('flash_type', 'success');
            $cookie = [
                'id'       => $coupon->id,
                'code'     => $coupon->code,
                'discount' => $coupon->discount,
            ];
        }

        $redirect = redirect('/checkout');

        if ($type == 'plan') {
            $redirect = redirect()->back();
        }

        return $redirect->withCookie(cookie('coupon', json_encode($cookie), $expires))
            ->withInput();
    }

    /**
     * @param $code
     * @return Coupon|null
     */
    private function checkCoupon($code)
    {
        $coupon = Coupon::where('code', $code)
            ->whereRaw('coupons.times_used < coupons.limit')
            ->first(['id', 'code', 'discount']);

        return $coupon;
    }
}
