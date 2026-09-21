<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Mengisi tabel konten dari lang/{id,en,zh}/messages.php —
 * teks hasil seed 100% identik dengan yang sekarang tampil di situs.
 * Idempotent: truncate dulu lalu isi ulang.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $lang = fn (string $locale): array => require lang_path("{$locale}/messages.php");

        $id = $lang('id');
        $en = $lang('en');
        $zh = $lang('zh');

        // ===== TESTIMONIALS =====
        Testimonial::query()->delete();
        foreach ([1, 2, 3] as $i) {
            Testimonial::create([
                'name' => [
                    'id' => $id["testimonial{$i}_name"] ?? '',
                    'en' => $en["testimonial{$i}_name"] ?? '',
                    'zh' => $zh["testimonial{$i}_name"] ?? '',
                ],
                'content' => [
                    'id' => $id["testimonial{$i}"] ?? '',
                    'en' => $en["testimonial{$i}"] ?? '',
                    'zh' => $zh["testimonial{$i}"] ?? '',
                ],
                'sort' => $i,
            ]);
        }

        // ===== FAQS =====
        Faq::query()->delete();
        $faqCount = count($id['faq_items'] ?? []);
        for ($i = 0; $i < $faqCount; $i++) {
            Faq::create([
                'question' => [
                    'id' => $id['faq_items'][$i]['q'] ?? '',
                    'en' => $en['faq_items'][$i]['q'] ?? '',
                    'zh' => $zh['faq_items'][$i]['q'] ?? '',
                ],
                'answer' => [
                    'id' => $id['faq_items'][$i]['a'] ?? '',
                    'en' => $en['faq_items'][$i]['a'] ?? '',
                    'zh' => $zh['faq_items'][$i]['a'] ?? '',
                ],
                'sort' => $i + 1,
            ]);
        }

        // ===== POSTS (dari blog_post1..3) =====
        Post::query()->delete();
        for ($i = 1; $i <= 3; $i++) {
            $title = [
                'id' => $id["blog_post{$i}_title"] ?? '',
                'en' => $en["blog_post{$i}_title"] ?? '',
                'zh' => $zh["blog_post{$i}_title"] ?? '',
            ];

            Post::create([
                'slug' => Str::slug($title['en'] ?: "post-{$i}") ?: "post-{$i}",
                'title' => $title,
                'excerpt' => [
                    'id' => $id["blog_post{$i}_excerpt"] ?? '',
                    'en' => $en["blog_post{$i}_excerpt"] ?? '',
                    'zh' => $zh["blog_post{$i}_excerpt"] ?? '',
                ],
                'body' => [
                    'id' => $id["blog_post{$i}_excerpt"] ?? '',
                    'en' => $en["blog_post{$i}_excerpt"] ?? '',
                    'zh' => $zh["blog_post{$i}_excerpt"] ?? '',
                ],
                'is_published' => true,
                'published_at' => now()->subDays((3 - $i) * 10),
            ]);
        }

        $this->command?->info('ContentSeeder: testimonials=' . Testimonial::count() . ', faqs=' . Faq::count() . ', posts=' . Post::count());
    }
}
