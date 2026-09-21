<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            // Identitas
            $table->string('name');           // Nama alfabet, mis. "YI YAN"
            $table->string('name_cn')->nullable(); // Nama karakter China, mis. "易衍"
            // Jabatan i18n (JSON: {"id": "...", "en": "...", "zh": "..."})
            $table->json('role');
            // Bio i18n (opsional — dipakai kartu direksi di halaman About)
            $table->json('bio')->nullable();
            $table->string('photo');          // path di storage/public, mis. "team/yiyan.png"
            // Sifat kartu
            $table->string('quote', 300)->nullable(); // Kutipan footer kartu direksi
            $table->boolean('is_director')->default(false);
            $table->boolean('show_on_home')->default(true);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
