# Rollup cepat: status terakhir project IFLS Website

Diperbarui: 22 Sep 2026 (detail lengkap di `HANDOVER/README.md` + `REVIEW.md`)

## Status fase
- Fase 1–3 (landing, konten, UX) ✅ — selesai 2 Sep 2026
- Fase 4 (Backend+DB+Security) ✅ — 21 Sep 2026: Filament `/admin`, 11 tabel, security, backup, GA4 skeleton
- Fase 5 (Courses → CMS) ✅ — 21 Sep 2026: programs/features/pricing, render DB + fallback
- **Fase 7 (Analitik CMS + Portal Internal) ✅ — 22 Sep 2026**: GA4 Data API di `/admin` (halaman Analitik + chart trend, fallback aman tanpa kredensial), role `admin|teacher|translator` di `users`, panel **`/training`** (guru: kelas+scoping, absensi bulk, nilai tertimbang, murid berisiko, laporan CSV, tombol WA) & **`/translate`** (penerjemah: proyek terjemahan, **dokumen disk privat** + unduhan ter-proteksi, leads website read-only + CSV), UserResource kelola akun di admin, backup dokumen harian, **53 test hijau (149 assertions)**
- Fase 6 (VPS + MySQL + domain + mapping subdomain training./translate.) ⬜ — butuh akses VPS & domain

## Fakta penting sesi ini
- Stack: Laravel 13 + Filament 4.13.4 + spatie/laravel-analytics 5.7 + Bootstrap 5.3.3, SQLite dev
- PHP 8.3.30 Laragon + Composer di PATH; `extension=zip` aktif (wajib Filament + backup ZIP)
- **3 panel, 1 codebase**: `/admin` (IP allowlist, hanya admin) · `/training` (admin+guru, brand biru) · `/translate` (admin+penerjemah, brand teal) — resource di `app/Filament/{Resources,Training,Translate}/`, auto-discover per panel
- Akun portal (PortalUsersSeeder, password default di seeder — ganti setelah login): `guru@iflanguage.com`, `translator@iflanguage.com`; kelola via `/admin` → Sistem → Pengguna (password min 12)
- **Dokumen translate di disk PRIVAT** `storage/app/private/documents` — unduh hanya via route auth+role; JANGAN pindah ke public disk
- Guru scoping wajib di query (`getEloquentQuery`/`mount` cek `teacher_id`), bukan hanya visibility UI
- Konvensi Filament v4 yang sempat menghabiskan waktu: properti resource `navigationIcon` = `BackedEnum|string|null` (group = `UnitEnum`), `$view` pada Page = non-static `protected string`, custom record page pakai `request()->route('record')` + `getRecord()` (JANGAN override `mount($record)`), Actions namespace = `Filament\Actions\*`
- **Bonus fix**: `config('services.analytics.ga_id')` baru terdaftar di `config/services.php` (22 Sep) — script GA4 frontend sebelumnya mati diam-diam; `Authenticate::redirectUsing` kini mengarahkan tamu ke login portal masing-masing
- Kronologi resmi: **2012 IF Language Center → 2026 rebrand IF Language School**; mitra "Badan Bahasa Kemendikbudristek"; stat **10.000+ siswa / sejak 2012 / 100+ mitra**
- QR asli `public/images/qr-1..5.png` + `wechat-qr.png`; logo = SVG inline (ganti: timpa PNG → `logo:regenerate`); `vercel-preview/` USANG
- Test suite: `php artisan test` → **53 passed (149 assertions)**

## Sisa kerja
1. Gallery foto asli + testimoni asli (upload via admin — tabel siap)
2. CSP enforce (`SECURITY_CSP_ENFORCE=true` setelah log bersih)
3. **Setup GA4 Data API** (5 langkah di HANDOVER/README.md) + isi `GA_MEASUREMENT_ID`
4. Fase 6: VPS + MySQL + SSL + deploy + cron (`db:backup` 23:00 + `documents:backup` 23:05) + mapping subdomain `training.`/`translate.`
5. Ganti password default akun portal setelah login pertama
