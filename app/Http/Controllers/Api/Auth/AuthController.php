<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        dd('asdads');
        // Validate entries
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Attempt login
        if (!Auth::attempt($data)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        // Issue token
        $token = $request->user()->createToken('accessToken');

        // Return response
        return $this->apiResponse(
            __('Logged in successfully'),
            [
                'accessToken' => $token
            ]
        );
    }
}
