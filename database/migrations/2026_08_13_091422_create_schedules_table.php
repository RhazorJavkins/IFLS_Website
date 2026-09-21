<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['online', 'offline']);  // online atau offline
            $table->string('day');                        // Senin, Selasa, dst.
            $table->time('start_time');
            $table->time('end_time');
            $table->string('instructor');                 // Nama pengajar
            $table->string('room')->nullable();           // Ruangan (khusus offline)
            $table->integer('quota');                     // Kuota siswa
            $table->boolean('is_full')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};