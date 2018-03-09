<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Admin
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
        if(Auth::User()->role != 'admin' && Auth::User()->role != 'super_admin') {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
