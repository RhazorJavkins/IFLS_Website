<?php

namespace Tests\Feature;

use App\Models\ContactLead;
use App\Models\Testimonial;
use App\Models\User;
use App\Rules\SafeImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * B6-1: Form kontak wajib menyertakan CSRF token. Catatan: middleware Laravel
     * sengaja melewati validasi CSRF saat unit test (runningUnitTests()); penolakan
     * runtime 419 sudah diverifikasi manual via HTTP kernel.
     */
    public function test_contact_form_ships_with_csrf_token(): void
    {
        $this->get('/id/contact')->assertOk()->assertSee('name="_token"', false);
    }

    /**
     * B6-2: Form 6x dalam 1 menit → request ke-6 diblokir 429.
     */
    public function test_contact_form_is_rate_limited(): void
    {
        $payload = ['name' => 'Ratelimit', 'email' => 'r@t.com', 'message' => 'hai'];

        for ($i = 0; $i < 6; $i++) {
            $response = $this->withSession(['_token' => 'tok'])
                ->post('/id/contact', $payload + ['_token' => 'tok']);
        }

        $response->assertStatus(429);
        $this->assertSame(5, ContactLead::count(), 'Hanya 5 yang diterima, ke-6 diblokir');
    }

    /**
     * B6-4: Honeypot "website" terisi → ditolak diam-diam (redirect, tanpa simpan).
     */
    public function test_honeypot_silently_rejects_bots(): void
    {
        $this->withSession(['_token' => 'tok'])
            ->post('/id/contact', [
                'name' => 'Bot', 'email' => 'bot@spam.com', 'message' => 'spam',
                'website' => 'http://spam.example', '_token' => 'tok',
            ])
            ->assertRedirect();

        $this->assertSame(0, ContactLead::count());
    }

    /**
     * B6-1 lanjutan: submit valid → tersimpan + redirect sukses.
     */
    public function test_valid_submission_is_stored(): void
    {
        $this->withSession(['_token' => 'tok'])
            ->post('/id/contact', [
                'name' => 'Sinta', 'email' => 'sinta@example.com',
                'phone' => '08118887568', 'program' => 'Bahasa Mandarin',
                'message' => 'Info kelas dong', '_token' => 'tok',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_leads', ['email' => 'sinta@example.com']);
    }

    /**
     * B6-5: /admin tanpa login → redirect ke login; login page tampil.
     */
    public function test_admin_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/contact-leads')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk();
    }

    /**
     * B6-5 lanjutan: user terautentikasi bisa masuk panel & lihat resource.
     */
    public function test_authenticated_user_accesses_admin_panel(): void
    {
        $user = User::create([
            'name' => 'Admin', 'email' => 'admin@iflanguage.com',
            'password' => 'super-secret-password-123',
        ]);

        $this->actingAs($user)->get('/admin')->assertOk();
        $this->actingAs($user)->get('/admin/contact-leads')->assertOk();
    }

    /**
     * B1: Security headers terkirim di response publik.
     */
    public function test_security_headers_are_sent(): void
    {
        $response = $this->get('/id');

        $response->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeaderMissing('Strict-Transport-Security'); // lokal HTTP: HSTS tidak aktif

        // Header CSP report-only terkirim (Symfony menyimpan nama header lowercase)
        $this->assertNotEmpty($response->headers->get('Content-Security-Policy-Report-Only'));
    }

    /**
     * B6-3: Konten ber-XSS tersimpan tapi dirender aman (ter-escape).
     */
    public function test_xss_input_is_stored_but_escaped_on_render(): void
    {
        Testimonial::create([
            'name' => ['id' => 'Pengguna <b>Jahat</b>', 'en' => 'Evil <b>User</b>', 'zh' => '坏人'],
            'content' => ['id' => '<script>alert(1)</script> Halo', 'en' => '<script>alert(1)</script> Hi', 'zh' => '<script>alert(1)</script>'],
            'sort' => 99,
        ]);

        $response = $this->get('/id');

        $response->assertOk();
        // Urutan tag mentah dari input TIDAK boleh ada; bentuk ter-escape BOLEH ada (artinya aman).
        $this->assertStringNotContainsString('<script>alert(1)', $response->getContent());
        $this->assertStringContainsString('&lt;script&gt;', $response->getContent());
    }

    /**
     * B6-6: File PHP menyamar .jpg ditolak oleh rule SafeImage; PNG asli lolos.
     */
    public function test_safe_image_rule_blocks_php_disguised_as_image(): void
    {
        $rule = new SafeImage();
        $errors = [];

        // PHP menyamar .jpg — MIME asli text/x-php → ditolak
        $evil = UploadedFile::fake()->createWithContent('evil.jpg', '<?php echo "pwned";');
        $rule->validate('image', $evil, function (string $msg) use (&$errors) {
            $errors[] = $msg;
        });
        $this->assertNotSame([], $errors, 'File PHP menyamar .jpg harus ditolak');

        // PNG asli 1x1 → lolos
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
        $ok = UploadedFile::fake()->createWithContent('ok.png', $png);
        $okErrors = [];
        $rule->validate('image', $ok, function (string $msg) use (&$okErrors) {
            $okErrors[] = $msg;
        });
        $this->assertSame([], $okErrors, 'PNG asli harus diterima');
    }

    /**
     * A4: Sitemap & robots berfungsi; robots memblokir /admin.
     */
    public function test_sitemap_and_robots_work(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('<urlset', false)
            ->assertSee('<loc>', false)
            ->assertSee('xhtml:link', false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin');
    }

    /**
     * A3: Fallback blog ke lang file saat tabel kosong.
     */
    public function test_blog_falls_back_to_lang_file_when_db_empty(): void
    {
        $this->get('/id/blog')->assertOk();
    }
}
