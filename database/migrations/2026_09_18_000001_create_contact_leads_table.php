<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('program')->nullable();   // program yang diminati (opsional)
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('locale', 5)->default('id'); // bahasa saat submit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_leads');
    }
};
