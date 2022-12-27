<?php

namespace App\Http\Middleware;

use App\Interfaces\MustVerifyMobile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureMobileIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Even if this middleware is used. it won't run unless user is implementing MustVerifyMobile
        if (!Auth::user() instanceof MustVerifyMobile || (Auth::check() && Auth::user()->hasVerifiedMobile())) return $next($request); // عدي يسطا       

        return redirect()->route('verify-mobile.notice');
    }
}
