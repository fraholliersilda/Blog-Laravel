<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
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
        if (auth()->check() && auth()->user()->language) {
            App::setLocale(auth()->user()->language);
            Session::put('applocale', auth()->user()->language);
        } elseif (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        }
        return $next($request);
    }
}
