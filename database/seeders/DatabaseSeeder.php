<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- DATA KURSUS (3 Kursus) ---

        $courses = [
            [
                'id' => 1,
                'name' => [
                    'id' => 'Bahasa Inggris',
                    'en' => 'English',
                    'zh' => '英语'
                ],
                'description' => [
                    'id' => 'Kursus Bahasa Inggris untuk semua level. Dari pemula hingga mahir.',
                    'en' => 'English course for all levels. From beginner to advanced.',
                    'zh' => '适合所有水平的英语课程。从初级到高级。'
                ],
                'level' => 'Pemula',
                'price' => 1500000,
                'duration' => 40,
                'max_students' => 15,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => [
                    'id' => 'Bahasa Mandarin',
                    'en' => 'Mandarin',
                    'zh' => '普通话'
                ],
                'description' => [
                    'id' => 'Kursus Bahasa Mandarin dengan pengajar native. Tersedia HSK preparation.',
                    'en' => 'Mandarin course with native teachers. HSK preparation available.',
                    'zh' => '母语教师授课的普通话课程。提供HSK备考。'
                ],
                'level' => 'Menengah',
                'price' => 2000000,
                'duration' => 50,
                'max_students' => 12,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => [
                    'id' => 'Bahasa Indonesia',
                    'en' => 'Bahasa Indonesia',
                    'zh' => '外籍人士印尼语'
                ],
                'description' => [
                    'id' => 'Kursus Bahasa Indonesia khusus untuk ekspatriat dan pelajar asing.',
                    'en' => 'Indonesian course specifically for expatriates and foreign students.',
                    'zh' => '专为外籍人士和留学生设计的印尼语课程。'
                ],
                'level' => 'Lanjutan',
                'price' => 1800000,
                'duration' => 45,
                'max_students' => 10,
                'is_active' => true,
            ],
        ];

        // Insert ke tabel courses
        foreach ($courses as $course) {
            Course::updateOrCreate(['id' => $course['id']], $course);
        }

        // --- DATA JADWAL (Masing-masing 4 jadwal per kursus) ---

        $schedules = [
            // Course 1 (Inggris)
            ['course_id' => 1, 'type' => 'online', 'day' => 'Senin', 'start_time' => '10:00', 'end_time' => '12:00', 'instructor' => 'Mr. John', 'room' => null, 'quota' => 15, 'is_full' => false],
            ['course_id' => 1, 'type' => 'online', 'day' => 'Rabu', 'start_time' => '19:00', 'end_time' => '21:00', 'instructor' => 'Ms. Sarah', 'room' => null, 'quota' => 15, 'is_full' => false],
            ['course_id' => 1, 'type' => 'offline', 'day' => 'Selasa', 'start_time' => '09:00', 'end_time' => '11:00', 'instructor' => 'Mr. John', 'room' => 'Ruang 101', 'quota' => 10, 'is_full' => false],
            ['course_id' => 1, 'type' => 'offline', 'day' => 'Kamis', 'start_time' => '13:00', 'end_time' => '15:00', 'instructor' => 'Ms. Sarah', 'room' => 'Ruang 205', 'quota' => 10, 'is_full' => false],

            // Course 2 (Mandarin)
            ['course_id' => 2, 'type' => 'online', 'day' => 'Selasa', 'start_time' => '10:00', 'end_time' => '12:00', 'instructor' => '张老师', 'room' => null, 'quota' => 12, 'is_full' => false],
            ['course_id' => 2, 'type' => 'online', 'day' => 'Jumat', 'start_time' => '19:00', 'end_time' => '21:00', 'instructor' => '王老师', 'room' => null, 'quota' => 12, 'is_full' => false],
            ['course_id' => 2, 'type' => 'offline', 'day' => 'Senin', 'start_time' => '09:00', 'end_time' => '11:00', 'instructor' => '张老师', 'room' => 'Ruang 302', 'quota' => 8, 'is_full' => false],
            ['course_id' => 2, 'type' => 'offline', 'day' => 'Rabu', 'start_time' => '14:00', 'end_time' => '16:00', 'instructor' => '李老师', 'room' => 'Ruang 303', 'quota' => 8, 'is_full' => false],

            // Course 3 (Indonesia untuk Asing)
            ['course_id' => 3, 'type' => 'online', 'day' => 'Kamis', 'start_time' => '10:00', 'end_time' => '12:00', 'instructor' => 'Mr. Budi', 'room' => null, 'quota' => 10, 'is_full' => false],
            ['course_id' => 3, 'type' => 'online', 'day' => 'Sabtu', 'start_time' => '09:00', 'end_time' => '11:00', 'instructor' => 'Ms. Siti', 'room' => null, 'quota' => 10, 'is_full' => false],
            ['course_id' => 3, 'type' => 'offline', 'day' => 'Senin', 'start_time' => '13:00', 'end_time' => '15:00', 'instructor' => 'Mr. Budi', 'room' => 'Ruang 101', 'quota' => 7, 'is_full' => false],
            ['course_id' => 3, 'type' => 'offline', 'day' => 'Jumat', 'start_time' => '09:00', 'end_time' => '11:00', 'instructor' => 'Ms. Siti', 'room' => 'Ruang 202', 'quota' => 7, 'is_full' => false],
        ];

        // Insert ke tabel schedules
        foreach ($schedules as $schedule) {
            Schedule::updateOrCreate(
                ['course_id' => $schedule['course_id'], 'day' => $schedule['day'], 'start_time' => $schedule['start_time']],
                $schedule
            );
        }

        $this->command->info('✅ Data kursus dan jadwal berhasil di-seed!');
    }
}