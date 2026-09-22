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

// ===== PORTAL INTERNAL (auth + role) =====
// Export CSV absensi & nilai (di luar panel Filament agar bisa di-link langsung)
Route::middleware(['auth', 'role:admin,teacher'])->group(function () {
    Route::get('/portal/training/{class}/absensi.csv', [App\Http\Controllers\Portal\TrainingExportController::class, 'attendanceCsv'])
        ->name('portal.training.attendance.csv');
    Route::get('/portal/training/{class}/nilai.csv', [App\Http\Controllers\Portal\TrainingExportController::class, 'gradesCsv'])
        ->name('portal.training.grades.csv');
});

// Unduh dokumen terjemahan (disk privat — hanya penerjemah & admin)
Route::get('/portal/translate/documents/{document}/download', [App\Http\Controllers\Portal\DocumentDownloadController::class, 'download'])
    ->middleware(['auth', 'role:admin,translator'])
    ->name('portal.translate.documents.download');

// Export CSV leads (portal translate)
Route::get('/portal/translate/leads.csv', [App\Http\Controllers\Portal\LeadExportController::class, 'csv'])
    ->middleware(['auth', 'role:admin,translator'])
    ->name('portal.translate.leads.csv');

// Sitemap & robots (tanpa prefix locale)
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    return response()
        ->view('robots')
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');
