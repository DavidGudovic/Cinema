<?php

namespace App\Providers;

use App\Rules\URL_Field;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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

        Validator::extend('url_field', function ($attribute, $value, $parameters, $validator) {
            // Regular expression to match URLs with or without http/https and allow queries
            $pattern = '/^(https?:\/\/)?[a-zA-Z0-9.-]+(\.[a-zA-Z]{2,})+(\/[a-zA-Z0-9.-]*)*(\?[a-zA-Z0-9=&]*)?$/';
            return preg_match($pattern, $value);
        });
    }

}
