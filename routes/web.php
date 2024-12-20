<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController; // Menambahkan import model MapelController
use App\Models\Kelas; // Menambahkan import model Kelas
use App\Models\Jurusan; // Menambahkan import model Jurusan
use App\Models\User; // Menambahkan import model User

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
        Route::get('/manajkelas', [KelasController::class, 'index'])->name('admin.manajkelas'); // Memperbaiki rute manajkelas
        Route::view('/manajsiswa', 'scr.admin.admin-manajsiswa')->name('admin.manajsiswa');
        
        // Routes CRUD Mata Pelajaran
        Route::get('/manajmapel', [MapelController::class, 'index'])->name('admin.manajmapel'); // Menampilkan daftar mata pelajaran
        Route::post('/mapel/store', [MapelController::class, 'store'])->name('admin.mapel.store'); // Menyimpan mata pelajaran baru
        Route::put('/mapel/update/{id}', [MapelController::class, 'update'])->name('admin.mapel.update'); // Memperbarui mata pelajaran
        Route::delete('/mapel/delete/{id}', [MapelController::class, 'destroy'])->name('admin.mapel.destroy'); // Menghapus mata pelajaran

        Route::view('/manajjadwal', 'scr.admin.admin-manajjadwal')->name('admin.manajjadwal');
        Route::view('/pengumuman', 'scr.admin.admin-pengumuman')->name('admin.pengumuman');

        Route::middleware('can:admin-access')->group(function() {
            Route::post('/store-user', [UserController::class, 'store'])->name('admin.store.user');
            Route::put('/update-user/{id}', [UserController::class, 'update'])->name('admin.update.user');
            Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->name('admin.delete.user');
            
            // Routes CRUD Jurusan
            Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
            Route::post('/jurusan/store', [JurusanController::class, 'store'])->name('jurusan.store');
            Route::put('/jurusan/update/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
            Route::delete('/jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('jurusan.delete');

            // Routes CRUD Kelas
            Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
            Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
            Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
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
