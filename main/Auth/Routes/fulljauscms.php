<?php

use Illuminate\Support\Facades\Route;

Route::get('login', 'Main\Auth\Controllers\LoginController@showLogin')->name('auth.login');
Route::post('login', 'Main\Auth\Controllers\LoginController@login')->name('auth.do_login');
Route::get('logout', 'Main\Auth\Controllers\LoginController@logout')->name('auth.logout');

Route::middleware(['auth'])->namespace('Main\Auth\Controllers')->group(function () {
    // Login as other user
    Route::get('/loginas', 'LoginController@loginas')->name('auth.loginas');

    // Users
    Route::get('usuarios', 'UserController@index')->name('auth.users.list');
    Route::get('usuarios/crear', 'UserController@create')->name('auth.users.create');
    Route::get('usuarios/editar/{id}', 'UserController@edit')->name('auth.users.edit');
    Route::post('usuarios/eliminar', 'UserController@delete')->name('auth.users.delete');
    Route::post('usuarios/guardar', 'UserController@save')->name('auth.users.save');
    Route::post('usuarios/obtener', 'UserController@getdata')->name('auth.users.getdata');
    Route::post('usuarios/ordenar', 'UserController@sorting')->name('auth.users.sort');
    Route::get('usuarios/exportar', 'UserController@sheet')->name('auth.users.sheet');
    Route::post('usuarios/por-oficina', 'UserController@getFromDepartment')->name('auth.users.get-from-department');

    // Organization
    Route::get('solicitantes', 'OrganizationController@index')->name('auth.organizations.list');
    Route::get('solicitantes/crear', 'OrganizationController@create')->name('auth.organizations.create');
    Route::get('solicitantes/editar/{id}', 'OrganizationController@edit')->name('auth.organizations.edit');
    Route::post('solicitantes/guardar', 'OrganizationController@save')->name('auth.organizations.save');
    Route::post('solicitantes/eliminar', 'OrganizationController@delete')->name('auth.organizations.delete');
    Route::post('solicitantes/obtener', 'OrganizationController@getdata')->name('auth.organizations.getdata');
    Route::post('solicitantes/obtener/orden', 'OrganizationController@mygetdata')->name('auth.organizations.mygetdata');
    Route::post('solicitantes/ordenar', 'OrganizationController@sorting')->name('auth.organizations.sort');
    Route::get('solicitantes/ordenar', 'OrganizationController@sheet')->name('auth.organizations.sheet');

    // Sucursales
    Route::get('/destinatarios', 'BranchController@index')->name('auth.branches.list');
    Route::get('/destinatario/nuevo', 'BranchController@create')->name('auth.branches.create');
    Route::get('/destinatario/editar/{id}', 'BranchController@edit')->name('auth.branches.edit');
    Route::post('/destinatario/guardar', 'BranchController@save')->name('auth.branches.save');
    Route::post('/destinatario/eliminar', 'BranchController@delete')->name('auth.branches.delete');
    Route::post('/destinatarios/obtener', 'BranchController@getdata')->name('auth.branches.getdata');
    Route::post('/destinatarios/ordenar', 'BranchController@sorting')->name('auth.branches.sort');
    Route::get('/destinatarios/ordenar', 'BranchController@sheet')->name('auth.branches.sheet');

    // Role
    Route::get('roles', 'RoleController@index')->name('auth.roles.list');
    Route::get('roles/crear', 'RoleController@create')->name('auth.roles.create');
    Route::get('roles/editar/{id}', 'RoleController@edit')->name('auth.roles.edit');
    Route::post('roles/guardar', 'RoleController@save')->name('auth.roles.save');
    Route::post('roles/eliminar', 'RoleController@delete')->name('auth.roles.delete');
    Route::post('roles/obtener', 'RoleController@getdata')->name('auth.roles.getdata');
    Route::post('roles/ordenar', 'RoleController@sorting')->name('auth.roles.sort');
    Route::get('roles/exportar', 'RoleController@sheet')->name('auth.roles.sheet');

    // Perm
    Route::get('permisos', 'PermController@index')->name('auth.perms.list');
    Route::get('permisos/crear', 'PermController@create')->name('auth.perms.create');
    Route::get('permisos/editar/{id}', 'PermController@edit')->name('auth.perms.edit');
    Route::post('permisos/guardar', 'PermController@save')->name('auth.perms.save');
    Route::post('permisos/eliminar', 'PermController@delete')->name('auth.perms.delete');
    Route::post('permisos/obtener', 'PermController@getdata')->name('auth.perms.getdata');
    Route::post('permisos/ordenar', 'PermController@sorting')->name('auth.perms.sort');
    Route::get('permisos/exportar', 'PermController@sheet')->name('auth.perms.sheet');

    
});
