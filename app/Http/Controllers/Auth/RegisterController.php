<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:20'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:50', 'confirmed'],
            'lastname' => ['required', 'string', 'max:20'],
            'firstname' => ['required', 'string', 'max:20'],
            'zip21' => ['required', 'string', 'max:3'],
            'zip22' => ['required', 'string', 'max:4'],
            'pref21' => ['required', 'string', 'max:50'],
            'addr21' => ['required', 'string', 'max:50'],
            'strt21' => ['required', 'string', 'max:255'],
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
        return User::create([
            'name' => $data['name'],
            //'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'postcode' => $data['zip21'].$data['zip22'],
            'address1' => $data['pref21'],
            'address2' => $data['addr21'],
            'address3' => $data['strt21'],
        ]);
    }

    public function messages() {
        return [
            'name' => "アカウント名",
        ];
      }
}
