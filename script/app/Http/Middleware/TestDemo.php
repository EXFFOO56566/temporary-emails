<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestDemo
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


        $method = request()->method();
        

        If($method == 'POST' OR $method == 'PUT' OR $method == 'DELETE') {

            $route = Request()->route()->getName();
        
            if($route == "check.imap" ){
                return $next($request);
            }
        
            return back()->with('demo', 'Demo version some features are disabled');


        }else{
            return $next($request);
        }
    }
}
