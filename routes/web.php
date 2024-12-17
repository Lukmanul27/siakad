<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', function() {
        return Auth::user()->role == 'admin' ? 
            redirect()->route('admin.dashboard') : 
            redirect()->route('guru.dashboard');
    })->name('home');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::view('/dashboard', 'scr.admin.admin-dashboard')->name('admin.dashboard');
        Route::get('/manajguru', [UserController::class, 'manajGuru'])->name('admin.manajguru');
        Route::view('/manajsiswa', 'scr.admin.admin-manajsiswa')->name('admin.manajsiswa');
        Route::view('/manajkelas', 'scr.admin.admin-manajkelas')->name('admin.manajkelas');
        Route::view('/manajmapel', 'scr.admin.admin-manajmapel')->name('admin.manajmapel');
        Route::view('/manajjadwal', 'scr.admin.admin-manajjadwal')->name('admin.manajjadwal');
        Route::view('/pengumuman', 'scr.admin.admin-pengumuman')->name('admin.pengumuman');

        Route::middleware('can:admin-access')->group(function() {
            Route::post('/store-user', [UserController::class, 'store'])->name('admin.store.user');
            Route::put('/update-user/{id}', [UserController::class, 'update'])->name('admin.update.user');
            Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->name('admin.delete.user');
        });
    });

    // Guru Routes  
    Route::middleware(['guru'])->prefix('guru')->group(function () {
        Route::view('/dashboard', 'scr.guru.guru-dashboard')->name('guru.dashboard');
        Route::view('/jadwal', 'scr.guru.guru-jadwal')->name('guru.jadwal');
        Route::view('/absensi', 'scr.guru.guru-absensi')->name('guru.absensi');
        Route::view('/fungsionals/kehadiran-siswa', 'scr.guru.fungsionals.kehadiran-siswa')->name('guru.kehadiran-siswa');
        Route::view('/nilai', 'scr.guru.guru-nilai')->name('guru.nilai');
        Route::view('/fungsionals/nilai-siswa', 'scr.guru.fungsionals.nilai-siswa')->name('guru.nilai-siswa');
        Route::view('/pengumuman', 'scr.guru.guru-pengumuman')->name('guru.pengumuman');
    });
});
