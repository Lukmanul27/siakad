<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari', 
        'jurusan_id', 
        'kelas_id', 
        'jam_ke', 
        'waktu', 
        'mata_pelajaran_id', 
        'guru_id',
        'ruangan'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(Mapel::class, 'mata_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public static function getJadwalByRole($user)
    {
        if ($user->role === 'admin') {
            return self::with(['kelas', 'jurusan', 'mataPelajaran', 'guru'])->get();
        }

        if ($user->role === 'guru') {
            return self::with(['kelas', 'jurusan', 'mataPelajaran', 'guru'])
                ->where('guru_id', $user->id)
                ->get();
        }

        return collect();
    }
}
