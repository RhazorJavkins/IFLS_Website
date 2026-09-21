<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Restrukturisasi Courses → CMS (Fase 5):
// - programs: pengganti 3 section program yang sebelumnya hardcode di view
// - program_features: blok konten per program (level/tier/format/service_type/highlight)
// - pricing_plans: pengganti section "Informasi Harga"
// - courses: jadi kelas nyata di bawah program (program_id + price nullable + sort)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();       // = anchor URL: bahasa-indonesia, mandarin, english
            $table->json('name');                   // {"id":"Bahasa Indonesia untuk WNA",...}
            $table->json('badge');                  // {"id":"Program Unggulan",...}
            $table->json('intro');                  // deskripsi hero program
            $table->string('emoji', 8)->default('');
            $table->string('color', 9)->default('#1A2A4F'); // warna kotak CTA
            $table->string('display_style', 20)->default('cards'); // tabs | stepper | cards
            $table->json('group_meta')->nullable(); // {group: {title:{id,en,zh}, icon}}
            $table->boolean('is_flagship')->default(false);
            $table->boolean('show_coming_soon')->default(false);
            $table->json('cta_text');               // sub-teks kotak CTA (courses_cta_*_sub)
            $table->string('wa_prefill')->nullable(); // teks prefill WhatsApp
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('program_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->string('group', 20);            // level | tier | format | service_type | highlight
            $table->json('title');
            $table->json('description');
            $table->string('icon')->nullable();     // ikon FontAwesome
            $table->string('badge', 10)->nullable();// badge tambahan (mis. "+")
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->json('name');                   // {"id":"Kelas Reguler (Kelompok)",...}
            $table->json('price_note');             // {"id":"Hubungi untuk harga",...}
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('program_id')->nullable()->after('id')->constrained('programs')->nullOnDelete();
            $table->decimal('price', 10, 2)->nullable()->change(); // null = "Hubungi untuk harga"
            $table->unsignedTinyInteger('sort')->default(0)->after('max_students');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('program_id');
            $table->decimal('price', 10, 2)->change();
            $table->dropColumn('sort');
        });
        Schema::dropIfExists('pricing_plans');
        Schema::dropIfExists('program_features');
        Schema::dropIfExists('programs');
    }
};
