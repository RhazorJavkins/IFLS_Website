<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // DB-first dengan fallback ke lang file — situs tetap tampil
        // walau tabel konten kosong (mis. baru setup, belum di-seed).
        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return view('home', [
            'dbTestimonials' => $testimonials,
            'dbFaqs' => $faqs,
        ]);
    }
}
