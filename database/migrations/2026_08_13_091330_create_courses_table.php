<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->json('name');              // {"id":"Bahasa Inggris","en":"English","zh":"英语"}
            $table->json('description');       // {"id":"Kursus...","en":"Course...","zh":"课程..."}
            $table->string('level');           // Pemula, Menengah, Lanjutan
            $table->decimal('price', 10, 2);   // Harga kursus
            $table->integer('duration');       // Durasi dalam jam
            $table->integer('max_students');   // Maksimum siswa per kelas
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};