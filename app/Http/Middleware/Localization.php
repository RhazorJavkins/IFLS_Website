<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil segment pertama dari URL (misal: /id/home -> 'id')
        $locale = $request->segment(1);
        
        // Daftar bahasa yang didukung
        $allowedLocales = ['id', 'en', 'zh'];
        
        // Jika segment pertama ada di daftar yang diizinkan, set bahasa aplikasi
        if (in_array($locale, $allowedLocales)) {
            App::setLocale($locale);
        } else {
            // Jika tidak ada (misal akses '/'), default ke bahasa Indonesia
            App::setLocale('id');
        }
        
        return $next($request);
    }
}