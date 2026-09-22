<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->string('location', 120)->nullable()->after('course_id')
                ->comment('Lokasi kelas: ruangan (mis. Ruang 101) atau Online');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('wechat_id', 60)->nullable()->after('phone')
                ->comment('ID WeChat murid');
        });
    }

    public function down(): void
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('location');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('wechat_id');
        });
    }
};
