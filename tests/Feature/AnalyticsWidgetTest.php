<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Fallback analitik: tanpa ANALYTICS_PROPERTY_ID / file kredensial,
 * halaman & dashboard TIDAK boleh error — hanya menampilkan pesan setup.
 */
class AnalyticsWidgetTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin', 'email' => 'admin-analytics@example.test',
            'password' => 'password-rahasia-12', 'role' => User::ROLE_ADMIN,
        ]);
    }

    public function test_service_reports_unconfigured_without_credentials(): void
    {
        // Di phpunit tidak ada property id & file kredensial
        $this->assertFalse(AnalyticsService::configured());
        $this->assertNull(AnalyticsService::totals(7));
        $this->assertNull(AnalyticsService::dailySeries(7));
        $this->assertNull(AnalyticsService::topPages(7));
    }

    public function test_analytics_page_renders_setup_notice_when_unconfigured(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/analytics')
            ->assertOk()
            ->assertSee('belum dikonfigurasi', false);
    }

    public function test_admin_dashboard_still_works_without_analytics(): void
    {
        $this->actingAs($this->admin)->get('/admin')->assertOk();
    }

    public function test_teacher_cannot_access_analytics_page(): void
    {
        $teacher = User::create([
            'name' => 'Guru', 'email' => 'guru-analytics@example.test',
            'password' => 'password-rahasia-12', 'role' => User::ROLE_TEACHER,
        ]);

        $this->actingAs($teacher)->get('/admin/analytics')->assertForbidden();
    }
}
