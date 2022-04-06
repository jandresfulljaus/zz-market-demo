<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix(Products)
    ->namespace('Modules\Products\Controllers')
    ->group(function () {
    // {{ agregar }}
});
