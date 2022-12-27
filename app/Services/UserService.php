<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\MustVerifyMobile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UserService
{

    public function store(array $data): void
    {
        // Hash password
        $data['password'] = bcrypt($data['password']);

        // Store user
        $user = User::create($data);

        // Associate to role
        $user->role()->associate($data['role']);

        // Fire event for user creation here when you need to.
        event(new Registered($user));
    }

    public function update(array $data, User $user): void
    {
        if (isset($data['password']) && $data['password']) {
            // Hash password
            $data['password'] = bcrypt($data['password']);
        } else {
            // Password is optional to be updated
            unset($data['password']);
        }

        // Upload profile picture
        if (isset($data['image'])) $user->clearMediaCollectionExcept('images', $user->addMediaFromRequest('image')->toMediaCollection('images'));

        // You must not change superadmin role
        // Any better way to do this?
        if (!$user->hasRole('superadmin')) $data['role_id'] = $data['role'];

        $this->ensureToVerifyAgainIfNeeded($user, $data);

        // Update user
        $user->update($data);
    }

    private function ensureToVerifyAgainIfNeeded(User $user, array $data)
    {
        // When you change his email. User must verify again!
        if ($data['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                'email_verified_at' => null,
                'email' => $data['email']
            ]);
            $user->sendEmailVerificationNotification();
        }
        // When you change his mobile. User must verify again!
        if ($data['mobile'] !== $user->mobile && $user instanceof MustVerifyMobile) {
            $user->forceFill([
                'mobile_verified_at' => null,
                'mobile_verification_code' => rand(111111, 999999),
                'mobile' => $data['mobile']
            ]);
            $user->sendMobileVerificationNotification();
        }
    }
}
