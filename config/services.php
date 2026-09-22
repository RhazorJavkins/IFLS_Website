<?php

// Konfigurasi layanan pihak ketiga IFLS.

return [
    'whatsapp' => [
        // Nomor fallback bila form kontak gagal simpan ke DB
        'number' => env('WHATSAPP_NUMBER', '628118887568'),
    ],

    // Google Analytics 4 (script frontend) — kosongkan untuk mematikan
    'analytics' => [
        'ga_id' => env('GA_MEASUREMENT_ID'),
    ],
];
