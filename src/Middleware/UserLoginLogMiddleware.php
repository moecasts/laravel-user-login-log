<?php

namespace Moecasts\Laravel\UserLoginLog\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserLoginLogMiddleware
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
        if (Auth::check()) {
            $user = Auth::user();
            $user->logLogin();
        }
        return $next($request);
    }
}
