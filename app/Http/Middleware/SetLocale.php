<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request and set the app locale from session.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale', 'en'));
        app()->setLocale($locale);

        return $next($request);
    }
}
