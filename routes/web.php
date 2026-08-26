<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;

// ===== REDIRECT HOME TANPA PREFIX =====
Route::get('/', function () {
    return redirect()->route('home', ['locale' => 'id']); // Default ke bahasa Indonesia
});

// Semua halaman memakai prefix bahasa (/{locale}/...)
Route::group(['prefix' => '{locale}', 'middleware' => 'locale', 'where' => ['locale' => 'id|en|zh']], function () {
    
    // Halaman Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Halaman About (sementara pakai closure, nanti kita buat controllernya)
    Route::get('/about', function () {
        return view('about');
    })->name('about');
    
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    
    // Halaman Layanan
    Route::get('/services', function () {
        return view('services');
    })->name('services');
    
    // Halaman Blog
    Route::get('/blog', function () {
        return view('blog');
    })->name('blog');
    
    // Halaman Galeri
    Route::get('/gallery', function () {
        return view('gallery');
    })->name('gallery');
    
    // Halaman Kontak
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
});