<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHeader
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
        //forcing header to show response as Json.
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        //FORCING REQUEST
        (!$request->limit || $request->limit < 0) && $request->limit = 10;

        return $next($request);
    }
}
