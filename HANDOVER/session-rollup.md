# Rollup cepat: status terakhir project IFLS Website

Diperbarui: 21 Sep 2026 (detail lengkap di `HANDOVER/README.md` + `REVIEW.md`)

## Status fase
- Fase 1–3 (landing, konten, UX) ✅ — selesai 2 Sep 2026
- **Fase 4 (Backend+DB+Security) ✅ — 21 Sep 2026**: Filament 4 `/admin` (leads, testimoni, FAQ, blog, mitra, galeri), 11 tabel, sitemap+robots, security headers + CSP Report-Only, anti-spam form (rate limit+honeypot+time-trap), backup harian, GA4 skeleton, detail blog baru, 23 test hijau
- **Fase 5 (Courses → CMS) ✅ — 21 Sep 2026**: tabel `programs`/`program_features`/`pricing_plans` + alter `courses` (harga nullable); admin kelola Program+Fitur, Kelas+Jadwal, Paket Harga; halaman courses dirender dari DB dengan fallback lang; anchor=slug tetap valid; nomor WA terpusat `.env`
- Fase 6 (VPS + MySQL + domain) ⬜ — butuh akses VPS & domain

## Fakta penting sesi ini
- Stack sekarang: Laravel 13 + Filament 4.13.4 + Bootstrap 5.3.3 + FA 6.7.2, SQLite dev
- PHP 8.3.30 Laragon + Composer **sudah di PATH user**; `extension=zip` diaktifkan di php.ini (wajib Filament)
- Admin: `admin@iflanguage.com` — password ada di `admin-credentials.txt` (⚠️ plaintext, pindahkan lalu hapus)
- Kronologi resmi: **2012 IF Language Center → 2026 rebrand IF Language School**; mitra "Badan Bahasa Kemendikbudristek"
- Stat resmi: **10.000+ siswa, sejak 2012, 100+ mitra** (bukan 20.000/2019/50)
- QR asli di `public/images/qr-1..5.png` + `wechat-qr.png` (BUKAN `public/qrcodes/`)
- `vercel-preview/` static export USANG — tidak memuat admin/form/DB
- Test suite: `php artisan test` → 29 passed (93 assertions)
- Logo navbar/footer = **SVG inline** via partial `_logo-long/_logo-square` — ganti logo: timpa PNG → `php artisan logo:regenerate`; JANGAN render logo sebagai `<img>` atau pakai rule `img{background}` global (bug logo-kotak-putih, commit cc19cd0)
- Tim (7 orang) kini dari DB `team_members` via `/admin` → Konten → Tim (fallback `config/team.php`)

## Sisa kerja
1. Gallery foto asli (upload via admin — tabel siap)
2. Testimoni asli (admin — ganti 3 placeholder)
3. CSP enforce (`SECURITY_CSP_ENFORCE=true` setelah log bersih)
4. Fase 6: VPS + MySQL + domain + SSL + deploy Laravel (bukan static export)
5. Isi `GA_MEASUREMENT_ID` saat akun analytics siap
