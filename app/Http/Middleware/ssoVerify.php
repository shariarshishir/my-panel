<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;




class ssoVerify
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
        if(env('APP_ENV') == 'production')
        {
            if ( Cookie::has('sso_token') == true) {
                return $next($request);
            }
            Auth::guard('web')->logout();
            return redirect('/login');
        }
        return $next($request);

    }
}
