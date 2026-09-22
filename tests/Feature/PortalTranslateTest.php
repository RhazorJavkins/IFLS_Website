<?php

namespace Tests\Feature;

use App\Models\ContactLead;
use App\Models\Document;
use App\Models\TranslateJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortalTranslateTest extends TestCase
{
    use RefreshDatabase;

    private User $translator;

    private User $teacher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->translator = User::create([
            'name' => 'Penerjemah', 'email' => 'trans@example.test',
            'password' => 'password-rahasia-12', 'role' => User::ROLE_TRANSLATOR,
        ]);
        $this->teacher = User::create([
            'name' => 'Guru', 'email' => 'guru@example.test',
            'password' => 'password-rahasia-12', 'role' => User::ROLE_TEACHER,
        ]);
    }

    /** Dokumen tersimpan di disk PRIVAT, bukan public. */
    public function test_document_is_stored_in_private_disk(): void
    {
        Storage::fake('local');

        $job = TranslateJob::create([
            'title' => 'Akta Kelahiran', 'client_name' => 'Klien A',
            'source_lang' => 'id', 'target_lang' => 'en', 'service' => 'sworn',
        ]);

        $path = UploadedFile::fake()->createWithContent('akta.pdf', '%PDF-1.4 test')->store('documents', 'local');

        $doc = Document::create([
            'translate_job_id' => $job->id,
            'uploaded_by' => $this->translator->id,
            'title' => 'Akta Kelahiran',
            'file_path' => $path,
            'mime_type' => 'application/pdf',
            'size_bytes' => 1024,
        ]);

        Storage::disk('local')->assertExists($path);

        // Unduhan via route privat
        $this->actingAs($this->translator)
            ->get("/portal/translate/documents/{$doc->id}/download")
            ->assertOk();

        // Guru (role salah) → 403 — middleware juga membersihkan session
        $this->actingAs($this->teacher)
            ->get("/portal/translate/documents/{$doc->id}/download")
            ->assertForbidden();

        auth()->logout(); // request tamu bersih (middleware 403 sudah logout paksa)

        // Tamu → redirect login
        $this->get("/portal/translate/documents/{$doc->id}/download")->assertRedirect();
    }

    /** Hapus dokumen menghapus file fisiknya. */
    public function test_deleting_document_removes_file(): void
    {
        Storage::fake('local');

        $path = UploadedFile::fake()->createWithContent('a.pdf', 'x')->store('documents', 'local');
        $doc = Document::create([
            'title' => 'Doc', 'file_path' => $path, 'uploaded_by' => $this->translator->id,
        ]);

        $doc->delete();

        Storage::disk('local')->assertMissing($path);
    }

    /** Proyek terjemahan: urutan status & badge bekerja. */
    public function test_translate_job_lifecycle(): void
    {
        $job = TranslateJob::create([
            'title' => 'Kontrak Kerja', 'client_name' => 'PT B',
            'source_lang' => 'en', 'target_lang' => 'zh', 'service' => 'document',
            'status' => 'in_progress', 'deadline' => now()->addDays(3),
        ]);

        $this->assertSame('Dikerjakan', TranslateJob::STATUSES[$job->status]);
        $this->assertTrue($job->deadline->isFuture());
    }

    /** Leads di portal translate read-only — tak bisa edit/hapus, tapi bisa tandai dihubungi via action model. */
    public function test_lead_can_be_marked_contacted(): void
    {
        $lead = ContactLead::create([
            'name' => 'Prospek', 'email' => 'prospek@example.test',
            'message' => 'Halo, mau tanya kursus Mandarin', 'locale' => 'id',
        ]);

        $lead->update(['contacted_at' => now()]);

        $this->assertNotNull($lead->fresh()->contacted_at);
    }

    /** Export CSV leads: penerjemah boleh, guru tidak. */
    public function test_leads_csv_access_control(): void
    {
        $this->actingAs($this->translator)->get('/portal/translate/leads.csv')->assertOk();
        $this->actingAs($this->teacher)->get('/portal/translate/leads.csv')->assertForbidden();
    }
}
