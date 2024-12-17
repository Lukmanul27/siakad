<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route untuk halaman login
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    
    // Route untuk redirect setelah login berdasarkan role
    Route::get('/home', function() {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else if(Auth::user()->role == 'guru') {
            return redirect()->route('guru.dashboard'); 
        }
    })->name('home');

    // Route untuk Admin
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function() {
            return view('scr.admin.admin-dashboard');
        })->name('admin.dashboard');
    });

    // Route untuk Guru
    Route::middleware(['guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', function() {
            return view('scr.guru.guru-dashboard');
        })->name('guru.dashboard');

        Route::get('/jadwal', function() {
            return view('scr.guru.guru-jadwal');
        })->name('guru.jadwal');

        Route::get('/absensi', function() {
            return view('scr.guru.guru-absensi');
        })->name('guru.absensi');

        Route::get('/fungsionals/kehadiran-siswa', function() {
            return view('scr.guru.fungsionals.kehadiran-siswa');
        })->name('guru.kehadiran-siswa');

        Route::get('/nilai', function() {
            return view('scr.guru.guru-nilai');
        })->name('guru.nilai');

        Route::get('/fungsionals/nilai-siswa', function() {
            return view('scr.guru.fungsionals.nilai-siswa');
        })->name('guru.nilai-siswa');

        Route::get('/pengumuman', function() {
            return view('scr.guru.guru-pengumuman');
        })->name('guru.pengumuman');
    });
});
