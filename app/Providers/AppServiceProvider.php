<?php

namespace App\Providers;

use App\Models\Advert;
use App\Models\Screening;
use App\Models\BusinessRequest;
use App\Observers\AdvertObserver;
use App\Observers\ScreeningObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Observers\BusinessRequestObserver;

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
        /* Linux/Windows language codes are different*/
        if (app()->environment('production')) {
            setlocale(LC_TIME, 'sr_RS@latin');
        } else {
            setlocale(LC_TIME, 'sr_Latn_RS.UTF-8');
        }

        /* Custom validation rules */
        Validator::extend('url_field', function ($attribute, $value, $parameters, $validator) {
            $pattern = '/^(https?:\/\/)?[a-zA-Z0-9.-]+(\.[a-zA-Z]{2,})+(\/[a-zA-Z0-9.-]*)*(\?[a-zA-Z0-9=&]*)?$/'; // url
            return preg_match($pattern, $value);
        });

        /* Observers */
        Advert::observe(AdvertObserver::class);
        Screening::observe(ScreeningObserver::class);
        BusinessRequest::observe(BusinessRequestObserver::class);
    }

}
