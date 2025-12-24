<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LangsMiddleware
{
public function handle(Request $request, Closure $next): Response
{
    $locale = ltrim($request->route()->getPrefix(), '/');

    if ($locale) {
        \Illuminate\Support\Facades\App::setLocale($locale);
    }

    if ($locale === env('APP_LOCALE')) {
        $uri = str_replace($locale, '', $request->path());
        return redirect($uri, 301);
    }

    return $next($request);
}

}
