<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Murid (tanpa login — dikelola guru/admin)
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Kelas (satu guru, satu program kursus)
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->string('status', 20)->default('active'); // active|finished|cancelled
            $table->timestamps();
        });

        // Pivot murid ⇄ kelas
        Schema::create('class_student', function (Blueprint $table) {
            $table->primary(['school_class_id', 'student_id']);
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        });

        // Pertemuan
        Schema::create('class_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sequence'); // pertemuan ke-
            $table->date('session_date');
            $table->string('material', 500)->nullable(); // materi yang diajarkan
            $table->timestamps();
            $table->unique(['school_class_id', 'sequence']);
        });

        // Absensi per murid per pertemuan (unique — anti duplikat)
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('status', 10)->default('present'); // present|excused|sick|absent
            $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique(['class_session_id', 'student_id']);
        });

        // Nilai (skor tertimbang)
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20); // quiz|exam|assignment|practice
            $table->string('title', 150)->nullable(); // mis. "Ujian Tengah"
            $table->decimal('score', 5, 2); // 0–100
            $table->decimal('weight', 4, 2)->default(1); // bobot penilaian
            $table->date('graded_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('class_sessions');
        Schema::dropIfExists('class_student');
        Schema::dropIfExists('school_classes');
        Schema::dropIfExists('students');
    }
};
