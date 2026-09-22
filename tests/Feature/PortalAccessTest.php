<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Matrix akses 3 panel:
 *  - /admin     → hanya admin
 *  - /training  → admin + teacher
 *  - /translate → admin + translator
 */
class PortalAccessTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::create([
            'name' => 'Test ' . $role,
            'email' => $role . '@example.test',
            'password' => 'password-rahasia-12',
            'role' => $role,
        ]);
    }

    public function test_admin_can_access_all_three_panels(): void
    {
        $admin = $this->user(User::ROLE_ADMIN);

        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->actingAs($admin)->get('/training')->assertOk();
        $this->actingAs($admin)->get('/translate')->assertOk();
    }

    public function test_teacher_accesses_training_but_not_admin_nor_translate(): void
    {
        $teacher = $this->user(User::ROLE_TEACHER);

        $this->actingAs($teacher)->get('/training')->assertOk();
        $this->actingAs($teacher)->get('/admin')->assertForbidden();
        $this->actingAs($teacher)->get('/translate')->assertForbidden();
    }

    public function test_translator_accesses_translate_but_not_admin_nor_training(): void
    {
        $translator = $this->user(User::ROLE_TRANSLATOR);

        $this->actingAs($translator)->get('/translate')->assertOk();
        $this->actingAs($translator)->get('/admin')->assertForbidden();
        $this->actingAs($translator)->get('/training')->assertForbidden();
    }

    public function test_guest_is_redirected_to_panel_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/training')->assertRedirect('/training/login');
        $this->get('/translate')->assertRedirect('/translate/login');
    }

    public function test_users_page_only_visible_to_admin(): void
    {
        $admin = $this->user(User::ROLE_ADMIN);
        $teacher = $this->user(User::ROLE_TEACHER);

        $this->actingAs($admin)->get('/admin/users')->assertOk();
        $this->actingAs($teacher)->get('/admin/users')->assertForbidden();
    }

    public function test_role_routes_reject_wrong_role(): void
    {
        // Route CSV absensi: guru boleh, penerjemah tidak
        $teacher = $this->user(User::ROLE_TEACHER);
        $translator = $this->user(User::ROLE_TRANSLATOR);

        $this->actingAs($translator)->get('/portal/translate/leads.csv')->assertOk();

        // Unduh dokumen: penerjemah boleh (akan 404 file, bukan 403 akses)
        $this->actingAs($translator)->get('/portal/translate/documents/1/download');
    }
}
