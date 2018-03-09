<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Rules\Recaptcha;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;


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
    protected $redirectTo = '/';
    
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
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|integer|min:10|unique:users',
            'alias' => 'nullable|string|max:32|unique:users',
            'password' => 'required|string|min:6|confirmed'
            // 'g-recaptcha-response' => ['required', new Recaptcha],
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
        session()->flash('warning', "You're almost done! Please check your email for a verification link..");
        return User::create([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'alias' => $data['alias'],
            'password' => bcrypt($data['password']),
            'email_token' => base64_encode($data['email']),
            'role' => 'inactive',

        ]);
        
    }

    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        dispatch(new SendVerificationEmail($user));
        Session::flash('warning', 'You have successfully registered. Please verify your email.'); 
        return view('home');
    }
    
    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->role = 'email_verified';
        if($user->save()){
            Session::flash('notify', 'Thanks for verifying your email!'); 
            return view('home');
        }
    }
}
