<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model // Mengubah nama kelas dari MataPelajaran menjadi Mapel
{
    use HasFactory;

    protected $fillable = ['kode', 'nama', 'jurusan_id', 'kkm']; // Mengubah 'jurusan' menjadi 'jurusan_id'

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id'); // Mengubah 'jurusan' menjadi 'jurusan_id'
    }
}
