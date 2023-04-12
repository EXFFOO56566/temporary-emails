<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsInstalled
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
        if (env('SYSTEM_INSTALLED') == '1') {
            return redirect('/');
        }
        return $next($request);
    }
}
