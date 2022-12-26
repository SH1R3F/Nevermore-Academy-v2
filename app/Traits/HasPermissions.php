<?php

namespace App\Traits;

use App\Models\Permission;

trait HasPermissions
{
    public function hasPermission($slug): bool
    {
        return $this->permissions->contains('slug', $slug);
    }

    public function setPermissionsBySlugs(array $slugs): void
    {
        $ids = Permission::whereIn('slug', $slugs)->pluck('id');
        $this->permissions()->sync($ids);
    }
}
