<?php

namespace Soft1c\Date;

use Illuminate\Support\ServiceProvider;

class DateServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->app->bind(\Soft1c\Date\Date::class, function ($app){
            $date = new Date();
            $date->setLocale(config('app.locale'));

            return $date;
        });

    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Nothing.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Date'];
    }
}
