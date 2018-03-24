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

class LoginController extends Controller
{
   use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
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
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
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
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
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
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
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
    
    
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

            //attempt login with email and password
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
            
            //otherwise try as phone credentials
        } elseif ($this->attemptPhoneLogin($request)) {
            //dispatch a new code to this users
            return $this->sendLogin2FAResponse($request);
        } 

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
        
        //todo implement throttle traffic over laravels existing decaying model
        
        if(SmsCode::where(
                    ['verification_code', $request->sms_code],
                    ['phone', $request->phone],
                    ['expiration', "<" , new DateTime()])->delete()) {
                    
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
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
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
