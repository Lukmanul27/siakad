<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::all();

        if ($pengumumans->isEmpty()) {
            return view('scr.admin.admin-pengumuman', ['pengumumans' => [], 'selectedPengumuman' => null]);
        }

        return view('scr.admin.admin-pengumuman', ['pengumumans' => $pengumumans, 'selectedPengumuman' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,docx,doc,jpg,png,jpeg|max:2048',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
        }

        Pengumuman::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'isi' => $request->isi,
            'lampiran' => $lampiranPath,
            'status' => 'aktif', // Status default diatur ke 'aktif'
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
{
    $pengumuman = Pengumuman::findOrFail($id);

    if ($request->has('status')) {
        $request->validate([
            'status' => 'required|string|in:aktif,nonaktif',
        ]);
        $pengumuman->status = $request->input('status');
    } else {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,docx,doc,jpg,png,jpeg',
        ]);

        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($pengumuman->lampiran) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            // Simpan lampiran baru
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
            $pengumuman->lampiran = $lampiranPath;
        }

        $pengumuman->judul = $request->input('judul');
        $pengumuman->tanggal = $request->input('tanggal');
        $pengumuman->isi = $request->input('isi');
    }

    $pengumuman->save();

    return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
}

public function destroy($id)
{
    $pengumuman = Pengumuman::findOrFail($id);

    // Hapus lampiran jika ada
    if ($pengumuman->lampiran) {
        Storage::disk('public')->delete($pengumuman->lampiran);
    }

    $pengumuman->delete();

    return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
}

}
