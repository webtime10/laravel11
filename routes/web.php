<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home; // ← ВАЖНО: импорт компонента

use App\Livewire\BlogIndex;
use App\Livewire\BlogShow;

// редирект на логин Filament
Route::get('/login', fn () => redirect()->route('filament.admin.auth.login'))
    ->name('login');

// главная страница
Route::get('/', Home::class)->name('home');
// (альтернатива без use: Route::get('/', \App\Livewire\Home::class)->name('home');)


Route::get('/blog', BlogIndex::class)->name('blog.index');
Route::get('/blog/{post}', BlogShow::class)->name('blog.show'); // {post} = id записи Block1