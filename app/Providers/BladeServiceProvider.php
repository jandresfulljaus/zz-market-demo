<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setAllowDirective();
    }

    public function setAllowDirective()
    {
        Blade::if('allow', function ($arguments) {
            $arguments = parseDirectiveParams($arguments);

            $routes = @$arguments[0];
            $routes = empty($routes[0])?[]:$routes;

            $roles = @$arguments[1];
            $roles = empty($roles[0])?[]:$roles;

            // agrego los roles de admin de fulljaus
            $roles[] = 'root';

            $currentRoles = auth()->user()->role()->where("status", 1)->get()->keyBy("slug")->toArray();
            $currentRoles = array_keys($currentRoles);

            // si no está logueado
            if(!auth()->check()) return false;

            // si tiene los roles
            if (!empty($roles)) {
                if (count(array_intersect($currentRoles, $roles)) > 0) return true;
            }

            // para cada ruta
            if (!empty($routes)) {
                foreach ($routes as $route) {
                    if(auth()->user()->can('{ $route }')) return true;
                }
            }

            return false;
        });

    }
}
