<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $supportedLocales = Config::get('app.supported_locales');
        $userLanguages = collect($request->getLanguages());
        if ($userLanguages->isNotEmpty()) {
            $matchingLanguage = $userLanguages->first(fn($userLanguage) => in_array($userLanguage, $supportedLocales));
            if ($matchingLanguage != null) {
                app()->setLocale($matchingLanguage);
            }
        }
        return $next($request);
    }
}
