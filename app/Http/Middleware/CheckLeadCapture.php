<?php

namespace App\Http\Middleware;

use App\ShortenedUrl;
use Closure;
use Illuminate\Support\Facades\Cookie;

class CheckLeadCapture
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

        $url = ShortenedUrl::whereAlias($alias)->firstOrFail();

        if ($url->enable_lead_capture) {
            if (!Cookie::get($alias)) {
                return response()->view('lead', ['alias' => $alias]);
            }
        }

        return $next($request);
    }
}
