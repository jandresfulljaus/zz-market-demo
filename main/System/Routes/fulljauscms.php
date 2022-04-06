<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->namespace('Main\System\Controllers')->group(function () {
    // Log
    Route::get('logs', 'LogController@index')->name('system.logs.list');
    Route::get('logs/crear', 'LogController@create')->name('system.logs.create');
    Route::get('logs/editar/{id}', 'LogController@edit')->name('system.logs.edit');
    Route::post('logs/guardar', 'LogController@save')->name('system.logs.save');
    Route::post('logs/eliminar', 'LogController@delete')->name('system.logs.delete');
    Route::post('logs/obtener', 'LogController@getdata')->name('system.logs.getdata');
    Route::post('logs/ordenar', 'LogController@sorting')->name('system.logs.sort');
    Route::get('logs/exportar', 'LogController@sheet')->name('system.logs.sheet');
});
