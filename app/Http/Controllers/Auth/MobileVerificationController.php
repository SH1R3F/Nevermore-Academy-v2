<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class MobileVerificationController extends Controller
{

    public function showVerifyForm()
    {
        if (Auth::user()->hasVerifiedMobile()) return redirect(RouteServiceProvider::HOME);
        return view('auth.verify-mobile');
    }

    public function verify(Request $request)
    {
        $user = Auth::user();
        if ($user->hasVerifiedMobile()) return redirect(RouteServiceProvider::HOME);

        $request->validate([
            'code' => ['required', 'numeric', function ($attribute, $value, $fail) use ($user) {
                if ($value != $user->mobile_verification_code) $fail("The $attribute is incorrect");
            }]
        ]);

        // Code is correct.
        $user->markMobileAsVerified();

        // Redirect
        return redirect(RouteServiceProvider::HOME);
    }

    public function resend()
    {
        $user = Auth::user();
        if ($user->hasVerifiedMobile()) return redirect(RouteServiceProvider::HOME);

        // Resend code
        $user->sendMobileVerificationNotification();

        // return back
        return redirect()->back()->with('status', 'Code has been sent successfully');
    }
}
