<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\VerifyMobileService;
use Illuminate\Http\Request;

class MobileVerificationController extends Controller
{
    public function verify(Request $request, VerifyMobileService $service)
    {
        $user = $request->user();
        if ($user->hasVerifiedMobile()) {
            return $this->apiResponse(__('Mobile is already verified'));
        }

        // Validate & Verify
        $service->verify($request, $user);

        // Redirect
        return $this->apiResponse(__('Mobile verified successfully'));
    }

    public function resend(Request $request, VerifyMobileService $service)
    {
        $user = $request->user();
        if ($user->hasVerifiedMobile()) return $this->apiResponse(__('Mobile is already verified'));

        $service->resend($user);

        // return back
        return $this->apiResponse(__('Code has been sent successfully'));
    }
}
