<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas; // Menambahkan import model Kelas
use App\Models\Jurusan; // Menambahkan import model Jurusan

class ManajeSiswa extends Model
{
    use HasFactory;

    protected $table = 'manaje_siswas'; // Nama tabel
    protected $fillable = [
        'nis',          // NIS Siswa
        'nama',         // Nama Siswa
        'jurusan_id',   // ID Jurusan
        'kelas_id',     // ID Kelas
        'jenis_kelamin', // Jenis Kelamin
        'alamat',       // Alamat Siswa
    ];

    // Relasi dengan model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // Menambahkan 'kelas_id' sebagai foreign key
    }

    // Relasi dengan model Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id'); // Menambahkan 'jurusan_id' sebagai foreign key
    }
}
