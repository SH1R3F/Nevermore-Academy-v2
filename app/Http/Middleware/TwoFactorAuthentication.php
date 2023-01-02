<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MustVerifyTwoFactor;

class TwoFactorAuthentication
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (
            !$user instanceof MustVerifyTwoFactor || // If not implementing interface
            $user->hasVerifiedTwoFactorAuthentication() || // Already verified
            (!$user->hasVerifiedMobile() && !$user->hasVerifiedEmail()) // Has nothing verified yet. (We don't want to lock him out)
        ) return $next($request);

        if (!$request->expectsJson()) {
            return redirect()->route('2fa.choose');
        }

        return $this->apiResponse(
            __('2 factor authentication'),
            [
                'verify' => route('api.2fa.verify'),
                'resend' => route('api.2fa.send')
            ],
            Response::HTTP_FORBIDDEN
        );
    }
}
