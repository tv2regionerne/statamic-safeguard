<?php

namespace Tv2regionerne\StatamicSafeguard\Auth;

use Illuminate\Support\Collection;

class User extends \Statamic\Auth\Eloquent\User
{
    public function isSuper()
    {
        if (! in_array($this->email, config('statamic-safeguard.super'))) {
            return false;
        }

        return parent::isSuper();
    }

    public function permissions()
    {
        /** @var Collection $permissions */
        $permissions = $this->groups()->flatMap->roles()
            ->merge($this->roles())
            ->flatMap->permissions();

        if ($this->get('super')) {
            $permissions[] = 'super';
        }

        return $permissions->filter(function ($permission) {
            return ! in_array($permission, config('statamic-safeguard.permissions.disallow'));
        })->values();
    }
}
