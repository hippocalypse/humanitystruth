<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Carrier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Rules\Recaptcha;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;
use Illuminate\Foundation\Auth\RedirectsUsers;


class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $carriers = \App\Carrier::all();
        return view('auth.register', compact('carriers'));
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
        \Session::flash('warning', 'You have successfully registered. Please verify your email.'); 
        return redirect('ethics-policy');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //Session::flash('warning', 'You have successfully registered. Please verify your email.'); 
    }

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
            'phone_carrier_id' => 'nullable|string',
            'alias' => 'nullable|string|without_spaces|min:5|max:32|unique:users',
            'password' => 'required|string|min:6|confirmed'
            //'g-recaptcha-response' => ['required', new Recaptcha]
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
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phone_carrier_id' => $data['phone_carrier_id'],
            'alias' => $data['alias'],
            'password' => bcrypt($data['password']),
            'email_token' => bin2hex(random_bytes(64))
        ]);
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
        if($user->confirmEmail()){
            \Session::flash('notify', 'Thanks for verifying your email!'); 
            return view('home');
        }
    }
}
