<?php

namespace App\Http\Middleware;

use Closure;

class SentryUserContext
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
        if (app()->bound('sentry') && auth()->check()) {
            $sentry = app()->make('sentry');
            $user   = auth()->user();

            $sentry->user_context([
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ]);
        }

        return $next($request);
    }
}
