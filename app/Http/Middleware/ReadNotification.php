<?php

namespace App\Http\Middleware;

use Closure;

class ReadNotification
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
        if (request()->filled('n')) {
            auth()->user()->unreadNotifications()->where('id', request('n'))->update(['read_at' => now()]);
        }

        return $next($request);
    }
}
