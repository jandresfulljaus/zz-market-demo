<?php

use Illuminate\Support\Facades\Route;

use Organizations\market\img\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('images.home');
