<?php

// Konfigurasi security tambahan IFLS.
// CSP di-set Report-Only dulu (tidak memblokir, hanya log) — setelah 1-2 hari
// log bersih, set SECURITY_CSP_ENFORCE=true di .env untuk mengaktifkan penuh.

return [
    'csp_enforce' => env('SECURITY_CSP_ENFORCE', false),

    // Allowlist IP untuk panel admin (dipisah koma). Kosong = tidak dibatasi.
    'admin_ip_allowlist' => env('ADMIN_IP_ALLOWLIST', ''),

    'csp' => implode('; ', [
        "default-src 'self'",
        // 'unsafe-inline' untuk Blade inline script/style + GA + Google Maps
        "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://www.googletagmanager.com https://maps.googleapis.com",
        "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://use.fontawesome.com",
        "font-src 'self' data: https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.gstatic.com https://use.fontawesome.com",
        "img-src 'self' data: blob: https:",
        "frame-src 'self' https://www.google.com https://maps.google.com",
        "connect-src 'self' https://www.google-analytics.com https://region1.google-analytics.com https://maps.googleapis.com",
        "object-src 'none'",
        "base-uri 'self'",
        "frame-ancestors 'self'",
    ]),
];
