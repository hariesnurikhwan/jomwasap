<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class CheckCookie
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
        $alias = $request->route('alias');

        if (!Cookie::get($alias)) {
            return response()->view('lead', ['alias' => $alias]);
        }

        return $next($request);
    }
}
