<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($locale = session('locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
