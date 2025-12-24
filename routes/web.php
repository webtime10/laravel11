<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Helper\Langs;

Route::get('/lang/{lang}', function ($lang) {
    if (!in_array($lang, Langs::LOCALES)){
abort(404);
    }

    App::setLocale($lang);
    $uri = Langs::getUri($lang);
    return redirect($uri);

})->name('setlang');



// редирект на логин Filament
Route::get('/login', fn () => redirect()->route('filament.admin.auth.login'))
    ->name('login');


Route::prefix(App\Helper\Langs::getLocale())->middleware('langs')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
});

