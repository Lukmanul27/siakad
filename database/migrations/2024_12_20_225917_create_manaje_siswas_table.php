<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manaje_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // NIS Siswa
            $table->string('nama'); // Nama Siswa
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade'); // Jurusan Siswa
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade'); // Kelas Siswa
            $table->enum('jenis_kelamin', ['L', 'P']); // Jenis Kelamin
            $table->text('alamat'); // Alamat Siswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manaje_siswas');
    }
};
