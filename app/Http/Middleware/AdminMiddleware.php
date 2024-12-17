<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Periksa apakah pengguna sudah login dan memiliki peran admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request); // Lanjutkan ke route berikutnya
        }

        // Jika bukan admin, redirect ke halaman lain (misalnya, halaman utama)
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
