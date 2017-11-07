<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isActivated
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
        $user = Auth::user();

        if($user->activation_code != null)
            return back()->withErrors(['error' => 'Please activate your account first!']);
        else if(!$user->checkCompletion())
            return back()->withErrors(['error' => 'Please complete your account data first!']);

        return $next($request);
    }
}
