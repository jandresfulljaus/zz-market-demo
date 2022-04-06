<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('geo')
    ->namespace('Main\Geo\Controllers')
    ->group(function () {
        // Country
        Route::get('paises', 'CountryController@index')->name('geo.countries.list');
        Route::get('paises/crear', 'CountryController@create')->name('geo.countries.create');
        Route::get('paises/editar/{id}', 'CountryController@edit')->name('geo.countries.edit');
        Route::post('paises/guardar', 'CountryController@save')->name('geo.countries.save');
        Route::post('paises/eliminar', 'CountryController@delete')->name('geo.countries.delete');
        Route::post('paises/obtener', 'CountryController@getdata')->name('geo.countries.getdata');
        Route::post('paises/ordenar', 'CountryController@sorting')->name('geo.countries.sort');
        Route::get('paises/exportar', 'CountryController@sheet')->name('geo.countries.sheet');

        // Region
        Route::get('provincias', 'RegionController@index')->name('geo.regions.list');
        Route::get('provincias/crear', 'RegionController@create')->name('geo.regions.create');
        Route::get('provincias/editar/{id}', 'RegionController@edit')->name('geo.regions.edit');
        Route::post('provincias/guardar', 'RegionController@save')->name('geo.regions.save');
        Route::post('provincias/eliminar', 'RegionController@delete')->name('geo.regions.delete');
        Route::post('provincias/obtener', 'RegionController@getdata')->name('geo.regions.getdata');
        Route::post('provincias/ordenar', 'RegionController@sorting')->name('geo.regions.sort');
        Route::get('provincias/exportar', 'RegionController@sheet')->name('geo.regions.sheet');

        // City
        Route::get('ciudades', 'CityController@index')->name('geo.cities.list');
        Route::get('ciudades/crear', 'CityController@create')->name('geo.cities.create');
        Route::get('ciudades/editar/{id}', 'CityController@edit')->name('geo.cities.edit');
        Route::post('ciudades/guardar', 'CityController@save')->name('geo.cities.save');
        Route::post('ciudades/eliminar', 'CityController@delete')->name('geo.cities.delete');
        Route::post('ciudades/obtener', 'CityController@getdata')->name('geo.cities.getdata');
        Route::post('ciudades/ordenar', 'CityController@sorting')->name('geo.cities.sort');
        Route::get('ciudades/exportar', 'CityController@sheet')->name('geo.cities.sheet');
    }
);
