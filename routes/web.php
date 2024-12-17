<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function() {
        if(Auth::user()->role == 'admin') {
            return view('scr.admin.admin-dashboard');
        } else if(Auth::user()->role == 'guru') {
            return view('scr.guru.guru-dashboard');
        }
    })->name('home');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function() {
            return view('scr.admin.admin-dashboard');
        })->name('admin.dashboard');
    });

    Route::middleware(['guru'])->prefix('guru')->group(function () {
        Route::get('/dashboard', function() {
            return view('scr.guru.guru-dashboard');
        })->name('guru.dashboard');
    });
});
