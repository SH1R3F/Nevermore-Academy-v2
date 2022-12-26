<?php

namespace App\Services;

use App\Models\User;

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
    }

    public function update(array $data, User $user): void
    {
        // Password is optional to be updated
        if (!$data['password']) unset($data['password']);

        // You must not change superadmin role
        // Any better way to do this?
        if (!$user->hasRole('superadmin')) $data['role_id'] = $data['role'];

        // Update user
        $user->update($data);
    }
}
