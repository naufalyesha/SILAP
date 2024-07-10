<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::check()) {
            if (auth()->user()->role == $role) {
                return $next($request);
            } else {
                // Arahkan pengguna yang tidak memiliki peran yang sesuai
                return redirect('/');
            }
        } else {
            // Arahkan pengguna yang belum login ke halaman login
            return redirect('/login');
        }
    }
}

