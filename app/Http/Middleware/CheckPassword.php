<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPassword
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
        if($request->password !== env('API_PASSWORD','pum5YkMroifj2K6INg25EgZsV'))
        {
            return response()->json(['message'=>'not authorized']);
        }
        return $next($request);
    }
}
