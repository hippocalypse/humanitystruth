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
            if(!$instance->isTorActive()) {
                return redirect()->route('securedrop.help')->with('error', 'SecureDrop is only accessible via Tor');
            }
            //passthru
        } catch (\Exception $e) {
            return redirect()->route('securedrop.help')->with('error', 'SecureDrop is only accessible via Tor');
        }
        return $next($request);
    }
}
