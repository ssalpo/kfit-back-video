<?php

namespace App\Utils\User;

use Illuminate\Support\Collection;

class ApiUser
{
    private Collection $user;

    private array $roles;

    public function setUser(array $user)
    {
        $this->user = collect($user);

        $this->roles = array_column($this->user->get('roles', []), 'name');
    }

    public function __get(string $name)
    {
        return $this->user->get($name);
    }

    public function hasRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if (in_array($role, $this->roles, true)) {
                return true;
            }
        }

        return false;
    }

    public function isClient(): bool
    {
        return $this->id && count($this->roles) === 0;
    }
}
