<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //app()->useStoragePath(storage_path('organizations'));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https')
        {
            // URL::forceScheme('https');
        }
        
        view()->composer('Admin.Views.nav', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        Paginator::defaultView('pagination.full');
        Paginator::defaultSimpleView('pagination.simple');

        Blade::component('fielddate', \Main\Components\Controllers\Fielddate::class);
        Blade::component('fielddatetime', \Main\Components\Controllers\Fielddatetime::class);
        Blade::component('fieldduallist', \Main\Components\Controllers\Fieldduallist::class);
        Blade::component('fieldeditor', \Main\Components\Controllers\Fieldeditor::class);
        Blade::component('fieldemail', \Main\Components\Controllers\Fieldemail::class);
        Blade::component('fieldhidden', \Main\Components\Controllers\Fieldhidden::class);
        Blade::component('fieldimage', \Main\Components\Controllers\Fieldimage::class);
        Blade::component('fieldmap', \Main\Components\Controllers\Fieldmap::class);
        Blade::component('fieldnumber', \Main\Components\Controllers\Fieldnumber::class);
        Blade::component('fieldpassword', \Main\Components\Controllers\Fieldpassword::class);
        Blade::component('fieldselect', \Main\Components\Controllers\Fieldselect::class);
        Blade::component('fieldselectajax', \Main\Components\Controllers\Fieldselectajax::class);
        Blade::component('fieldswitch', \Main\Components\Controllers\Fieldswitch::class);
        Blade::component('fieldtag', \Main\Components\Controllers\Fieldtag::class);
        Blade::component('fieldtext', \Main\Components\Controllers\Fieldtext::class);
        Blade::component('fieldtextarea', \Main\Components\Controllers\Fieldtextarea::class);
        Blade::component('fieldtextgroup', \Main\Components\Controllers\Fieldtextgroup::class);
        Blade::component('fieldurl', \Main\Components\Controllers\Fieldurl::class);
        Blade::component('tkt', \Main\Components\Controllers\Tkt::class);
        Blade::component('tktsearch', \Main\Components\Controllers\Tktsearch::class);
    }
}
