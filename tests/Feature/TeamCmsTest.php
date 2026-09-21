<?php

namespace Tests\Feature;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TeamCmsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Home & About menampilkan tim dari DB (nama, jabatan i18n, foto storage).
     */
    public function test_team_renders_from_db_on_home_and_about(): void
    {
        $this->seed();

        $home = $this->get('/id');
        $home->assertOk()
            ->assertSee('images/team/yiyan.png', false)
            ->assertSee('Chairman');

        $about = $this->get('/id/about');
        $about->assertOk()
            ->assertSee('images/team/amber.png', false)
            ->assertSee('Training Director'); // role_id staf (dari config lama)
    }

    /**
     * Jabatan tim terjemah per locale (id / en / zh) dari data DB.
     */
    public function test_team_roles_translate_per_locale(): void
    {
        $this->seed();

        $this->get('/en/about')->assertOk()->assertSee('Training Director');
        $this->get('/zh/about')->assertOk()->assertSee('培训总监');
        $this->get('/id/about')->assertOk()->assertSee('General Manager'); // role_id dari config lama
    }

    /**
     * Saat tabel tim kosong, halaman tetap tampil dari config fallback.
     */
    public function test_team_falls_back_to_config_when_db_empty(): void
    {
        // Tanpa seed: tabel team_members kosong
        $this->get('/id')->assertOk()->assertSee('images/team/yiyan.png', false);
        $this->get('/id/about')->assertOk()->assertSee('images/team/novi.png', false);
    }

    /**
     * Anggota nonaktif tidak tampil.
     */
    public function test_inactive_members_are_hidden(): void
    {
        $this->seed();
        TeamMember::where('name', 'Novi')->update(['is_active' => false]);

        $this->get('/id/about')->assertOk()->assertDontSee('images/team/novi.png', false);
    }

    /**
     * Foto bisa juga dari storage (upload CMS), bukan hanya images/team legacy.
     */
    public function test_photo_url_supports_storage_uploads(): void
    {
        Storage::fake('public');
        $member = TeamMember::create([
            'name' => 'New Person',
            'role' => ['id' => 'Staf', 'en' => 'Staff', 'zh' => '员工'],
            'photo' => 'team/new-person.png',
            'is_director' => false,
            'show_on_home' => true,
            'sort' => 99,
            'is_active' => true,
        ]);

        $this->assertSame(asset('storage/team/new-person.png'), $member->photo_url);
    }

    /**
     * Resource admin Tim bisa diakses admin.
     */
    public function test_admin_team_resource_is_accessible(): void
    {
        $user = User::create([
            'name' => 'Admin', 'email' => 'admin@iflanguage.com',
            'password' => 'super-secret-password-123',
        ]);

        $this->actingAs($user)->get('/admin/team-members')->assertOk();
    }
}
