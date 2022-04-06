<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

Route::middleware(['auth'])->namespace('Main\Admin\Controllers')->group(function () {
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::get('/icons', 'HomeController@icons')->name('admin.icons');
   
    Route::get('locale/{locale}', 'HomeController@locale')->name('admin.locale');
    

    Route::get('perfil', 'HomeController@profile')->name('admin.profile.edit');
    Route::post('perfil', 'HomeController@saveprofile')->name('admin.profile.save');

    Route::get('perfil/notificaciones', 'NotificationController@index')->name('admin.notifications.index');
    Route::patch('perfil/notificaciones/marcar-leidas', 'NotificationController@readSelected')->name('admin.notifications.read-selected');
    Route::patch('perfil/notificaciones/marcar-no-leidas', 'NotificationController@unreadSelected')->name('admin.notifications.unread-selected');
    Route::get('perfil/notificaciones/{id}', 'NotificationController@show')->name('admin.notifications.show');
    Route::patch('perfil/notificaciones/{id}/marcar-leida', 'NotificationController@read')->name('admin.notifications.read');
    Route::patch('perfil/notificaciones/{id}/marcar-no-leida', 'NotificationController@unread')->name('admin.notifications.unread');

    // Listado de actividad
    Route::get('perfil/actividad', 'HomeController@activity')->name('admin.activity.list');
    Route::get('perfil/sesiones', 'HomeController@sessions')->name('admin.sessions.list');

    // Actualizar rutas
    Route::get('updateroutes', 'HomeController@updateroutes')->name('admin.updateroutes');

    // Info de php
    Route::get('phpinfo', 'HomeController@phpinfo')->name('admin.phpinfo');

    // Fallback
    Route::fallback('HomeController@error404');
});
