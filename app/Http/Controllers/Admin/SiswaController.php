<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManajeSiswa; // Mengganti Siswa dengan ManajeSiswa
use App\Models\Kelas; // Menambahkan import model Kelas
use App\Models\Jurusan; // Menambahkan import model Jurusan

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = ManajeSiswa::all(); // Mengambil semua data siswa
        $kelas = Kelas::all(); // Mengambil semua data kelas
        $jurusans = Jurusan::all(); // Mengambil semua data jurusan
        return view('scr.admin.admin-manajsiswa', compact('siswas', 'kelas', 'jurusans')); // Mengirim data siswa, kelas, dan jurusan ke view
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:manaje_siswas', // Mengganti siswas dengan manaje_siswas
            'nama' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id', // Menambahkan validasi untuk jurusan_id
            'kelas_id' => 'required|exists:kelas,id', // Menambahkan validasi untuk kelas_id
            'jenis_kelamin' => 'required|in:L,P', // Validasi untuk jenis_kelamin
            'alamat' => 'required',
        ]);

        ManajeSiswa::create($request->all()); // Mengganti Siswa dengan ManajeSiswa
        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan.'); // Mengarahkan kembali ke halaman manajemen siswa
    }

    public function update(Request $request, $id)
    {
        $siswa = ManajeSiswa::findOrFail($id); // Mengganti find dengan findOrFail untuk menangani halaman not found
        $request->validate([
            'nis' => 'required|unique:manaje_siswas,nis,' . $siswa->id, // Mengganti siswas dengan manaje_siswas
            'nama' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id', // Menambahkan validasi untuk jurusan_id
            'kelas_id' => 'required|exists:kelas,id', // Menambahkan validasi untuk kelas_id
            'jenis_kelamin' => 'required|in:L,P', // Validasi untuk jenis_kelamin
            'alamat' => 'required',
        ]);

        $siswa->update($request->all()); // Mengganti Siswa dengan ManajeSiswa
        return redirect()->back()->with('success', 'Siswa berhasil diperbarui.'); // Mengarahkan kembali ke halaman manajemen siswa
    }

    public function destroy($id)
    {
        $siswa = ManajeSiswa::findOrFail($id); // Mengganti Siswa dengan ManajeSiswa
        $siswa->delete();
        return redirect()->back()->with('success', 'Siswa berhasil dihapus.'); // Mengarahkan kembali ke halaman manajemen siswa
    }
}
