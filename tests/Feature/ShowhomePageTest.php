<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; // Tambahkan ini untuk mengimpor model User

class ShowhomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test untuk menampilkan halaman manajemen kelas.
     */
    public function test_manaj_kelas_page_is_accessible(): void
    {
        // Simulasi login sebagai admin
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $response = $this->get('/admin/manajkelas');

        $response->assertStatus(200);
        $response->assertViewIs('scr.admin.admin-manajkelas'); // Memastikan view yang benar
        $response->assertSee('Manajemen Kelas'); // Memastikan ada teks 'Manajemen Kelas' di halaman
    }
}
