<?php

namespace App\Http\Middleware;

use App\ShortenedUrl;
use App\ShortenedUrlHits;
use Closure;

class UrlHits
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

        $url = ShortenedUrl::whereAlias($request->alias)->firstOrFail();

        $user_agent = $request->header('User-Agent');

        $ip = $request->header('x-real-ip');

        $url->newHit(new ShortenedUrlHits([
            'user_agent' => $user_agent,
            'ip_address' => $ip,
        ]));

        return $next($request);
    }
}
