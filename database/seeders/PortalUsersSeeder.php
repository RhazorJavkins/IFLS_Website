<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun contoh untuk portal training & translate.
 * Idempotent: updateOrCreate berdasarkan email.
 *
 * Password default hanya untuk DEV — ganti segera di produksi
 * (admin dapat mereset lewat /admin → Pengguna).
 */
class PortalUsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@iflanguage.com'],
            ['name' => 'Admin IFLS', 'password' => Hash::make('admin-ifls-2026'), 'role' => User::ROLE_ADMIN]
        );

        User::updateOrCreate(
            ['email' => 'guru@iflanguage.com'],
            ['name' => 'Guru Contoh', 'password' => Hash::make('guru-ifls-2026'), 'role' => User::ROLE_TEACHER]
        );

        User::updateOrCreate(
            ['email' => 'translator@iflanguage.com'],
            ['name' => 'Penerjemah Contoh', 'password' => Hash::make('translator-ifls-2026'), 'role' => User::ROLE_TRANSLATOR]
        );

        $this->command->info('✅ Akun portal siap: admin / guru / translator (password lihat PortalUsersSeeder.php)');
    }
}
