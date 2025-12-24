<?php

namespace App\Helper;

class Langs
{
    const LOCALES = ['ua', 'ru'];

public static function getLocale(): string
{
    $locale = request()->segment(1, '');

    if ($locale) {
        if (in_array($locale, self::LOCALES)) {
            return $locale;
        }
    }

    return '';
}
public static function getUri($lang)
{
    $url = url()->previous();
    $url = str_replace(self::LOCALES, array_pad([], count(self::LOCALES), ''), $url);

    $url_parse = parse_url($url);
    $url_parse['path'] = str_replace('//', '/', $url_parse['path'] ?? '/');

    $uri = '';

    if ($lang != env('APP_LOCALE')) {
        $uri .= "/$lang";
    }

    $uri .= $url_parse['path'];

    if (isset($url_parse['query'])) {
        $uri .= "?" . $url_parse['query'];
    }

    return $uri;
}





}
