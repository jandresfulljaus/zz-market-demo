<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->namespace('Main\People\Controllers')->group(function () {
        // Person
        Route::get('personas', 'PersonController@index')->name('people.persons.list');
        Route::get('personas/crear', 'PersonController@create')->name('people.persons.create');
        Route::get('personas/editar/{id}', 'PersonController@edit')->name('people.persons.edit');
        Route::post('personas/guardar', 'PersonController@save')->name('people.persons.save');
        Route::post('personas/eliminar', 'PersonController@delete')->name('people.persons.delete');
        Route::post('personas/obtener', 'PersonController@getdata')->name('people.persons.getdata');
        Route::post('personas/ordenar', 'PersonController@sorting')->name('people.persons.sort');
        Route::get('personas/exportar', 'PersonController@sheet')->name('people.persons.sheet');
        Route::post('personas//buscar', 'PersonController@find')->name('people.persons.find');

    }
);
