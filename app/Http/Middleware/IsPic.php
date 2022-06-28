<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsPic
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
        if (Auth::check() && (Auth::user()->user_group == 'pic_polda' || Auth::user()->user_group == 'pic_polres' || Auth::user()->user_group == 'admin')) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}
