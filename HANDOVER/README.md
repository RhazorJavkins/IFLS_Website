# Handover Sesi IF Language School Website
**Diperbarui:** 22 Sep 2026 (Fase 7 selesai — analitik CMS + portal guru & translate)
**Proyek:** root ini — **Laravel 13** + **Filament 4.13.4** + Blade + **Bootstrap 5.3.3** + **Font Awesome 6.7.2**, 3 bahasa (id / en / zh)
**Dev server:** `php artisan serve --host=127.0.0.1 --port=8080`
**Dev URL:** `http://127.0.0.1:8080/id` · **Admin:** `http://127.0.0.1:8080/admin` · **Portal Guru:** `/training` · **Portal Translate:** `/translate`

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
6. Akun portal (dibuat otomatis oleh `PortalUsersSeeder`, password default di file seeder — **ganti setelah login pertama**):
   - Guru: `guru@iflanguage.com` → login di `/training/login`
   - Penerjemah: `translator@iflanguage.com` → login di `/translate/login`
   - Buat akun baru / reset password: login admin → `/admin` → Sistem → Pengguna

---

## Status fase (detail skor di `REVIEW.md`)
| Fase | Isi | Status |
|---|---|---|
| 1–3 | Landing page, konten asli (logo, QR, foto tim), UX polish | ✅ 2 Sep 2026 |
| 4 | Backend + DB + Security: Filament `/admin`, 11 tabel, sitemap, headers, anti-spam, backup, GA4, detail blog | ✅ 21 Sep 2026 |
| 5 | Courses → full CMS: `programs`/`program_features`/`pricing_plans` + Kelas & Jadwal di admin | ✅ 21 Sep 2026 |
| 7 | Analitik GA4 di CMS + portal internal `/training` (guru: kelas, absensi, nilai, laporan) & `/translate` (penerjemah: proyek, dokumen privat, leads) + role 3 panel | ✅ 22 Sep 2026 |
| 6 | VPS + MySQL + domain + SSL (produksi beneran) + mapping subdomain `training.`/`translate.` | ⬜ butuh akses VPS & domain |

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
| Lead form kontak | `/admin` → Leads Kontak · read-only di `/translate` | `contact_leads` (+`contacted_at`) | — |
| Tim (direksi & staf) | `/admin` → Konten → Tim | `team_members` (jabatan/bio i18n, foto, flag direksi/beranda) | `config/team.php` |
| Akun internal (admin/guru/penerjemah) | `/admin` → Sistem → Pengguna | `users.role` | — |
| Kelas, absensi, nilai | `/training` (guru) | `school_classes`, `students`, `class_student`, `class_sessions`, `attendances`, `grades` | — |
| Proyek & dokumen terjemahan | `/translate` (penerjemah) | `translate_jobs`, `documents` (**disk privat!**) | — |
| Analitik website | `/admin` → Laporan → Analitik | GA4 Data API (cache 24 jam) | — |

- **Anchor courses = slug program** (`courses#mandarin` dari beranda) — jangan ganti slug program yang sudah publish
- **Harga kelas null** = tampil "Hubungi untuk harga" (kebijakan resmi)
- **Nomor WA** terpusat di `.env` → `WHATSAPP_NUMBER` (0 hardcode di views courses)
- Detail blog: `/{locale}/blog/{slug}` — meta description otomatis dari excerpt

### Logo = SVG inline (BUKAN `<img>` PNG) — PENTING
Logo navbar & footer adalah **inline SVG** (`fill="currentColor"`) yang digenerate dari PNG:
- Sumber: `public/logo.png`, `public/logo-square.png` (harus putih + alpha, tanpa padding)
- Output: `public/logo.svg`, `public/logo-square.svg` + partial `resources/views/layouts/_logo-long/_logo-square.blade.php`
- **Ganti logo** → timpa PNG sumber → jalankan `php artisan logo:regenerate` → commit hasilnya
- **JANGAN**: render logo sebagai `<img>` di latar gelap, atau menambah rule CSS global `img{background:...}` — area transparan gambar akan menampilkan background itu dan logo putih jadi kotak (bug yang pernah terjadi, commit cc19cd0). Skeleton loading hanya via opt-in class `.loading-skeleton`
- File `resources/views/welcome.blade.php` sengaja dihapus (stub Laravel dengan CSS Tailwind dark-mode tanpa rute) — jangan dibuat ulang

---

