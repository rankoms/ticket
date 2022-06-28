<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use App\Models\ResUserApikey;
use Closure;
use Auth;

class TokenAuth
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
        $header = $request->header();
        if (!isset($header['apikey'][0])) {
            return ResponseFormatter::error(
                null,
                'masukan dahulu apikey',
                400
            );
        }
        $apikey = $header['apikey'][0];
        $key = ResUserApikey::where('key', $apikey)->first();
        if ($key) {
            return $next($request);
        } else {
            return ResponseFormatter::error(
                null,
                'apikey salah',
                400
            );
        }
    }
}
