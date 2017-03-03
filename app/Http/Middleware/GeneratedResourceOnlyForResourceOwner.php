<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class GeneratedResourceOnlyForResourceOwner
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
        if ($request->url->user_id !== Auth::id()) {
            return abort(404);
        }
        return $next($request);
    }
}
