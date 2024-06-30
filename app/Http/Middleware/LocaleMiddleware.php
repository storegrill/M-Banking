<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the locale from the request or use a default value
        $locale = $request->input('locale', config('app.locale'));

        // Set the application locale
        App::setLocale($locale);

        // Optionally set the PHP locale
        setlocale(LC_TIME, ''); // Example: LC_TIME for date/time formatting

        return $next($request);
    }
}
