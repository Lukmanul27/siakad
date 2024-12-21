<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-access');
    }
    
    public function index()
    {
        $jadwals = Jadwal::with(['kelas', 'mataPelajaran', 'guru', 'jurusan'])->get();
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = User::where('role', 'guru')->get();
        $jurusans = Jurusan::all();
        return view('scr.admin.admin-manajjadwal', compact('jadwals', 'kelas', 'mapels', 'gurus', 'jurusans'));
    }

    public function create()
    {
        // Ambil data jurusan, kelas, mata pelajaran, dan guru
        $jurusans = Jurusan::all();
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = User::where('role', 'guru')->get();

        // Menyaring kelas berdasarkan jurusan jika jurusan dipilih
        $selectedJurusan = old('jurusan_id', null);
        if ($selectedJurusan && $selectedJurusan != '0') {
            $kelas = Kelas::where('jurusan_id', $selectedJurusan)->get();
            $mapels = Mapel::where('jurusan_id', $selectedJurusan)->get();
        }

        // Jika "Seluruh Jurusan" dipilih, munculkan kelas dari semua jurusan dan mata pelajaran khusus
        if ($selectedJurusan == '0') {
            $kelas = Kelas::all();
            $mapels = [
                (object)['id' => 'upacara', 'nama' => 'Upacara'],
                (object)['id' => 'istirahat', 'nama' => 'Istirahat'],
                (object)['id' => 'apel', 'nama' => 'Apel'],
            ];
        }

        return view('admin.jadwal.create', compact('jurusans', 'kelas', 'mapels', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|string',
            'jurusan_id' => 'required|integer',
            'kelas_id' => 'nullable|integer',
            'jam_ke' => 'required|integer',
            'waktu' => 'required|string',
            'mata_pelajaran_id' => 'required|string',
            'guru_id' => 'required|integer',
        ]);

        // Simpan ke database
        Jadwal::create($validated);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'guru', 'jurusan'])->findOrFail($id);
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = User::where('role', 'guru')->get();
        $jurusans = Jurusan::all();
        return view('scr.admin.admin-manajjadwal', compact('jadwal', 'kelas', 'mapels', 'gurus', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
           'hari' => 'required|string',
            'jurusan_id' => 'required|integer',
            'kelas_id' => 'nullable|integer',
            'jam_ke' => 'required|integer',
            'waktu' => 'required|string',
            'mata_pelajaran_id' => 'required|string',
            'guru_id' => 'required|integer',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('admin.manajjadwal')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('admin.manajjadwal')->with('success', 'Jadwal berhasil dihapus.');
    }
}
