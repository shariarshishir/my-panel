<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'admin')
    {
        if ($guard == "admin" && Auth::guard($guard)->check()) {
            return $next($request);
        }

        return redirect()->route('admin.showLoginForm')->withErrors("You don't have admin access.");
    }
}
