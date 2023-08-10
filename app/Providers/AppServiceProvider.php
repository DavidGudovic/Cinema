<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    */
    public function register(): void
    {
        //
    }

    /**
    * Bootstrap any application services.
    */
    public function boot(): void
    {

        if (app()->environment('production')) {
            setlocale(LC_TIME, 'sr_RS@latin');
        } else {
            setlocale(LC_TIME, 'sr_Latn_RS.UTF-8');
        }

    }
}
