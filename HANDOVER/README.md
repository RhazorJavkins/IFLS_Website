# Handover Sesi IF Language School Website
**Diperbarui:** 21 Sep 2026 (Fase 4 & 5 selesai)
**Proyek:** root ini — **Laravel 13** + **Filament 4.13.4** + Blade + **Bootstrap 5.3.3** + **Font Awesome 6.7.2**, 3 bahasa (id / en / zh)
**Dev server:** `php artisan serve --host=127.0.0.1 --port=8080`
**Dev URL:** `http://127.0.0.1:8080/id` · **Admin:** `http://127.0.0.1:8080/admin`

---

## Misi singkat
Website IF Language School — lembaga bahasa Indonesia⇄China. Kronologi resmi: **didirikan 2012 sebagai IF Language Center → 2026 rebrand menjadi IF Language School**. Mitra: **Badan Bahasa Kemendikbudristek**. Halaman: home, about, courses (full CMS), services (terjemahan), blog (DB + detail), gallery, contact (form simpan lead ke DB), 404 custom. Semua konten i18n via `lang/{id,en,zh}/messages.php` + tabel database JSON `{id,en,zh}`.

---

## ⚡ Setup di PC BARU (5 menit)
1. Install **Laragon** (bundel PHP 8.3 + Composer) — atau PHP 8.3 + Composer manual
2. Tambahkan ke PATH user: `C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64` dan `C:\laragon\bin\composer` (aktifkan juga `extension=zip` di php.ini — syarat Filament)
3. Dari root project:
   ```bash
   composer install
   copy .env.example .env          # Windows (di bash: cp)
   php artisan key:generate
   php artisan migrate --force --seed
   php artisan serve --host=127.0.0.1 --port=8080
   ```
4. Buka `http://127.0.0.1:8080/id` — selesai. Database SQLite otomatis terisi konten identik dengan situs (seeder idempotent, boleh diulang).
5. Login admin: email `admin@iflanguage.com`. Password tidak disimpan di repo — cek `admin-credentials.txt` di PC kantor (⚠️ file plaintext: pindahkan ke password manager lalu hapus), atau buat baru:
   ```bash
   php artisan tinker --execute="App\Models\User::updateOrCreate(['email'=>'admin@iflanguage.com'],['name'=>'Admin IFLS','password'=>'PASSWORD-KUAT-MIN-12-KARAKTER']);"
   ```

---

## Status fase (detail skor di `REVIEW.md`)
| Fase | Isi | Status |
|---|---|---|
| 1–3 | Landing page, konten asli (logo, QR, foto tim), UX polish | ✅ 2 Sep 2026 |
| 4 | Backend + DB + Security: Filament `/admin`, 11 tabel, sitemap, headers, anti-spam, backup, GA4, detail blog | ✅ 21 Sep 2026 |
| 5 | Courses → full CMS: `programs`/`program_features`/`pricing_plans` + Kelas & Jadwal di admin | ✅ 21 Sep 2026 |
| 6 | VPS + MySQL + domain + SSL (produksi beneran) | ⬜ butuh akses VPS & domain |

⚠️ Static export `vercel-preview/` **USANG** — tidak memuat admin/form/DB. Jangan jadi rujukan konten.

---

## Arsitektur konten (Fase 4–5) — PENTING untuk edit selanjutnya
**Pola DB-first + fallback:** halaman publik membaca database; bila tabel kosong, otomatis fallback ke `lang/{locale}/messages.php`. Situs tidak pernah mati. Artinya:
- Edit konten harian → **lewati `/admin`** (jangan edit lang file lagi, kecuali mengubah fallback)
- Teks di lang file hanya jadi cadangan; seeder membaca lang file → DB (jadi jangan mengubah lang file setelah DB terisi, akan tidak sinkron)

| Konten | Dikelola di | Tabel | Fallback |
|---|---|---|---|
| Testimoni & FAQ home | `/admin` → Testimoni / FAQ | `testimonials`, `faqs` | `testimonial*`, `faq_items` |
| Blog | `/admin` → Artikel Blog | `posts` (slug, cover, publish) | `blog_post1..3` |
| Halaman Courses | `/admin` → Kursus: Program / Kelas / Paket Harga | `programs`, `program_features`, `pricing_plans`, `courses`, `schedules` | hardcode di `courses/index.blade.php` |
| Lead form kontak | `/admin` → Leads Kontak | `contact_leads` (+`contacted_at`) | — |

- **Anchor courses = slug program** (`courses#mandarin` dari beranda) — jangan ganti slug program yang sudah publish
- **Harga kelas null** = tampil "Hubungi untuk harga" (kebijakan resmi)
- **Nomor WA** terpusat di `.env` → `WHATSAPP_NUMBER` (0 hardcode di views courses)
- Detail blog: `/{locale}/blog/{slug}` — meta description otomatis dari excerpt

---

## Security yang harus dipertahankan (jangan dihapus saat refactor)
- `SecurityHeaders` middleware (bootstrap/app.php) — headers + CSP **Report-Only**; setelah log bersih, set `SECURITY_CSP_ENFORCE=true`
- Form kontak: `throttle:5,1` + honeypot field `website` + time-trap sesi `contact_form_opened_at` (min. 3 detik)
- Upload gambar: rule `App\Rules\SafeImage` (MIME asli, ≤3MB, tolak `<?php`) — selalu pakai untuk upload baru
- `/admin`: auth Filament + opsional `ADMIN_IP_ALLOWLIST` di `.env`
- `php artisan test` → **23 passed** — jalankan setelah perubahan besar

---

## Perintah sehari-hari
```bash
php artisan serve --host=127.0.0.1 --port=8080  # dev server
php artisan test                                 # 23 tests (73 assertions)
php artisan db:seed --force                      # re-seed konten (idempotent)
php artisan db:backup                            # backup SQLite (otomatis 23:00, retensi 7)
php artisan schedule:list                        # cek cron backup
```

## Sisa pekerjaan (belum)
1. **Gallery foto asli** — upload 6–12 foto ke `/admin` → Galeri (tabel `gallery_items` sudah siap) atau `storage/app/public/gallery/`
2. **Testimoni asli** — ganti 3 placeholder via `/admin` → Testimoni
3. **CSP enforce** setelah 1–2 hari pantau log
4. **Fase 6**: VPS Ubuntu + Nginx + PHP 8.3 + MySQL, domain (`iflanguage.com`/`ifls.id`), SSL, `.env` produksi (`APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`, `DB_CONNECTION=mysql`), cron backup
5. GA4: isi `GA_MEASUREMENT_ID` di `.env` saat akun analytics siap

## Rujukan brand (tetap)
Navy `#1A2A4F` + merah IF `#B01C1C` + kuning CTA `#FFD166`; hijau `#1B4332` untuk English. Card `border-0 shadow-sm rounded-4`. Icon Font Awesome 6.7.2 (CDN). Kronologi resmi 2012→2026, mitra "Badan Bahasa Kemendikbudristek".
