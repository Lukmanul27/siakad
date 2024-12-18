<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas; 
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    /**
     * Constructor untuk menerapkan middleware pada method controller
     */
    public function __construct()
    {
        $this->middleware('can:admin-access'); 
    }

    /**
     * Menampilkan halaman manajemen kelas
     */
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'waliKelas'])->get(); 
        $jurusans = Jurusan::all();
        $waliKelas = User::where('role', 'guru')->get();
        return view('scr.admin.admin-manajkelas', compact('kelas', 'jurusans', 'waliKelas'));
    }

    /**
     * Simpan kelas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|string|max:5',
            'jurusan_id' => 'required|exists:jurusans,id',
            'wali_kelas' => 'nullable|exists:users,id,role,guru',
            'nama_kelas' => 'required|string|max:255',
        ]);

        Kelas::create([ 
            'tingkat' => $request->tingkat,
            'jurusan_id' => $request->jurusan_id,
            'wali_kelas' => $request->wali_kelas,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Update data kelas.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tingkat' => 'required|string|max:5', 
            'jurusan_id' => 'required|exists:jurusans,id',
            'wali_kelas' => 'nullable|exists:users,id,role,guru',
            'nama_kelas' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id); 
        $kelas->update([
            'tingkat' => $request->tingkat,
            'jurusan_id' => $request->jurusan_id,
            'wali_kelas' => $request->wali_kelas,
            'nama_kelas' => $request->nama_kelas,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Hapus data kelas
     */
    public function destroy($id)
    {
        try {
            $kelas = Kelas::findOrFail($id); 
            $kelas->delete();
            return redirect()->back()->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }
}
