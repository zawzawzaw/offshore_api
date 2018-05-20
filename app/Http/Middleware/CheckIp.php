<?php

namespace App\Http\Middleware;

use Closure;

class CheckIp
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

        if ($request->ip() != '219.74.46.127' && $request->ip() != '5.9.51.102' && $request->ip() != '119.74.10.62') {
            return view('permission_error');
        }

        return $next($request);
    }
}
