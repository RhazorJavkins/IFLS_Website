<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Halaman daftar semua kursus
    public function index(Request $request)
    {
        $level = $request->input('level'); // Ambil filter level dari URL

        $courses = Course::query()
            ->when($level, function ($query, $level) {
                return $query->where('level', $level);
            })
            ->where('is_active', true)
            ->get();

        return view('courses.index', compact('courses', 'level'));
    }

    // Halaman detail kursus (termasuk jadwal)
    public function show($locale, Course $course)
    {
        // Route model binding otomatis memuat Course berdasarkan {course} di URL.
        // Catatan: urutan parameter method harus sama dengan urutan parameter route
        // ({locale} dulu, baru {course}), karena Laravel meneruskannya berdasarkan posisi.
        // Halaman detail tidak boleh menampilkan kursus yang non-aktif.
        abort_if(! $course->is_active, 404);

        $course->load('schedules');
        $onlineSchedules = $course->schedules->where('type', 'online');
        $offlineSchedules = $course->schedules->where('type', 'offline');
        return view('courses.show', compact('course', 'onlineSchedules', 'offlineSchedules'));
    }
}