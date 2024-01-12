<?php

namespace Tv2regionerne\StatamicSafeguard;

use Statamic\Providers\AddonServiceProvider;
use Tv2regionerne\StatamicSafeguard\Auth\User;
use Tv2regionerne\StatamicSafeguard\Commands\UpdateDiskPermissions;

class ServiceProvider extends AddonServiceProvider
{


    protected $commands = [
        UpdateDiskPermissions::class,
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/statamic-safeguard.php', 'statamic-safeguard');

        if ($this->app->environment(config('statamic-safeguard.environments'))) {
            $this->app->bind(\Statamic\Contracts\Auth\User::class, User::class);
        }
    }

    public function bootAddon()
    {

    }
}
