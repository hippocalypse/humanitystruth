<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Carrier;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Rules\Recaptcha;
use App\NewsletterSubscription;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Jobs\SendVerificationEmail;
use Illuminate\Foundation\Auth\RedirectsUsers;
use App\Mail\EmailSMSCode;


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
        $carriers = Carrier::all();
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
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|integer|min:10|unique:users',
            'phone_carrier_id' => 'required|integer',
            'alias' => 'required|string|without_spaces|min:5|max:32|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => ['required', new Recaptcha]
        ]);
        
        $user = User::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_carrier_id' => $request->phone_carrier_id,
            'alias' => $request->alias,
            'password' => bcrypt($request->password),
            'email_token' => bin2hex(random_bytes(64))
        ]);

        event(new Registered($user));
        
        dispatch(new SendVerificationEmail($user));

        //if user provided phone
        if(strlen($user->phone) >= 10) dispatch(new EmailSMSCode($user));

        return redirect('/profiles/' . $user->alias );
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
        \Session::flash('warning', 'You have successfully registered! Please verify your email ' . (strlen($user->phone) < 10 ?: "and phone "). 'before utilizing the site.'); 
    }
    
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
    * Handle a registration verification request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */
    public function verify($token)
    {
        //validate first
        $user = User::where('email_token',$token)->first();
        if($user->confirmEmail()){
            //add user to subscriptions
            if(!NewsletterSubscription::where('email_id', $user->id)->count()) {
                    NewsletterSubscription::create([
                    'email_id' => $user->id,
                    'authenticated' => true
                ]);
            }
            
            return Redirect::back()->with('notify', 'Thanks for verifying your email!');
        }
    }
}
