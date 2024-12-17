<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Constructor untuk menerapkan middleware pada method controller
     */
    public function __construct()
    {
        $this->middleware('can:admin-access'); // Memastikan hanya admin yang dapat mengakses
    }

    /**
     * Menampilkan halaman manajemen guru dan admin
     */
    public function manajGuru()
    {
        $users = User::whereIn('role', ['guru', 'admin'])->get();
        return view('scr.admin.admin-manajguru', compact('users'));
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:users,nip',
            'email' => 'required|string|email|max:255|unique:users,email', 
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:guru,admin',
        ]);

        try {
            // Simpan user ke database
            $user = User::create([
                'name' => $request->name,
                'nip' => $request->nip,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'email_verified_at' => now(), // Verifikasi email otomatis
                'remember_token' => \Str::random(10), // Generate remember token
            ]);

            if($user) {
                // Redirect dengan pesan sukses
                return redirect()->back()->with('success', 'User berhasil ditambahkan dan dapat digunakan untuk login.');
            }

            return redirect()->back()->with('error', 'Gagal menambahkan user. Silakan coba lagi.');

        } catch(\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update data user.
     */
    public function update(Request $request, $id)
    {
        // Cari user berdasarkan ID atau tampilkan error jika tidak ditemukan
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:users,nip,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,guru',
        ]);

        // Update informasi user
        $user->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Kembalikan response sukses
        return redirect()->back()->with('success', 'Data user berhasil diperbarui');
    }

    /**
     * Hapus data user
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
