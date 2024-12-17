<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi database.
     */
    public function run()
    {
        // Insert role Admin
        DB::table('users')->insert([
            'name' => 'Admin SIAKAD',
            'nip' => '1234567890', // NIP untuk Admin
            'email' => 'admin@siakad.com',
            'password' => Hash::make('password123'), // Password terenkripsi
            'role' => 'admin', // Role Admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert role Guru
        DB::table('users')->insert([
            'name' => 'Guru SIAKAD',
            'nip' => '0987654321', // NIP untuk Guru
            'email' => 'guru@siakad.com',
            'password' => Hash::make('password123'), // Password terenkripsi
            'role' => 'guru', // Role Guru
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
