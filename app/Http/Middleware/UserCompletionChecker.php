<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class UserCompletionChecker
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
        echo '<pre>';
        print_r(User::find(1));
        return $next($request);
    }
}
