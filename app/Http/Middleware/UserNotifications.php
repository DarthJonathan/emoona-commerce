<?php

namespace App\Http\Middleware;

use Closure;
Use Illuminate\Support\Facades\Session;
use App\User;

class UserNotifications
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
        Session::put('notifications', User::getNotifications());

        return $next($request);
    }
}
