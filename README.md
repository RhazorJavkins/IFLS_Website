# 🌏 IF Language School — Website & CMS

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![Filament](https://img.shields.io/badge/Filament-4-CMS-f59e0b)](https://filamentphp.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-7952B3?logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Tests](https://img.shields.io/badge/tests-23%20passing-brightgreen)](#perintah-sehari-hari)
[![Languages](https://img.shields.io/badge/bahasa-ID%20%7C%20EN%20%7C%20ZH-blue)](#)

Website resmi + sistem manajemen konten **IF Language School** — lembaga bahasa Indonesia ⇄ China (didirikan 2012 sebagai IF Language Center, rebrand 2026). Mitra **Badan Bahasa Kemendikbudristek**. 3 kota: Jakarta · Semarang · Surabaya.

> Satu aplikasi: **Blade** untuk halaman publik + **Filament** untuk panel admin — berbagi model, database, dan lang files. Tidak ada duplikasi codebase.

## ✨ Fitur

| Area | Detail |
|---|---|
| 🌐 Halaman publik | Beranda, Tentang, Kursus, Terjemahan, Blog (+ detail), Galeri, Kontak, 404 — full i18n **id / en / zh** |
| 🎛️ CMS (`/admin`) | Leads kontak, Testimoni, FAQ, Artikel Blog, Mitra, Galeri, Program, Kelas + Jadwal, Paket Harga |
| 📨 Lead management | Form kontak → tersimpan ke DB; tombol WhatsApp langsung per lead; tandai sudah dihubungi |
| 🛡️ Security | Security headers + CSP Report-Only, rate limit + honeypot + time-trap, upload `SafeImage` (MIME asli), IP allowlist admin opsional, backup harian |
| 🔍 SEO | Meta description 3 bahasa, Open Graph + Twitter Card, canonical + hreflang, JSON-LD LocalBusiness, `sitemap.xml`, `robots.txt` |
| 📊 Analytics | GA4 via `.env` + event `whatsapp_click` / `wechat_open` |
| 🧪 Kualitas | Feature test: 23 test / 73 assertions — pola **DB-first dengan fallback** menjamin halaman tidak pernah mati |

## 🏗️ Struktur

```
app/
├── Filament/Resources/        # CMS: ContactLead, Testimonial, Faq, Post,
│   │                          #      Partner, GalleryItem, Program, Course, PricingPlan
│   └── Widgets/               # Widget statistik lead dashboard
├── Http/Controllers/          # Home, Course, Contact, Page, Sitemap
├── Http/Middleware/           # Localization, SecurityHeaders, AdminIpAllowlist
├── Models/                    # 13 model (kolom i18n = JSON {id,en,zh})
├── Rules/SafeImage.php        # Validasi upload aman
└── Console/Commands/          # db:backup (SQLite, retensi 7 hari)
database/
├── migrations/                # 11 tabel (users, courses, programs, posts, ...)
└── seeders/                   # ContentSeeder + CourseContentSeeder (baca lang files)
resources/views/               # Blade: layouts, home, courses, blog, contact, sitemap
lang/{id,en,zh}/messages.php   # Fallback konten + UI strings
```

**Pola konten:** halaman publik membaca **database** (dikelola via `/admin`); jika tabel kosong → otomatis fallback ke `lang/` files. Situs tetap tampil utuh bahkan sebelum di-seed.

## ⚡ Setup (PC baru)

Prasyarat: PHP 8.3 (+ext zip, sqlite, gd, intl), Composer. Rekomendasi Windows: [Laragon](https://laragon.org).

```bash
git clone https://github.com/RhazorJavkins/IFLS_Website.git
cd IFLS_Website
composer install
cp .env.example .env          # Windows: copy
php artisan key:generate
php artisan migrate --force --seed
php artisan serve --host=127.0.0.1 --port=8080
```

- Situs: `http://127.0.0.1:8080/id`
- Admin: `http://127.0.0.1:8080/admin` — buat akun:
  ```bash
  php artisan tinker --execute="App\Models\User::updateOrCreate(['email'=>'admin@iflanguage.com'],['name'=>'Admin IFLS','password'=>'PASSWORD-KUAT-MIN-12']);"
  ```
- Produksi (VPS): ganti `.env` → `APP_ENV=production`, `APP_DEBUG=false`, `DB_CONNECTION=mysql`, `SESSION_SECURE_COOKIE=true`

## 🔧 Perintah sehari-hari

```bash
php artisan serve --host=127.0.0.1 --port=8080  # dev server
php artisan test                                 # 23 tests
php artisan db:seed --force                      # re-seed konten (idempotent)
php artisan db:backup                            # backup DB (terjadwal 23:00, retensi 7)
```

## 🔐 Catatan security

- Jangan pernah commit `.env`, database berisi leads, atau kredensial (sudah di-`.gitignore`)
- Setelah log CSP Report-Only bersih 1–2 hari → set `SECURITY_CSP_ENFORCE=true`
- Upload gambar selalu lewat rule `SafeImage` (MIME asli, ≤3 MB, tolak PHP menyamar)

## 📚 Dokumentasi lanjutan

- [`REVIEW.md`](REVIEW.md) — status fase 1–5, skor, roadmap Fase 6 (VPS + domain)
- [`HANDOVER/README.md`](HANDOVER/README.md) — arsitektur konten, setup PC lain, security yang wajib dipertahankan

---

© 2026 IF Language School · Dibangun dengan Laravel 13 + Filament 4 · 🤖 Dibantu Codebuff
