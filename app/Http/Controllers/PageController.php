<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function services()
    {
        return view('services');
    }

    public function blog()
    {
        $posts = Post::query()->published()->orderByDesc('published_at')->get();

        return view('blog', ['posts' => $posts]);
    }

    public function blogShow(string $locale, string $slug)
    {
        $post = Post::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.show', ['post' => $post]);
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function contact()
    {
        // Time-trap anti-bot: catat waktu form dibuka (dipakai ContactController.store)
        session(['contact_form_opened_at' => now()->getTimestamp()]);

        return view('contact');
    }
}
