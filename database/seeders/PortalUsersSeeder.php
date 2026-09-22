<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun contoh untuk portal training & translate.
 *
 * Aman dijalankan berulang: akun yang SUDAH ADA tidak pernah disentuh
 * password-nya (hanya nama/role yang disinkronkan) — mencegah password
 * admin/guru/translator ter-reset tak sengaja saat `php artisan db:seed`.
 *
 * Password default di bawah hanya untuk DEV — WAJIB diganti setelah
 * login pertama (admin dapat me-reset via /admin → Sistem → Pengguna).
 */
class PortalUsersSeeder extends Seeder
{
    /** @return array<int, array{0: string, 1: string, 2: string, 3: string}> email, nama, role, password default (dev) */
    protected function accounts(): array
    {
        return [
            ['admin@iflanguage.com', 'Admin IFLS', User::ROLE_ADMIN, 'admin-ifls-2026'],
            ['guru@iflanguage.com', 'Guru Contoh', User::ROLE_TEACHER, 'guru-ifls-2026'],
            ['translator@iflanguage.com', 'Penerjemah Contoh', User::ROLE_TRANSLATOR, 'translator-ifls-2026'],
        ];
    }

    public function run(): void
    {
        foreach ($this->accounts() as [$email, $name, $role, $defaultPassword]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $name, 'role' => $role, 'password' => Hash::make($defaultPassword)]
            );

            if (! $user->wasRecentlyCreated) {
                // Akun sudah ada (dibuat manusia / password sudah diganti):
                // sinkronkan nama & role saja, JANGAN sentuh password.
                $user->fill(['name' => $name, 'role' => $role])->save();
            }
        }

        $this->command->info('✅ Akun portal dipastikan ada: admin / guru / translator (password existing tidak diubah)');
    }
}
