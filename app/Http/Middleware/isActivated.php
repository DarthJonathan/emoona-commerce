<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;
use Request;

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
        {
            Session::put('backUrl', Request::fullUrl());            
            return redirect('profile/edit')->withErrors(['error' => 'Please complete your account data first!']);
        }

        return $next($request);
    }
}
