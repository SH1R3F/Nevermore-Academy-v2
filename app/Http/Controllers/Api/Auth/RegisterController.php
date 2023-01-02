<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rules\File;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{

    use PasswordValidationRules;

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'mobile' => [
                'required',
                'regex:' . User::MOBILE_FORMAT,
                'unique:users',
            ],
            'password' => $this->passwordRules(),
            'image' => ['required', File::types(['jpg', 'png', 'gif'])->max(12 * 1024)]
        ]);

        // Create user
        $user = User::create(['role_id' => 3] + $data);

        event(new Registered($user));

        // Issue token
        $token = $user->createToken('accessToken');

        // Return response
        return $this->apiResponse(
            __('User registered successfully'),
            [
                'accessToken' => $token->plainTextToken,
                'user' => new UserResource($user)
            ]
        );
    }
}
