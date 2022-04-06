<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('formularios')
    ->namespace('Modules\Form\Controllers')
    ->group(function () {
        // Data Update
        Route::get('actualizacion-de-datos', 'DataUpdateController@index')->name('form.data_updates.list');
        Route::get('actualizacion-de-datos/crear', 'DataUpdateController@create')->name('form.data_updates.create');
        Route::get('actualizacion-de-datos/editar/{id}', 'DataUpdateController@edit')->name('form.data_updates.edit');
        Route::get('actualizacion-de-datos/imprimir/{id}', 'DataUpdateController@print')->name('form.data_updates.print');
        Route::post('actualizacion-de-datos/guardar', 'DataUpdateController@save')->name('form.data_updates.save');
        Route::post('actualizacion-de-datos/procesar', 'DataUpdateController@process')->name('form.data_updates.process');
        Route::post('actualizacion-de-datos/eliminar', 'DataUpdateController@delete')->name('form.data_updates.delete');
        Route::post('actualizacion-de-datos/obtener', 'DataUpdateController@getdata')->name('form.data_updates.getdata');
        // Route::post('actualizacion-de-datos/ordenar', 'DataUpdateController@sorting')->name('form.data_updates.sort');
        Route::get('actualizacion-de-datos/exportar', 'DataUpdateController@sheet')->name('form.data_updates.sheet');
    }
);
