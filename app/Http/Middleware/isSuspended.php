<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class isSuspended
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
        $suspended = User::with('user_info')->where('id', '=', Auth::id())->get()->toArray()[0]['user_info']['suspended'];

        if($suspended == 1) {
            Auth::logout();
            return Redirect::to('suspended');
        }

        return $next($request);
    }
}
