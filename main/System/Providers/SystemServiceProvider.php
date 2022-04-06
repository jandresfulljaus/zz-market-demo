<?php

namespace Main\System\Providers;

use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
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
        // $this->loadTranslationsFrom(__DIR__.'/../Lang', 'system');
        // $this->loadRoutesFrom(__DIR__.'../Routes');
        $this->loadViewsFrom(__DIR__.'/../Views', 'system');
    }
}
