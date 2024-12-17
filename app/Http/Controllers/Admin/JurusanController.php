<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Constructor untuk menerapkan middleware pada method controller
     */
    public function __construct()
    {
        $this->middleware('can:admin-access'); // Memastikan hanya admin yang dapat mengakses
    }

    /**
     * Menampilkan halaman manajemen jurusan
     */
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('scr.admin.admin-manajkelas', compact('jurusans'));
    }

    /**
     * Simpan jurusan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusans,kode_jurusan',
            'nama_jurusan' => 'required|string|max:255',
        ]);

        try {
            // Simpan jurusan ke database
            $jurusan = Jurusan::create([
                'kode_jurusan' => $request->kode_jurusan,
                'nama_jurusan' => $request->nama_jurusan
            ]);

            if($jurusan) {
                return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan.');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan jurusan. Silakan coba lagi.');

        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update data jurusan.
     */
    public function update(Request $request, $id)
    {
        // Cari jurusan berdasarkan ID atau tampilkan error jika tidak ditemukan
        $jurusan = Jurusan::findOrFail($id);

        // Validasi input
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusans,kode_jurusan,' . $id,
            'nama_jurusan' => 'required|string|max:255',
        ]);

        try {
            // Update informasi jurusan
            $jurusan->update([
                'kode_jurusan' => $request->kode_jurusan,
                'nama_jurusan' => $request->nama_jurusan
            ]);

            return redirect()->back()->with('success', 'Data jurusan berhasil diperbarui');

        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data jurusan
     */
    public function destroy($id)
    {
        try {
            $jurusan = Jurusan::findOrFail($id);
            $jurusan->delete();
            return redirect()->back()->with('success', 'Jurusan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus jurusan: ' . $e->getMessage());
        }
    }
}
