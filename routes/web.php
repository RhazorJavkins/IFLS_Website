<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;

// ===== REDIRECT HOME TANPA PREFIX =====
Route::get('/', function () {
    return redirect()->route('home', ['locale' => 'id']); // Default ke bahasa Indonesia
});

// Semua halaman memakai prefix bahasa (/{locale}/...)
Route::group(['prefix' => '{locale}', 'middleware' => 'locale', 'where' => ['locale' => 'id|en|zh']], function () {

    // Halaman Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Halaman statis (controller agar bisa diberi middleware/rate limit)
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/services', [PageController::class, 'services'])->name('services');

    // Halaman blog (daftar + detail dari DB)
    Route::get('/blog', [PageController::class, 'blog'])->name('blog');
    Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('blog.show');
    Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');

    // Halaman kursus
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

    // Submit form kontak → simpan lead (rate limit 5x/menit per IP, anti-spam di controller)
    Route::post('/contact', [ContactController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('contact.store');
});

// Sitemap & robots (tanpa prefix locale)
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    return response()
        ->view('robots')
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');
