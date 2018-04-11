<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\SmsCode;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Jobs\SendSMSCode;

class TwoFactorLoginController extends Controller
{
   use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's 2-step login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show2FAForm(User $user)
    {
        return view('auth.two-factor-auth', compact("user"));
    }

    /**
     * Validate the users 2-factor authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validate2FA(Request $request)
    {
        $this->validate($request, [
            'sms_code' => 'required|string',
            'phone' => 'required|number',
        ]);
    }
    
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptPhoneLogin(Request $request)
    {
        return $this->guard()->attempt(
            ['phone'=> $request->email, 'password' => $request->password], $request->filled('remember')
        );
    }
    
    /**
     * Send the response after the user was authenticated by phone, prior to sms authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLogin2FAResponse(Request $request)
    {
        //needs to NOT be logged in, but pass user to two-step page
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $user = $this->guard()->user();
        
        dispatch(new SendSMSCode($user));
        
        $request->session()->flash('warning', 'Please standby for 2-factor authentication via text message..');
        
        return show2FAForm($user);
    }
    
    protected static function cleanup() {
        return SmsCode::where(['expiration', "<" , new DateTime()])->delete();
    }

    /**
     * The user is verifying their 2-factor authentication code after the initial login step
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verify(Request $request)
    {
        $this->validate2FA($request);
        
        //TODO implement throttle traffic over laravels existing decaying model
        
        if(SmsCode::where(
                    ['verification_code', $request->sms_code],
                    ['phone', $request->phone],
                    ['expiration', ">" , new DateTime()])->delete()) {
                    
            /*
            if(new DateTime() > new DateTime($verified->expiration)) {
                return sendFailed2FAResponse($request, "The 2-factor authentication code expired!");
            } */
            
            if($this->guard()->user()->confirmPhone()){
                
                $request->session()->regenerate();
                $this->clearLoginAttempts($request);

                return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
            
        return $this->sendFailed2FAResponse($request);
    }
    
    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailed2FAResponse(Request $request, $msg = null)
    {
        throw ValidationException::withMessages([
            'sms_code' => [$msg || 'Failed the 2-factor authentication code..'],
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard();
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/investigations';

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
    {
       $request->session()->flash('notify', 'Welcome back, '.$user->email);
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
