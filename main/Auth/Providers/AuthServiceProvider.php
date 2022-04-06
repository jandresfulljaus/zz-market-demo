<?php

namespace Main\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        // $this->loadTranslationsFrom(__DIR__.'/../Lang', 'auth');
        // $this->loadRoutesFrom(__DIR__.'../Routes');
        $this->loadViewsFrom(__DIR__.'/../Views', 'auth');
    }
}
