<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class mustBeAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(auth()->user()?->usernsmae != 'mou')      ????????????!!!
        // {
        //     abort(Response::HTTP_FORBIDDEN);
        // }

        if(!auth()->user())
        {
            abort(Response::HTTP_FORBIDDEN);
        }
        if(auth()->user()->username != 'mou')
        {
            abort(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
