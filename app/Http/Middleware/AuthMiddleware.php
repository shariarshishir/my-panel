<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;

class AuthMiddleware extends Authenticate
{
   

    public function handle($request, Closure $next)
    {
        
        if (auth()->guest()) {
            return redirect()->route('admin.showLoginForm');
        }

        return $next($request);
    }
}
