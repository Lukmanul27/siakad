<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Jurusan;

class MapelController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all(); // Mengambil data jurusan dari model Jurusan
        $mataPelajaran = Mapel::all(); // Mengambil semua data mata pelajaran
        
        return view('scr.admin.admin-manajmapel', compact('jurusans', 'mataPelajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:mapels,kode,NULL,id,jurusan_id,'.$request->jurusan_id,
            'nama' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
            'kkm' => 'required|numeric|min:0|max:100',
        ]);

        Mapel::create($request->all()); // Simpan data mata pelajaran

        return redirect()->back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mataPelajaran = Mapel::findOrFail($id);
        $jurusans = Jurusan::all(); // Mengambil data jurusan untuk dropdown
        
        return view('scr.admin.admin-manajmapel', compact('mataPelajaran', 'jurusans'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode' => 'required|string|max:10|unique:mapels,kode,'.$id.',id,jurusan_id,'.$request->jurusan_id,
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        $mataPelajaran = Mapel::findOrFail($id);
        $mataPelajaran->update($validatedData); // Update data mata pelajaran

        return redirect()->back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mataPelajaran = Mapel::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
