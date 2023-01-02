<?php

namespace App\Http\Middleware;

use App\Interfaces\MustVerifyMobile;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnsureMobileIsVerified
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
        // Even if this middleware is used. it won't run unless user is implementing MustVerifyMobile
        if (!Auth::user() instanceof MustVerifyMobile || (Auth::check() && Auth::user()->hasVerifiedMobile())) return $next($request); // عدي يسطا       

        if (!$request->expectsJson()) {
            return redirect()->route('verify-mobile.notice');
        }

        return $this->apiResponse(
            __('Mobile unverified'),
            [
                'verify' => route('api.verify-mobile.verify'),
                'resend' => route('api.verify-mobile.resend')
            ],
            Response::HTTP_FORBIDDEN
        );
    }
}