## Security yang harus dipertahankan (jangan dihapus saat refactor)
- `SecurityHeaders` middleware (bootstrap/app.php) — headers + CSP **Report-Only**; setelah log bersih, set `SECURITY_CSP_ENFORCE=true`
- Form kontak: `throttle:5,1` + honeypot field `website` + time-trap sesi `contact_form_opened_at` (min. 3 detik)
- Upload gambar: rule `App\Rules\SafeImage` (MIME asli, ≤3MB, tolak `<?php`) — selalu pakai untuk upload baru
- `/admin`: auth Filament + opsional `ADMIN_IP_ALLOWLIST` di `.env` — **IP allowlist HANYA di /admin**; portal `/training` & `/translate` tetap tanpa allowlist (guru/penerjemah akses dari mana saja)
- Matriks role (`User::canAccessPanel` + middleware `EnsureRole`): `/admin`=admin · `/training`=admin+teacher · `/translate`=admin+translator; `EnsureRole` logout paksa saat 403 agar session bersih
- **Dokumen terjemahan di disk PRIVAT** (`storage/app/private/documents`) — unduhan hanya via route `portal.translate.documents.download` (auth+role). JANGAN pindahkan ke disk public
- Password akun internal minimal 12 karakter (rule `Password::min(12)` di UserResource)
- Tamu route portal diarahkan ke login portal masing-masing via `Authenticate::redirectUsing` (AppServiceProvider)
- `php artisan test` → **53 passed (149 assertions)** — jalankan setelah perubahan besar

---

## Perintah sehari-hari
```bash
php artisan serve --host=127.0.0.1 --port=8080  # dev server
php artisan test                                 # 53 tests (149 assertions)
php artisan db:seed --force                      # re-seed konten (idempotent, termasuk tim + akun portal)
php artisan db:seed --class=TeamSeeder --force   # re-seed tim saja (dari config/team.php)
php artisan logo:regenerate                      # rebuild logo SVG + partial setelah ganti PNG
php artisan db:backup                            # backup SQLite (otomatis 23:00, retensi 7)
php artisan documents:backup                     # backup dokumen privat portal (otomatis 23:05, retensi 14)
php artisan schedule:list                        # cek cron backup
```

## Analitik GA4 di CMS (widget `/admin` → Laporan → Analitik)
Sudah siap kode-nya; tinggal aktifkan kredensial (widget aman — tanpa kredensial tampil petunjuk, tidak error):
1. Google Cloud → buat **Service Account** → aktifkan **Analytics Data API**
2. GA4 → Admin → Property Access Management → tambah service account sebagai **Viewer**
3. Unduh JSON key → simpan ke `storage/app/analytics/service-account-credentials.json` (folder sudah di-gitignore)
4. `.env` → `ANALYTICS_PROPERTY_ID=properties/123456789` (lihat GA4 Admin → Property details)
5. `php artisan config:clear` → widget terisi (cache 24 jam, `cache:clear` untuk refresh)

**Bonus fix 22 Sep:** `config('services.analytics.ga_id')` sebelumnya tidak terdaftar di `config/services.php` — script GA4 frontend selama ini MATI diam-diam. Kini aktif; isi `GA_MEASUREMENT_ID` di `.env` untuk menghidupkan pelacakan.

## Portal internal (Fase 7) — ringkas
- **`/training` (guru):** Kelas Saya (scoping query — guru hanya kelas miliknya), Murid, Pertemuan + **absensi bulk** (toggle per murid, `updateOrCreate` unik per sesi+murid), Nilai tertimbang, Laporan (kehadiran %, rata-rata tertimbang, murid berisiko alpa≥3/nilai<70, tombol WhatsApp), CSV absensi & nilai
- **`/translate` (penerjemah):** Proyek terjemahan (status masuk→dikerjakan→review→selesai), Dokumen (upload MIME tervalidasi ≤20MB, disk privat, unduh via route ter-proteksi), Leads Website (read-only + tandai dihubungi + CSV)
- **Subdomain** `training.`/`translate.` dipetakan saat Fase 6 — panel path (`/training`, `/translate`) sudah siap, tinggal Nginx map
- Konvensi penting Filament v4: halaman custom record TIDAK override `mount($record)` — pakai `request()->route('record')` + `getRecord()`; icon/group properti bertipe `BackedEnum`/`UnitEnum`

## Sisa pekerjaan (belum)
1. **Gallery foto asli** — upload 6–12 foto ke `/admin` → Galeri (tabel `gallery_items` sudah siap) atau `storage/app/public/gallery/`
2. **Testimoni asli** — ganti 3 placeholder via `/admin` → Testimoni
3. **CSP enforce** setelah 1–2 hari pantau log
4. **Fase 6**: VPS Ubuntu + Nginx + PHP 8.3 + MySQL, domain (`iflanguage.com`/`ifls.id`), SSL, `.env` produksi (`APP_DEBUG=false`, `SESSION_SECURE_COOKIE=true`, `DB_CONNECTION=mysql`), cron backup (`db:backup` + `documents:backup`), mapping subdomain training./translate.
5. **Setup GA4 Data API** (langkah 5 langkah di atas) + isi `GA_MEASUREMENT_ID`

## Rujukan brand (tetap)
Navy `#1A2A4F` + merah IF `#B01C1C` + kuning CTA `#FFD166`; hijau `#1B4332` untuk English. Card `border-0 shadow-sm rounded-4`. Icon Font Awesome 6.7.2 (CDN). Kronologi resmi 2012→2026, mitra "Badan Bahasa Kemendikbudristek".
