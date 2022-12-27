<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
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
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'mobile' => $input['mobile'],
            'mobile_verification_code' => rand(111111, 999999),
            'password' => Hash::make($input['password']),
            'role_id' => 3
        ]);

        // Upload profile picture
        $user->addMediaFromRequest('image')->toMediaCollection('images');

        event(new Registered($user));

        return $user;
    }
}
