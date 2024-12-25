<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MapelController; 
use App\Http\Controllers\Admin\SiswaController; 
use App\Http\Controllers\Admin\JadwalController; 
use App\Http\Controllers\Admin\PengumumanController; 
use App\Models\Kelas; 
use App\Models\Jurusan; 
use App\Models\User; 

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
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::view('/dashboard', 'scr.admin.admin-dashboard')->name('admin.dashboard');
        Route::get('/manajguru', [UserController::class, 'manajGuru'])->name('admin.manajguru');
        Route::get('/manajkelas', [KelasController::class, 'index'])->name('admin.manajkelas'); 
        Route::get('/manajsiswa', [SiswaController::class, 'index'])->name('admin.manajsiswa'); 
        
        // Routes CRUD Siswa
        Route::post('/siswa/store', [SiswaController::class, 'store'])->name('admin.siswa.store'); 
        Route::put('/siswa/update/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update'); 
        Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('admin.kelas.update'); 
        Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy'); 
        Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('admin.siswa.edit'); 

        // Routes CRUD Mata Pelajaran
        Route::get('/manajmapel', [MapelController::class, 'index'])->name('admin.manajmapel'); 
        Route::post('/mapel/store', [MapelController::class, 'store'])->name('admin.mapel.store'); 
        Route::put('/mapel/update/{id}', [MapelController::class, 'update'])->name('admin.mapel.update'); 
        Route::delete('/mapel/delete/{id}', [MapelController::class, 'destroy'])->name('admin.mapel.destroy'); 

        // Routes CRUD Jadwal
        Route::get('/manajjadwal', [JadwalController::class, 'index'])->name('admin.manajjadwal'); 
        Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('admin.jadwal.store'); 
        Route::put('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update'); 
        Route::delete('/jadwal/delete/{id}', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy'); 
        // Routes CRUD Pengumuman
        Route::get('/manajpengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman.index');
        Route::post('/pengumuman/store', [PengumumanController::class, 'store'])->name('admin.pengumuman.store');
        Route::put('/pengumuman/update/{id}', [PengumumanController::class, 'update'])->name('admin.pengumuman.update');
        Route::delete('/pengumuman/delete/{id}', [PengumumanController::class, 'destroy'])->name('admin.pengumuman.destroy');
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('admin.pengumuman'); 

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
    Route::middleware(['auth', 'guru'])->prefix('guru')->group(function () {
        Route::view('/dashboard', 'scr.guru.guru-dashboard')->name('guru.dashboard');
        Route::get('/jadwal', [\App\Http\Controllers\Guru\JadwalController::class, 'index'])->name('guru.jadwal');
        Route::view('/absensi', 'scr.guru.guru-absensi')->name('guru.absensi');
        Route::view('/fungsionals/kehadiran-siswa', 'scr.guru.fungsionals.kehadiran-siswa')->name('guru.kehadiran-siswa');
        Route::view('/nilai', 'scr.guru.guru-nilai')->name('guru.nilai');
        Route::view('/fungsionals/nilai-siswa', 'scr.guru.fungsionals.nilai-siswa')->name('guru.nilai-siswa');
        Route::view('/pengumuman', 'scr.guru.guru-pengumuman')->name('guru.pengumuman');
    });
});
