<?php

// Konfigurasi layanan pihak ketiga IFLS.

return [
    'whatsapp' => [
        // Nomor fallback bila form kontak gagal simpan ke DB
        'number' => env('WHATSAPP_NUMBER', '628118887568'),
    ],
];
