<?php

namespace App\Traits;

use App\Notifications\SendTwoFactorAuthenticationCode;

trait TwoFactorAuthentication
{

    /**
     * Determine if the user has verified their 2fa.
     *
     * @return bool
     */
    public function hasVerifiedTwoFactorAuthentication()
    {
        return is_null($this->two_fa_code);
    }

    /**
     * Mark the given user 2fa as verified.
     *
     * @return bool
     */
    public function markTwoFactorAuthenticated()
    {
        $this->forceFill([
            'two_fa_code' => null,
            'two_fa_expires_at' => null,
        ])->save();
    }

    /**
     * Send the 2fa verification notification.
     *
     * @return void
     */
    public function sendTwoFactorAuthenticationNotification(string $via)
    {
        $this->forceFill([
            'two_fa_code' => rand(111111, 999999),
            'two_fa_expires_at' => now()->addMinutes(10),
        ])->save();
        $this->notify(new SendTwoFactorAuthenticationCode($via));
    }
}
