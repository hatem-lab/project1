<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChangeLang
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
        app()->setlocale('ar');
        if(isset($request->lang) && $request->lang==='en')
        {
            app()->setlocale('en');
        }
        return $next($request);
    }
}
