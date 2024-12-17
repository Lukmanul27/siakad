<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah user memiliki role 'guru'
        if (Auth::check() && Auth::user()->role == 'guru') {
            return $next($request);
        }

        // Redirect jika bukan guru
        return redirect('/')->with('error', 'Anda tidak memiliki akses sebagai guru.');
    }
}
