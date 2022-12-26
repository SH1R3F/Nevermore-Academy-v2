<?php

namespace App\Traits;

trait HasRoles
{
    public function hasRole($name)
    {
        return $this->role?->name === $name;
    }

    public function hasPermission($slug)
    {
        return $this->role?->hasPermission($slug);
    }
}
