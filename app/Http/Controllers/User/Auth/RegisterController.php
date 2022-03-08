<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use PagarMe\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('user.auth.login');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'birthday' => ['required', 'date_format:d/m/Y'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cpf_cnpj' => ['required', 'cpf_cnpj'],
            'phone' => ['required'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try {
            DB::beginTransaction();

            $name = "{$data['firstname']} {$data['lastname']}";
            $user = User::create([
                'name' => $name,
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $birthday = Carbon::createFromFormat('d/m/Y', $data['birthday'])->format('Y-m-d');
            $userProfile = UserProfile::create([
                'user_id' => $user->id,
                'platform_password' => encrypt($data['password']),
                'document_type' => $this->getDocumentType($data['cpf_cnpj'], false),
                'document_number' => $this->getDocumentNumber($data['cpf_cnpj']),
                'phone' => preg_replace('/\D/', '', $data['phone']),
                'country' => 'br',
                'birthday' => $birthday,
            ]);

            $pagarme = new Client(config('app.pagarme'));
            $customer = $pagarme->customers()->create([
                'external_id' => (string) $user->id,
                'name' => $user->name,
                'type' => $userProfile->document_type,
                'country' => 'br',
                'email' => $user->email,
                'documents' => [
                    [
                        'type' => $this->getDocumentType($data['cpf_cnpj']),
                        'number' => $userProfile->document_number,
                    ],
                ],
                'birthday' => $birthday,
                'phone_numbers' => [
                    '+55' . $userProfile->phone
                ]
            ]);

            $userProfile->external_id = $customer->id;
            $userProfile->save();

            DB::commit();

            return $user;
        } catch (Exception $ex) {
            DB::rollback();
            print_r($ex->__toString());
        }
    }

    /**
     * Return only numbers
     *
     * @param string $documentNumber
     */
    private function getDocumentNumber($documentNumber)
    {
        $documentNumber = substr(only_numbers($documentNumber), 0, 14);
        return $documentNumber;
    }

    /**
     * Check document type
     *
     * @param string $documentNumber
     * @return bool
     */
    private function isIndividual($documentNumber)
    {
        $documentNumber = $this->getDocumentNumber($documentNumber);
        return (bool) (strlen($documentNumber) <= 11);
    }

    /**
     * Get document type
     *
     * @param string $documentNumber
     * @param bool $abbreviate
     * @return string
     */
    private function getDocumentType($documentNumber, $abbreviate = true)
    {
        if ($this->isIndividual($documentNumber)) {
            return $abbreviate ? 'cpf' : 'individual';
        }

        return $abbreviate ? 'cnpj' : 'corporation';
    }
}
