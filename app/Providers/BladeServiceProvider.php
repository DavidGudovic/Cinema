<?php

namespace App\Providers;

use App\Enums\Roles;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
    * Register services.
    */
    public function register(): void
    {
        //
    }

    /**
    * Bootstrap services.
    */
    public function boot(): void
    {
        /*
         @role('ADMIN')
         @endrole
        */
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role->value == $role;
        });

        /*
        * @clientorguest
        */
        Blade::if('clientorguest', function () {
            return auth()->user() ? auth()->user()->role == Roles::CLIENT : true;
        });
    }
}
