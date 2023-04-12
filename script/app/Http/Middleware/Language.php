<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
use Config;
use Illuminate\Support\Facades\Cookie;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Cookie::has('locale')){
            $locale = Cookie::get('locale');
        }
        else{
            $locale = env('DEFAULT_LANGUAGE','en');
        }

        App::setLocale($locale);
        Cookie::queue('locale', $locale, 365 * 1440);

        return $next($request);
    }
}
