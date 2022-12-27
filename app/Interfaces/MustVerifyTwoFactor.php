<?php

namespace App\Interfaces;

interface MustVerifyTwoFactor
{

    /**
     * Determine if the user has verified their 2fa.
     *
     * @return bool
     */
    public function hasVerifiedTwoFactorAuthentication();

    /**
     * Mark the given user 2fa as verified.
     *
     * @return bool
     */
    public function markTwoFactorAuthenticated();

    /**
     * Send the 2fa verification notification.
     *
     * @return void
     */
    public function sendTwoFactorAuthenticationNotification(string $via);
}
