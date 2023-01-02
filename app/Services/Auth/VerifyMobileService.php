<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyMobileService
{
    public function verify(Request $request, User $user): void
    {
        // Validate
        $request->validate([
            'code' => ['required', 'numeric', function ($attribute, $value, $fail) use ($user) {
                if ($value != $user->mobile_verification_code) $fail(__("The :attribute is incorrect", ['attribute' => $attribute]));
            }]
        ]);

        // Code is correct.
        $user->markMobileAsVerified();
    }

    public function resend(User $user)
    {

        // Resend code
        $user->sendMobileVerificationNotification();
    }
}
