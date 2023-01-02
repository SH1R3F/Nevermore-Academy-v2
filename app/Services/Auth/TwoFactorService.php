<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;

class TwoFactorService
{
    public function verify(Request $request, User $user): void
    {
        // Validate
        $request->validate([
            'code' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($user) {
                    // Check equal validity
                    if ($value != $user->two_fa_code) return $fail(__("The :attribute is incorrect", ['attribute' => $attribute]));

                    // Check time validity
                    if ($user->two_fa_expires_at->lt(now())) return $fail(__("The :attribute is expired", ['attribute' => $attribute]));
                }
            ]
        ]);

        // Code is correct
        $user->markTwoFactorAuthenticated();
    }

    public function send(Request $request, User $user)
    {
        $request->validate(['choice' => ['required', 'in:sms,mail']]);
        $user->sendTwoFactorAuthenticationNotification($request->choice);
    }
}
