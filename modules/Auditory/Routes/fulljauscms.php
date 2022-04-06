<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->namespace('Modules\Auditory\Controllers')->group(function () {
    // Auditory
    Route::get('auditoria', 'AuditoryController@index')->name('auditory.list');
    Route::get('auditoria/crear', 'AuditoryController@create')->name('auditory.create');
    Route::get('auditoria/editar/{id}', 'AuditoryController@edit')->name('auditory.edit');
    Route::post('auditoria/guardar', 'AuditoryController@save')->name('auditory.save');
    Route::post('auditoria/eliminar', 'AuditoryController@delete')->name('auditory.delete');
    Route::post('auditoria/obtener', 'AuditoryController@getdata')->name('auditory.getdata');
    Route::post('auditoria/ordenar', 'AuditoryController@sorting')->name('auditory.sort');
    Route::get('auditoria/exportar', 'AuditoryController@sheet')->name('auditory.sheet');
});
