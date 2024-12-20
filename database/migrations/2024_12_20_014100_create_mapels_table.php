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
        Schema::create('mapel', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // Menambahkan kolom kode
            $table->string('nama'); // Menambahkan kolom nama
            $table->unsignedBigInteger('jurusan_id'); // Menambahkan kolom jurusan_id
            $table->integer('kkm'); // Menambahkan kolom kkm
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade'); // Menambahkan foreign key
            $table->unique(['kode', 'jurusan_id']); // Menambahkan unique constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
