<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        $locale = session('locale', config('app.locale'));
        
        if (in_array($locale, ['en', 'id'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}