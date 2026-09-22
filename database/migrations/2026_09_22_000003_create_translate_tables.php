<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Proyek penerjemahan
        Schema::create('translate_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('client_name', 150);
            $table->string('client_phone', 30)->nullable();
            $table->string('source_lang', 10)->default('id'); // id|en|zh
            $table->string('target_lang', 10)->default('en');
            $table->string('service', 30)->default('document'); // document|sworn|interpretation
            $table->date('deadline')->nullable();
            $table->string('status', 20)->default('incoming'); // incoming|in_progress|review|completed|cancelled
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('price', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Dokumen — disimpan di disk PRIVAT (storage/app/private/documents),
        // unduhan hanya via route ter-proteksi auth+role.
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translate_job_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('file_path'); // path di disk 'local' (privat)
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
        Schema::dropIfExists('translate_jobs');
    }
};
