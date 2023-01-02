<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    public function user(Request $request)
    {
        // Return response
        return new UserResource($request->user()->load('role'));
    }

    public function login(Request $request)
    {
        // Validate entries
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Restrictions, throttling, etc goes here

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
                'accessToken' => $token->plainTextToken
            ]
        );
    }

    public function logout(Request $request)
    {
        // Delete token
        $request->user()->currentAccessToken()->delete();

        // Return response
        return $this->apiResponse(
            __('Logged out successfully')
        );
    }
}
