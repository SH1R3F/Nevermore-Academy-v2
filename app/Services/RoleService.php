<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{

    public function store(array $data): void
    {
        // Store role
        $role = Role::create($data);

        // Store its permissions
        $role->setPermissionsBySlugs($data['permissions']);
    }

    public function update(array $data, Role $role): void
    {

        // !BREAKING CHANGE: You must not change role name for superadmin, teacher, and student
        // Any better way to do this?
        if ($role->id <= 3) unset($data['name']);

        // Update role
        $role->update($data);

        // Update its permissions
        $role->setPermissionsBySlugs($data['permissions']);
    }
}
