<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// редирект на логин Filament
Route::get('/login', fn () => redirect()->route('filament.admin.auth.login'))
    ->name('login');

// главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');