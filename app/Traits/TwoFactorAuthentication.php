<?php

namespace App\Traits;

use App\Notifications\SendTwoFactorAuthenticationCode;
use Illuminate\Support\Facades\Cache;

trait TwoFactorAuthentication
{

    /**
     * Determine if the user has verified their 2fa.
     *
     * @return bool
     */
    public function hasVerifiedTwoFactorAuthentication()
    {
        if (request()->expectsJson()) {
            $data = Cache::get("user_{$this->id}_2fa");
            if ($data) {
                return is_null($data['two_fa_code']);
            }
            return false;
        } else {
            return is_null($this->two_fa_code);
        }
    }

    /**
     * Mark the given user 2fa as verified.
     *
     * @return bool
     */
    public function markTwoFactorAuthenticated()
    {
        if (request()->expectsJson()) {
            Cache::put("user_{$this->id}_2fa", [
                'two_fa_code' => null,
                'two_fa_expires_at' => null
            ], 60 * 60 * 24);
        } else {
            $this->forceFill([
                'two_fa_code' => null,
                'two_fa_expires_at' => null,
            ])->save();
        }
    }

    /**
     * Send the 2fa verification notification.
     *
     * @return void
     */
    public function sendTwoFactorAuthenticationNotification(string $via)
    {
        if (request()->expectsJson()) {
            Cache::put("user_{$this->id}_2fa", [
                'two_fa_code' => $code = rand(111111, 999999),
                'two_fa_expires_at' => now()->addMinutes(10),
            ], 60 * 60 * 24);
        } else {
            $this->forceFill([
                'two_fa_code' => $code = rand(111111, 999999),
                'two_fa_expires_at' => now()->addMinutes(10),
            ])->save();
        }
        $this->notify(new SendTwoFactorAuthenticationCode($via, $code));
    }
}
