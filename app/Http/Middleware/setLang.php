<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class setLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentLocale = session('lang');

        // Prioritize query for manual control, then header for automatic detection
        $locale = $request->query('lang')
            ?? $request->header('Accept-Language')
            ?? $currentLocale
            ?? config('app.locale');

        // Clean and confirm language
        $locale = substr($locale, 0, 2);  // Take first two characters
        $supportedLocales = ['en', 'ar'];

        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
            config(['app.locale' => $locale]); // Force update config as well

            if ($currentLocale !== $locale && !$request->expectsJson()) {
                session(['lang' => $locale]);
            }
        }

        \Illuminate\Support\Facades\Log::info('Language middleware set locale', [
            'locale' => App::getLocale(),
            'requested_locale' => $locale,
            'is_api' => $request->expectsJson()
        ]);

        return $next($request);
    }
}
