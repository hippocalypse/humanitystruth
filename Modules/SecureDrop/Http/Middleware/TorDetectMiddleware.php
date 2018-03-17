<?php

namespace Modules\SecureDrop\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\SecureDrop\Resources\assets\TorDetect;

class TorDetectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $instance = TorDetect\TorDetect::getInstance();
            if(!$instance->isTorActive()) return redirect()->route('securedrop.help');
            
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->route('securedrop.help');
        }
        return $next($request);
    }
}
