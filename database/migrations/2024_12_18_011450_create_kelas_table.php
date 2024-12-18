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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('tingkat', 5);
            $table->unsignedBigInteger('jurusan_id');
            $table->unsignedBigInteger('wali_kelas')->nullable();
            $table->string('nama_kelas'); // Menambahkan kolom nama_kelas
            $table->timestamps();

            // Relasi ke tabel jurusan
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
            $table->foreign('wali_kelas')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
