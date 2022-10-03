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

        $this->roles = array_column($this->user->get('roles'), 'name');
    }

    public function __get(string $name)
    {
        return $this->user->get($name);
    }

    public function hasRole(string $name): bool
    {
        foreach (explode(',', $name) as $role) {
            if (in_array($role, $this->roles)) return true;
        }

        return false;
    }

    public function isClient(): bool
    {
        return count($this->roles) === 0;
    }
}
