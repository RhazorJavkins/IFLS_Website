<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoursesCmsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Halaman courses dirender dari DB (program + fitur + pricing).
     */
    public function test_courses_page_renders_programs_from_db(): void
    {
        $this->seed();

        $response = $this->get('/id/courses');
        $response->assertOk();

        // Nama program & badge dari DB (identik dengan lang file)
        $response->assertSee('Bahasa Indonesia untuk WNA')
            ->assertSee('Bahasa Mandarin')
            ->assertSee('Bahasa Inggris')
            ->assertSee('Program Unggulan');

        // Konten fitur dari DB: level, jenjang stepper, highlight English
        $response->assertSee('Tingkatan Kelas')
            ->assertSee('Jenjang Belajar')
            ->assertSee('Level Sesuai Kemampuanmu');
    }

    /**
     * Anchor = slug: /courses#mandarin dst. tetap berfungsi (dipakai beranda).
     */
    public function test_course_anchors_match_program_slugs(): void
    {
        $this->seed();

        $this->get('/id/courses')
            ->assertOk()
            ->assertSee('id="bahasa-indonesia"', false)
            ->assertSee('id="mandarin"', false)
            ->assertSee('id="english"', false);
    }

    /**
     * Fallback ke lang file saat tabel program kosong — situs tetap tampil utuh.
     */
    public function test_courses_page_falls_back_to_lang_when_db_empty(): void
    {
        Program::query()->delete();

        $this->get('/id/courses')
            ->assertOk()
            ->assertSee('Bahasa Indonesia untuk WNA')
            ->assertSee('Tingkatan Kelas');
    }

    /**
     * Detail course dengan harga null → tampil "Hubungi untuk harga" (bukan Rp 0).
     */
    public function test_course_detail_shows_contact_for_price_when_null(): void
    {
        $this->seed();

        $this->get('/id/courses/1')
            ->assertOk()
            ->assertSee('Hubungi untuk harga')
            ->assertDontSee('Rp 0');
    }

    /**
     * Resource admin (Program, Kelas, Paket Harga) bisa diakses admin.
     */
    public function test_admin_course_resources_are_accessible(): void
    {
        $user = User::create([
            'name' => 'Admin', 'email' => 'admin@iflanguage.com',
            'password' => 'super-secret-password-123',
        ]);

        $this->actingAs($user)->get('/admin/programs')->assertOk();
        $this->actingAs($user)->get('/admin/courses')->assertOk();
        $this->actingAs($user)->get('/admin/pricing-plans')->assertOk();
    }
}
