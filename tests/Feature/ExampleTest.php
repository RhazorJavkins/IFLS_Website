<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Root path redirects to the Indonesian home page.
     */
    public function test_root_redirects_to_localized_home(): void
    {
        $this->get('/')->assertRedirect('/id');
    }

    /**
     * Localized home page loads successfully.
     */
    public function test_home_page_loads(): void
    {
        $this->get('/id')->assertOk();
        $this->get('/en')->assertOk();
        $this->get('/zh')->assertOk();
    }

    /**
     * Course listing page shows seeded courses.
     */
    public function test_course_listing_loads_with_seeded_courses(): void
    {
        $this->seed();

        $this->get('/id/courses')
            ->assertOk()
            ->assertSee('Bahasa Inggris')
            ->assertSee('Bahasa Mandarin');
    }

    /**
     * Course detail page loads with schedules.
     */
    public function test_course_detail_loads(): void
    {
        $this->seed();

        $this->get('/id/courses/1')
            ->assertOk()
            ->assertSee('Jadwal Online')
            ->assertSee('Ruang 101');
    }

    /**
     * Locale must be one of the supported languages.
     */
    public function test_unsupported_locale_is_rejected(): void
    {
        $this->get('/fr/about')->assertNotFound();
        $this->get('/foo/courses')->assertNotFound();
    }

    /**
     * Course detail page must hide inactive courses.
     */
    public function test_inactive_course_detail_is_not_found(): void
    {
        $this->seed();

        \App\Models\Course::where('id', 1)->update(['is_active' => false]);

        $this->get('/id/courses/1')->assertNotFound();
    }
}
