<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PricingPlan;
use App\Models\Program;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Halaman daftar semua kursus — DB-first (CMS) dengan fallback ke lang file
    public function index(Request $request)
    {
        $programs = Program::query()
            ->with(['features' => fn ($q) => $q->where('is_active', true)->orderBy('sort')])
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        $pricingPlans = PricingPlan::query()
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();

        return view('courses.index', [
            'dbPrograms' => $programs,
            'dbPricingPlans' => $pricingPlans,
        ]);
    }

    // Halaman detail kursus (termasuk jadwal)
    public function show($locale, Course $course)
    {
        // Route model binding otomatis memuat Course berdasarkan {course} di URL.
        // Catatan: urutan parameter method harus sama dengan urutan parameter route
        // ({locale} dulu, baru {course}), karena Laravel meneruskannya berdasarkan posisi.
        // Halaman detail tidak boleh menampilkan kursus yang non-aktif.
        abort_if(! $course->is_active, 404);

        $course->load(['program', 'schedules']);
        $onlineSchedules = $course->schedules->where('type', 'online');
        $offlineSchedules = $course->schedules->where('type', 'offline');
        return view('courses.show', compact('course', 'onlineSchedules', 'offlineSchedules'));
    }
}
