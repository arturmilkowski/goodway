<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locales = config('settings.locales', ['pl']);
        $segment = $request->segment(1);

        if (in_array($segment, $locales)) {
            App::setLocale($segment);
        } else {
            App::setLocale(config('app.locale', 'pl'));
        }

        // Ustaw domyślny parametr locale dla route()
        URL::defaults(['locale' => App::getLocale()]);

        return $next($request);
    }
}
