<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel konten Fase 4 — semua kolom teks memakai JSON {"id":"...","en":"...","zh":"..."}.
// Situs tetap punya fallback ke lang file jika tabel kosong (lihat HomeController/PageController).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->json('name');      // {"id":"Rina — Marketing","en":"...","zh":"..."}
            $table->json('content');   // isi testimoni per bahasa
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->json('question');
            $table->json('answer');
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // nama perusahaan
            $table->string('initial', 4);    // inisial untuk placeholder logo
            $table->string('color', 9)->default('#1a2a4f'); // warna placeholder
            $table->string('url')->nullable();
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('image');   // path relatif storage/public
            $table->json('caption')->nullable();
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title');
            $table->json('excerpt');
            $table->json('body');      // paragraf dipisah baris kosong
            $table->string('cover_image')->nullable(); // path storage/public, null = gradient
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('key')->primary();   // mis. contact_programs, office_hours
            $table->json('value');              // bebas: teks i18n atau struktur
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
    }
};
