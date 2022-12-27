<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MustVerifyTwoFactor;

class TwoFactorAuthentication
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
        $user = Auth::user();

        if (
            !$user instanceof MustVerifyTwoFactor || // If not implementing interface
            $user->hasVerifiedTwoFactorAuthentication() || // Already verified
            (!$user->hasVerifiedMobile() && !$user->hasVerifiedEmail()) // Has nothing verified yet. (We don't want to lock him out)
        ) return $next($request);

        return redirect()->route('2fa.choose');
    }
}
