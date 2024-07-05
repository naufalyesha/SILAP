<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddAuthTokenToCookie
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
        $response = $next($request);

        if ($request->user()) {
            $token = $request->user()->createToken('authToken')->plainTextToken;
            $response->headers->setCookie(cookie('auth_token', $token, 60));
        }

        return $response;
    }
}
