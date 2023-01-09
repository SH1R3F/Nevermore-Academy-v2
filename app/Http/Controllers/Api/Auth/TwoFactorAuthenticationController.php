<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\TwoFactorService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TwoFactorAuthenticationController extends Controller
{

    use ApiResponse;
    /**
     * Check the code and allow him to login if correct
     */
    public function verify(Request $request, TwoFactorService $service)
    {
        if ($this->iShouldntBeHere()) return $this->apiResponse(__('Already authenticated'));

        $service->verify($request, $request->user());

        return $this->apiResponse(__('Verified successfully'));
    }


    /**
     * Send the 2fa code via the way he chose
     */
    public function send(Request $request, TwoFactorService $service)
    {
        if ($this->iShouldntBeHere()) return $this->apiResponse(__('Already authenticated'));

        $service->send($request, $request->user());

        return $this->apiResponse(__("A verification code has been sent via :choice", ['choice' => $request->choice]));
    }

    public function iShouldntBeHere()
    {
        $user = request()->user();
        return (!$user instanceof MustVerifyTwoFactor || // If not implementing interface
            $user->hasVerifiedTwoFactorAuthentication() || // Already verified
            (!$user->hasVerifiedMobile() && !$user->hasVerifiedEmail()) // Has nothing verified yet. (We don't want to lock him out)
        );
    }
}
