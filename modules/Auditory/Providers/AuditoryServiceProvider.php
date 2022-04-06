<?php

namespace Modules\Auditory\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auditory\Models\Auditory;

class AuditoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Auditory::class, function ($app) {
            $auditory = new Auditory();
            $auditory->setInitialParams();
            return $auditory;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        // $this->loadTranslationsFrom(__DIR__.'/../Lang', 'auditory');
        // $this->loadRoutesFrom(__DIR__.'../Routes');
        $this->loadViewsFrom(__DIR__.'/../Views', 'auditory');
    }
}
