<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use App\Models\Program;
use App\Models\ProgramFeature;
use Illuminate\Database\Seeder;

/**
 * Seeder restrukturisasi Courses (Fase 5): mengisi programs, program_features,
 * pricing_plans, dan menautkan ulang courses — teks dibaca langsung dari
 * lang/{id,en,zh}/messages.php sehingga 100% identik dengan tampilan sebelumnya.
 * Idempotent: bersihkan lalu isi ulang.
 */
class CourseContentSeeder extends Seeder
{
    public function run(): void
    {
        $lang = fn (string $locale): array => require lang_path("{$locale}/messages.php");

        $id = $lang('id');
        $en = $lang('en');
        $zh = $lang('zh');

        // Helper: bangun JSON i18n dari 3 key lang
        $i18n = fn (string $key): array => [
            'id' => $id[$key] ?? '',
            'en' => $en[$key] ?? '',
            'zh' => $zh[$key] ?? '',
        ];

        // ===== PROGRAMS =====
        Program::query()->delete();

        $programs = [
            [
                'slug' => 'bahasa-indonesia',
                'name' => $i18n('prog_indo'),
                'badge' => $i18n('badge_flagship'),
                'intro' => $i18n('ci_hero_desc'),
                'emoji' => '🇮🇩',
                'color' => '#B01C1C',
                'display_style' => 'tabs',
                'group_meta' => [
                    'level' => ['title' => $i18n('levels_title'), 'icon' => 'fa-layer-group'],
                    'format' => ['title' => $i18n('format_title'), 'icon' => 'fa-display'],
                    'service_type' => ['title' => $i18n('services_type_title'), 'icon' => 'fa-handshake'],
                ],
                'is_flagship' => true,
                'show_coming_soon' => false,
                'cta_text' => $i18n('courses_cta_id_sub'),
                'wa_prefill' => 'Halo IF Language School - Info Bahasa Indonesia',
                'sort' => 1,
            ],
            [
                'slug' => 'mandarin',
                'name' => $i18n('prog_mandarin'),
                'badge' => $i18n('badge_online_privat'),
                'intro' => $i18n('cm_hero_desc'),
                'emoji' => '🇨🇳',
                'color' => '#1A2A4F',
                'display_style' => 'stepper',
                'group_meta' => [
                    'tier' => ['title' => $i18n('cm_tingkat_title'), 'icon' => 'fa-route'],
                ],
                'is_flagship' => false,
                'show_coming_soon' => true,
                'cta_text' => $i18n('courses_cta_mandarin_sub'),
                'wa_prefill' => 'Halo IF Language School - Info Mandarin',
                'sort' => 2,
            ],
            [
                'slug' => 'english',
                'name' => $i18n('prog_english'),
                'badge' => $i18n('badge_small_class'),
                'intro' => $i18n('ce_hero_desc'),
                'emoji' => '🇬🇧',
                'color' => '#1B4332',
                'display_style' => 'cards',
                'group_meta' => [
                    'highlight' => ['title' => $i18n('ce_placement_title'), 'icon' => 'fa-chart-simple'],
                ],
                'is_flagship' => false,
                'show_coming_soon' => false,
                'cta_text' => $i18n('courses_cta_english_sub'),
                'wa_prefill' => 'Halo IF Language School - Info English Class',
                'sort' => 3,
            ],
        ];

        $programIds = [];
        foreach ($programs as $data) {
            $programIds[$data['slug']] = Program::create($data)->id;
        }

        // ===== PROGRAM FEATURES =====
        ProgramFeature::query()->delete();

        $features = [
            // --- Bahasa Indonesia: levels (tab pills) ---
            ['bahasa-indonesia', 'level', 'ci_lvl1', 'ci_lvl1_desc', null, null, 1],
            ['bahasa-indonesia', 'level', 'ci_lvl2', 'ci_lvl2_desc', null, null, 2],
            ['bahasa-indonesia', 'level', 'ci_lvl3', 'ci_lvl3_desc', null, null, 3],
            // --- Bahasa Indonesia: format ---
            ['bahasa-indonesia', 'format', 'format_offline', 'format_offline_desc', 'fa-school', null, 1],
            ['bahasa-indonesia', 'format', 'format_online', 'format_online_desc', 'fa-video', null, 2],
            // --- Bahasa Indonesia: service types ---
            ['bahasa-indonesia', 'service_type', 'svc_type_regular', 'svc_type_regular_desc', 'fa-users', null, 1],
            ['bahasa-indonesia', 'service_type', 'svc_type_private', 'svc_type_private_desc', 'fa-user-check', '+', 2],
            ['bahasa-indonesia', 'service_type', 'svc_type_corporate', 'svc_type_corporate_desc', 'fa-building', '+', 3],
            // --- Mandarin: tier (stepper) ---
            ['mandarin', 'tier', 'cm_t1', 'cm_t1_desc', 'fa-seedling', null, 1],
            ['mandarin', 'tier', 'cm_t2', 'cm_t2_desc', 'fa-comments', null, 2],
            ['mandarin', 'tier', 'cm_t3', 'cm_t3_desc', 'fa-briefcase', null, 3],
            // --- English: highlight (kartu placement test) ---
            ['english', 'highlight', 'ce_placement_title', 'ce_placement_desc', 'fa-chart-simple', null, 1],
        ];

        foreach ($features as [$slug, $group, $titleKey, $descKey, $icon, $badge, $sort]) {
            ProgramFeature::create([
                'program_id' => $programIds[$slug],
                'group' => $group,
                'title' => $i18n($titleKey),
                'description' => $i18n($descKey),
                'icon' => $icon,
                'badge' => $badge,
                'sort' => $sort,
            ]);
        }

        // ===== PRICING PLANS =====
        PricingPlan::query()->delete();
        foreach ([
            ['fa-users', 'pricing_group', 'pricing_group_price', 1],
            ['fa-user-check', 'pricing_private', 'pricing_private_price', 2],
            ['fa-building', 'pricing_corporate', 'pricing_corporate_price', 3],
        ] as [$icon, $nameKey, $noteKey, $sort]) {
            PricingPlan::create([
                'icon' => $icon,
                'name' => $i18n($nameKey),
                'price_note' => $i18n($noteKey),
                'sort' => $sort,
            ]);
        }

        // ===== COURSES: tautkan ke program, harga null (kebijakan: hubungi untuk harga) =====
        \App\Models\Course::query()->update([
            'program_id' => null, 'sort' => 0, 'price' => null,
        ]);
        \App\Models\Course::where('id', 1)->update(['program_id' => $programIds['english'], 'sort' => 1]);
        \App\Models\Course::where('id', 2)->update(['program_id' => $programIds['mandarin'], 'sort' => 2]);
        \App\Models\Course::where('id', 3)->update(['program_id' => $programIds['bahasa-indonesia'], 'sort' => 3]);

        $this->command?->info('CourseContentSeeder: programs=' . Program::count() . ', features=' . ProgramFeature::count() . ', pricing=' . PricingPlan::count());
    }
}
