<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::getJadwalByRole(auth()->user());

        return view('scr.guru.guru-jadwal', ['jadwals' => $jadwals]); // Menggunakan array untuk compact
    }
}
