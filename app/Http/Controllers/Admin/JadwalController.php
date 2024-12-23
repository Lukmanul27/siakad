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
        $jurusans = Jurusan::all();
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = User::where('role', 'guru')->get();

        $selectedJurusan = old('jurusan_id', null);
        $jurusan_id = $selectedJurusan ?? '0';
        if ($jurusan_id && $jurusan_id != '0') {
            $kelas = Kelas::where('jurusan_id', $jurusan_id)->get();
            $mapels = Mapel::where('jurusan_id', $jurusan_id)->get();
        }

        if ($jurusan_id == '0') {
            $kelas = Kelas::all();
            $mapels = [
                (object)['id' => 'upacara', 'nama' => 'Upacara'],
                (object)['id' => 'istirahat', 'nama' => 'Istirahat'],
                (object)['id' => 'apel', 'nama' => 'Apel'],
            ];
        }

        return view('scr.admin.admin-manajjadwal', compact('jurusans', 'kelas', 'mapels', 'gurus'));
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
            'ruangan' => 'nullable|string', // Menambahkan validasi untuk ruangan
        ]);

        Jadwal::create([
            'hari' => $validated['hari'],
            'jurusan_id' => $validated['jurusan_id'],
            'kelas_id' => $validated['kelas_id'] ?? null,
            'jam_ke' => $validated['jam_ke'],
            'waktu' => $validated['waktu'],
            'mata_pelajaran_id' => $validated['mata_pelajaran_id'],
            'guru_id' => $validated['guru_id'],
            'ruangan' => $validated['ruangan'], // Menyimpan ruangan
        ]);

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
            'ruangan' => 'nullable|string', // Menambahkan validasi untuk ruangan
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

    public function getMataPelajaran(Request $request)
    {
        $jurusanId = $request->input('jurusan_id');
        $kelas = Kelas::where('jurusan_id', $jurusanId)->get();
        $mataPelajaran = [];

        if ($jurusanId == 0) {
            $mataPelajaran = [
                ['id' => 'upacara', 'nama' => 'Upacara'],
                ['id' => 'istirahat', 'nama' => 'Istirahat'],
                ['id' => 'apel', 'nama' => 'Apel']
            ];
        } else {
            $mataPelajaran = Mapel::where('jurusan_id', $jurusanId)->get();
        }

        return response()->json([
            'mataPelajaran' => $mataPelajaran,
            'kelas' => $kelas,
        ]);
    }
}
