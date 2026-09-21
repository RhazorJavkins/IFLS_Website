<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $locales = ['id', 'en', 'zh'];
        $staticRoutes = ['home', 'about', 'courses.index', 'services', 'blog', 'gallery', 'contact'];

        // Setiap entri: loc + daftar alternatif hreflang (termasuk x-default → id)
        $entries = [];

        foreach ($staticRoutes as $name) {
            $alts = [];
            foreach ($locales as $locale) {
                $alts[$locale] = route($name, $locale);
            }
            $entries[] = [
                'loc' => $alts['id'],
                'alts' => $alts + ['x-default' => $alts['id']],
                'priority' => $name === 'home' ? '1.0' : '0.8',
                'changefreq' => 'weekly',
            ];
        }

        foreach (Course::query()->where('is_active', true)->get(['id']) as $course) {
            $alts = [];
            foreach ($locales as $locale) {
                $alts[$locale] = route('courses.show', ['locale' => $locale, 'course' => $course->id]);
            }
            $entries[] = [
                'loc' => $alts['id'],
                'alts' => $alts + ['x-default' => $alts['id']],
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        foreach (Post::query()->published()->get(['slug']) as $post) {
            $alts = [];
            foreach ($locales as $locale) {
                $alts[$locale] = route('blog.show', ['locale' => $locale, 'slug' => $post->slug]);
            }
            $entries[] = [
                'loc' => $alts['id'],
                'alts' => $alts + ['x-default' => $alts['id']],
                'priority' => '0.6',
                'changefreq' => 'monthly',
            ];
        }

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
