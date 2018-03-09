<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class VerifiedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::User() == null) return redirect()->route('login');
        
        if(Auth::User()->role == 'closed' || Auth::User()->role == 'inactive') {
            Session::flash('error', 'Please verify your account first');
            return redirect()->route('home');
        }
        
        return $next($request);
    }
}
