<?php

namespace App\Traits;

use App\Notifications\VerifyMobile;

trait MustVerifyMobile
{
    /**
     * Determine if the user has verified their mobile number.
     *
     * @return bool
     */
    public function hasVerifiedMobile()
    {
        return !is_null($this->mobile_verified_at);
    }

    /**
     * Mark the given user's mobile as verified.
     *
     * @return bool
     */
    public function markMobileAsVerified()
    {
        return $this->forceFill([
            'mobile_verified_at' => now(),
            'mobile_verification_code' => null
        ])->save();
    }

    /**
     * Send the mobile verification notification.
     *
     * @return void
     */
    public function sendMobileVerificationNotification()
    {
        // Generate new code [OPTIONAL]
        $this->update(['mobile_verification_code' => rand(111111, 999999)]);
        $this->notify(new VerifyMobile);
    }

    /**
     * Get the mobile number that should be used for verification.
     *
     * @return string
     */
    public function getMobileForVerification()
    {
        return $this->mobile;
    }
}
