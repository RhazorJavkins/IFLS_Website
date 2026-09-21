<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $legacy = config('team');

        // --- Direksi (2) ---
        foreach ($legacy['directors'] ?? [] as $d) {
            $photo = $this->importPhoto($d['photo']);
            TeamMember::updateOrCreate(
                ['name' => $d['py']],
                [
                    'name_cn' => $d['cn'],
                    'role' => ['id' => $d['role_id'], 'en' => $d['role_en'], 'zh' => $d['role_cn']],
                    'photo' => $photo,
                    'is_director' => true,
                    'show_on_home' => true,
                    'sort' => 0,
                    'is_active' => true,
                ]
            );
        }

        // --- Staf (5) ---
        foreach ($legacy['team'] ?? [] as $i => $m) {
            $photo = $this->importPhoto($m['photo']);
            TeamMember::updateOrCreate(
                ['name' => $m['py']],
                [
                    'name_cn' => $m['cn'],
                    'role' => ['id' => $m['role_id'], 'en' => $m['role_en'], 'zh' => $m['role_cn']],
                    'photo' => $photo,
                    'is_director' => false,
                    'show_on_home' => $i < ($legacy['home_limit'] ?? 4),
                    'sort' => $i + 1,
                    'is_active' => true,
                ]
            );
        }

        $this->command?->info('✅ Team seeded: '.TeamMember::count().' anggota (direksi + staf)');
    }

    // Foto legacy tetap dirujuk langsung dari public/images/team (path "images/team/..."),
    // upload CMS baru masuk storage/public/team (path "team/...").
    private function importPhoto(string $file): string
    {
        return 'images/team/'.$file;
    }
}
