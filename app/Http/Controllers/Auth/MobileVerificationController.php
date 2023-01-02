<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\VerifyMobileService;

class MobileVerificationController extends Controller
{

    public function showVerifyForm()
    {
        if (Auth::user()->hasVerifiedMobile()) return redirect(RouteServiceProvider::HOME);
        return view('auth.verify-mobile');
    }

    public function verify(Request $request, VerifyMobileService $service)
    {
        $user = Auth::user();
        if ($user->hasVerifiedMobile()) return redirect(RouteServiceProvider::HOME);

        // Validate & Verify
        $service->verify($request, $user);

        // Redirect
        return redirect(RouteServiceProvider::HOME);
    }

    public function resend(VerifyMobileService $service)
    {
        $user = Auth::user();
        if ($user->hasVerifiedMobile()) return redirect(RouteServiceProvider::HOME);

        $service->resend($user);

        // return back
        return redirect()->back()->with('status', 'Code has been sent successfully');
    }
}
