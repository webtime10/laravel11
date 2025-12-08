<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__));

$app->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
);

$app->withMiddleware(function (Middleware $middleware): void {
    // web-стек
    $middleware->web(append: [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    ]);

    // алиасы
    $middleware->alias([
        'auth'  => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    ]);
});

$app->withExceptions(function (Exceptions $exceptions): void {
    //
});

return $app->create();
