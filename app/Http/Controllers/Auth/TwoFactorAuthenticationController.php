<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;

class TwoFactorAuthenticationController extends Controller
{

    /**
     * Allow user to choose how to receive his code
     * Either via mail or via sms
     */
    public function showChooseForm()
    {
        if (!$this->shouldIBeHere()) return redirect(RouteServiceProvider::HOME);
        return view('auth.2fa-choose');
    }

    /**
     * Send the 2fa code via the way he chose
     */
    public function send(Request $request)
    {
        if (!$this->shouldIBeHere()) return redirect(RouteServiceProvider::HOME);

        $user = Auth::user();
        $request->validate(['choice' => ['required', 'in:sms,mail']]);

        $user->sendTwoFactorAuthenticationNotification($request->choice);
        Session::put('2fa_choice', $request->choice);

        return redirect()->route('2fa.notice')->with('status', "A verification code has been sent via {$request->choice}");
    }

    /**
     * Allow user to enter the code he received
     */
    public function showVerifyForm()
    {
        if (!$this->shouldIBeHere()) return redirect(RouteServiceProvider::HOME);
        return view('auth.2fa-verify');
    }

    /**
     * Check the code and allow him to login if correct
     */
    public function verify(Request $request)
    {
        if (!$this->shouldIBeHere()) return redirect(RouteServiceProvider::HOME);

        $user = Auth::user();
        $request->validate([
            'code' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($user) {
                    // Check equal validity
                    if ($value != $user->two_fa_code) $fail("The $attribute is incorrect");

                    // Check time validity
                    if ($user->two_fa_expires_at->lt(now())) $fail("The $attribute is expired");
                }
            ]
        ]);

        // Code is correct
        $user->markTwoFactorAuthenticated();

        return redirect(RouteServiceProvider::HOME);
    }


    /**
     * Resend verification code
     */
    public function resend()
    {
        if (!$this->shouldIBeHere()) return redirect(RouteServiceProvider::HOME);
        if (Session::has('2fa_choice')) Auth::user()->sendTwoFactorAuthenticationNotification(session('2fa_choice'));
        return redirect()->back()->with('status', "A verification code has been resent");
    }

    public function shouldIBeHere()
    {
        $user = Auth::user();
        return !(!$user instanceof MustVerifyTwoFactor || // If not implementing interface
            $user->hasVerifiedTwoFactorAuthentication() || // Already verified
            (!$user->hasVerifiedMobile() && !$user->hasVerifiedEmail()) // Has nothing verified yet. (We don't want to lock him out)
        );
    }
}
