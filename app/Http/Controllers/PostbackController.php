<?php

namespace App\Http\Controllers;

use App\Mail\PaymentDone;
use App\Payment;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use PagarMe\Client;

class PostbackController extends Controller
{
    /** @var \PagarMe\Client $pagarme */
    private $pagarme;

    /** @var \App\Payment $payment */
    private $payment;

    public function __construct()
    {
        $this->pagarme = new Client(config('app.pagarme'));
        $this->payment = new Payment();
    }

    /**
     * @throws Exception
     */
    public function callback(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Hub-Signature');
        $postbackIsValid = $this->pagarme->postbacks()->validate($payload, $signature);
        $failStatus = ['canceled', 'voided', 'failed', 'with_error', 'refused'];

        if ($postbackIsValid) {
            parse_str($payload, $payloadData);
            DB::table('postbacks')->insert([
                'response' => json_encode($payloadData),
            ]);

            $dateUpdated = Carbon::parse($payloadData['transaction']['date_updated'])->setTimezone(
                'America/Sao_Paulo'
            )->format('Y-m-d H:i:s');

            $payment = $this->payment->where('external_id', $payloadData['id'])->first();
            if ($payment !== null) {
                $payment->status = $payloadData['current_status'];
                $payment->date_updated = $dateUpdated;
                $payment->save();
                if ($payloadData['old_status'] != 'paid' && $payloadData['current_status'] == 'paid') {
                    $this->createIpedRegistration($payment);
                } elseif ($payloadData['old_status'] != 'paid' && in_array($payloadData['current_status'], $failStatus)) {
                    if (!is_null($payment->Affiliate)) {
                        $payment->Affiliate->decrement('times_used');
                    }
                    if (!is_null($payment->Coupon)) {
                        $payment->Coupon->decrement('times_used');
                    }
                }
            }
            /*  else {
                $dateCreated = Carbon::parse($payloadData['transaction']['date_created'])->setTimezone('America/Sao_Paulo')->format('Y-m-d H:i:s');
                $paymentArray = [
                    'user_id' => $payloadData['transaction']['customer']['external_id'],
                    'order_id' => $payloadData['transaction']['reference_key'],
                    'external_id' => $payloadData['id'],
                    'payment_method' => $payloadData['transaction']['payment_method'],
                    'amount' => ($payloadData['transaction']['amount'] / 100),
                    'installments' => $payloadData['transaction']['installments'],
                    'card_brand' => $payloadData['transaction']['card_brand'],
                    'status' => $payloadData['transaction']['status'],
                    'refuse_reason' => $payloadData['transaction']['refuse_reason'],
                    'status_reason' => $payloadData['transaction']['status_reason'],
                    'date_created' => $dateCreated,
                    'date_updated' => $dateUpdated,
                ];
                $payment = Payment::create($paymentArray);
            } */
        }
    }

    /**
     * @throws Exception
     */
    private function createIpedRegistration($payment)
    {
        $newUserId = 0;
        $iped_user = [
            'course_type'    => 3,
            'user_id'        => $newUserId,
            'user_name'      => $payment->user->name,
            'user_cpf'       => $payment->user->profile->document_number,
            'user_email'     => $payment->user->email,
            'user_password'  => decrypt($payment->user->profile->platform_password),
            'user_country'   => 34,
            'user_cellphone' => $payment->user->profile->phone,
            'user_info'      => $payment->user->id,
            'user_genre'     => $payment->user->profile->sex == 'male' ? 1 : 0,
            'group_id'       => config('app.iped_group'),
        ];

        if ($payment->courses->count() > 0) {
            $courses = $payment->courses->pluck('course_id')->toArray();
            $iped_user['course_id'] = $courses;
            $iped_user['course_plan'] = 2;
            $this->ipedUserRegistration($iped_user, $payment->user);
        }

        if ($payment->trails->count() > 0) {
            $courses = [];
            foreach ($payment->trails as $trail) {
                $courses = array_merge($courses, $trail->courses->pluck('course_id')->toArray());
            }
            $iped_user['course_id'] = $courses;
            $iped_user['course_plan'] = 3;
            $this->ipedUserRegistration($iped_user, $payment->user);
        }

        Mail::send(new PaymentDone($payment->user));
    }

    /**
     * @throws Exception
     */
    private function ipedUserRegistration($userData, $user)
    {
        $iped = new IpedAPIController();
        $iped_user_response = $iped->user_registration($userData);

        if (isset($iped_user_response->STATE) && ($iped_user_response->STATE == 1 || $iped_user_response->STATE == 2)) {
            $newUserId = $iped_user_response->REGISTRATION->user_id;
            $user->profile->user_token = $iped_user_response->REGISTRATION->user_data[0]->user_token;
            $user->profile->platform_user_id = $newUserId;
            $user->profile->save();
        } else {
            throw new Exception($iped_user_response->ERROR);
        }

        return $newUserId;
    }
}
