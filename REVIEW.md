# Review & Next Steps — IFLS Website

> Last updated: 2026-09-22
> Dev lokal: http://127.0.0.1:8080/id (Laravel 13 + Filament 4.13) — lihat `HANDOVER/README.md` untuk setup PC lain
> ⚠️ Static export Vercel (https://vercel-preview-theta-ten.vercel.app/id) SUDAH USANG — tidak memuat CMS/admin/form-lead; produksi idealnya pindah ke VPS (lihat Fase 6)

---

## 1. Design UI Review

### ✅ Sudah Bagus
- [x] Hero section — gradient kuning → oranye, badge "Mitra Kemendikbud", CTA jelas
- [x] Navbar premium — navy `#1A2A4F` + blur, sticky-top, active link kuning `#FFD166`
- [x] Card kursus — warna solid (merah/navy/hijau), bukan gradient, mudah dibaca
- [x] Slider universitas — scroll-snap horizontal, 6 kampus
- [x] Footer — dark bg, 3 kolom, link WhatsApp & WeChat
- [x] Konsistensi warna — navy + merah + kuning konsisten di semua halaman
- [x] Tipografi — font terang di background gelap, kontras baik

### ✅ Selesai di Fase 1 & 2 (sinkron)
- [x] **Logo placeholder → DONE** ganti logo asli `public/logo.png` (dari `IF Language School Logo-04.png` 57KB) di navbar & footer
- [x] **QR WeChat placeholder → DONE** ganti QR asli `public/images/wechat-qr.png` (dari `QR Boss.png` 374KB) di modal global + courses
- [x] **Foto tim placeholder → DONE** ganti foto asli Yiyan, Amber, Xiao Yu, Novi, Elissa, Rina, Susanty di `public/images/team/` (about)

### ⚠️ Sisa Belum
- [x] **Partner logo placeholder → DITAHAN** user pilih biarkan placeholder inisial warna dulu (tidak butuh file asli sekarang)
- [x] **Hero tanpa gambar → DONE (abu-abu)** placeholder abu-abu `bg-[#d1d5db]` + dashed border di `home.blade.php` (hero kanan, desktop only, ganti foto asli nanti)
- [x] **Hover animasi → DONE** CSS `transform translateY(-6px) + shadow` di card + `btn:hover translateY(-1px) shadow` di `home.blade.php` — verifikasi live OK
- [x] **Mobile responsive → DONE** verifikasi: grid `col-md-6 col-lg-3` (4→2→1 kolom), hero stack `col-lg-6`, slider gap responsive, `@media max-width:576px` padding + font adjust — curl 200 OK

**Skor: 9/10 — semua Design UI DONE (partner placeholder disetujui, hero abu-abu, hover + mobile OK)**

---

## 2. Flow Fitur Review

### ✅ Sudah Bagus
- [x] Navigasi antar halaman — Beranda → Tentang → Kursus → Terjemahan → Galeri → Kontak
- [x] Pergantian bahasa — dropdown ID/EN/ZH, semua 18 halaman punya versi 3 bahasa
- [x] WeChat modal — klik tombol → modal popup dengan QR + "Scan untuk Hubungi"
- [x] WhatsApp link — langsung ke `wa.me/628118887568`
- [x] CTA konsisten — setiap halaman ada tombol "Daftar Sekarang" / "Hubungi Kami"
- [x] Footer global — WeChat modal + WhatsApp ada di semua halaman

### ⚠️ Sisa Belum (Fase 3 — UX Polish)
- [x] **Tombol Back to Top → DONE** floating `↑` di `layouts/app.blade.php` (#backToTop, muncul >300px, smooth scroll)
- [x] **Breadcrumb → DONE** `Beranda › Tentang/Kursus/...` di `layouts/app.blade.php` (hidden di home, auto dari URL segments)
- [x] **Loading state → DONE** skeleton CSS `img.loading-skeleton shimmer` + `background #e9ecef` di `layouts/app.blade.php`
- [x] **Slider indikator → DONE** dot 3 titik di uni slider `home.blade.php` (.uni-dots)
- [x] **Sticky CTA mobile → DONE** bottom bar `WhatsApp | WeChat | Kontak` fixed `d-md-none` di `layouts/app.blade.php` + `body padding-bottom 64px`
- [x] **Footer sitemap lengkap → DONE** home/about/courses/services/gallery/contact semua ada di footer
- [x] **404 page custom → DONE** `resources/views/errors/404.blade.php` (tombol Home/Contact/WA)
- [x] **Form kontak feedback → DONE** static arah ke WhatsApp `wa.me/628118887568` (tidak butuh form DB)
- [x] **Language switch consistency → DONE** dropdown `ID/EN/ZH` keep path `pathWithoutLocale` sudah benar di navbar

**Skor: 9/10 — semua Flow DONE (Fase 3 selesai, verifikasi curl OK)**

---

## 3. Konten Review

### ✅ Sudah Bagus
- [x] Stats konsisten — "10,000+ Siswa Sudah Belajar" / "Sejak 2012" / "100+ Mitra Korporat" di home & about
- [x] Visi/Misi per locale — ID → bahasa Indonesia, EN → English, ZH → 中文
- [x] Direksi i18n — 易衍 YI YAN & 刘裕洁 Amber, nama Mandarin + alfabet + jabatan sesuai locale
- [x] Tim 5 orang — Xiao Yu, Novi, Elissa, Susanty, Rina, nama 1x muncul
- [x] Universitas 6 — UI, Unpad, UAI, UBM, UGM, UC — muncul di home & about
- [x] 4 layanan terjemahan — Dokumen, Tersumpah, Video, Interpreter
- [x] Courses CTA — "Hubungi kami langsung via WeChat / WhatsApp" sudah i18n 3 bahasa
- [x] Hardcode bersih — tidak ada teks Indonesia tersisa di EN/ZH

### ✅ Selesai di Fase 1 & 2 (sinkron)
- [x] **Harga kursus → DONE** section "Hubungi untuk harga" (Group/Private/Business) + CTA WA di `courses/index.blade.php` + keys `pricing_*` 3 bahasa
- [x] **FAQ accordion → DONE** 6 Q/A (lama belajar, kelas online, sertifikat, cara daftar, corporate, harga) di `home.blade.php` + `faq_*` 3 bahasa
- [x] **Alamat kampus lengkap → DONE** sudah ada di `contact.blade.php` (Jakarta/Semarang/Surabaya)
- [x] **Jam operasional → DONE** Senin–Jumat 08.30–17.30 WIB (`hours_value` ID/EN/ZH) di `layouts/app.blade.php`
- [x] **Social media links → DONE** placeholder IG/FB/TikTok/Xiaohongshu/WeChat di footer+topbar+contact (menunggu URL asli)
- [x] **Foto testimoni → DONE** avatar inisial warna di `home.blade.php` (foto asli belum ada — placeholder disetujui)
- [x] **Testimoni detail → DONE** perbaikan testimoni Wang Li ID/EN (sebelumnya masih Mandarin)

### ⚠️ Sisa Belum
- [ ] **Gallery foto asli** → butuh 6-12 foto asli kelas/acara/sertifikat `public/images/gallery/*.jpg` untuk ganti logo placeholder di `gallery.blade.php`

### Konsistensi Antar Halaman

| Item | Home | About | Courses | Services | Gallery | Contact |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| Stats 10,000+ | ✅ | ✅ | — | — | — | — |
| Stats 2012 | ✅ | ✅ | — | — | — | — |
| Stats 100+ | ✅ | ✅ | — | — | — | — |
| Visi/Misi | — | ✅ | — | — | — | — |
| Direksi | — | ✅ | — | — | — | — |
| Tim | ✅ | ✅ | — | — | — | — |
| Universitas | ✅ | ✅ | — | — | — | — |
| Layanan 4 | ✅ | — | — | ✅ | — | — |
| Partner 12+ | ✅ | — | — | — | ✅ | — |
| WeChat CTA | — | — | ✅ | — | — | — |
| WhatsApp link | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| 3 bahasa | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

**Skor: 8/10 → 9/10 setelah gallery foto asli**

---

## 4. Next Steps

### Fase 1 — Quick Wins (30 menit, SEBELUM PRESENTASI) ✅ SELESAI
- [x] Logo asli → replace di navbar & footer (`public/logo.png` dari `IF Language School Logo-04.png`)
- [x] QR WeChat asli → replace di modal global & courses (`public/images/wechat-qr.png` dari `QR Boss.png`)
- [x] QR Admin 1-5 → halaman contact (`public/images/qr-1.png` sampai `qr-5.png`)
- [x] Alamat kampus lengkap → sudah ada di halaman contact (existing)
- [x] Jam operasional → **Senin–Jumat 08.30–17.30 WIB** (update di 3 bahasa)
- [x] Social media links → footer (IG, FB, TikTok, Xiaohongshu) + topbar (IG, TikTok)
- [x] Deploy ulang ke Vercel → **https://vercel-preview-theta-ten.vercel.app/id** (PROD)

### Fase 2 — Content Enrichment (1-2 jam, SETELAH PRESENTASI) ✅ SELESAI
- [x] **Foto tim asli** → Yiyan, Amber, Xiao Yu, Novi, Elissa, Rina (dari file upload)
- [x] **Foto direksi asli** → Yi Yan & Amber (di halaman about)
- [x] **Testimoni panjang** → perbaikan testimoni Wang Li (ID/EN sebelumnya masih Mandarin) + avatar inisial
- [x] **FAQ accordion** → 6 pertanyaan (lama belajar, kelas online, sertifikat, cara daftar, corporate, harga) di 3 bahasa
- [x] **Harga kursus** → "Hubungi untuk harga" (Kelas Reguler, Private, Corporate Training) + CTA WhatsApp
- [x] **Partner logo** → placeholder inisial warna (belum ada file logo asli — disetujui user)

### Fase 3 — UX Polish (1 jam) ✅ SELESAI
- [x] Back to top button — `#backToTop` floating ↑ + JS scroll >300px + smooth `scrollTo`
- [x] Breadcrumb — `Beranda › ...` auto segments di `layouts/app.blade.php`
- [x] Sticky CTA mobile — bottom bar `WA | WeChat | Kontak` fixed `d-md-none` + `body padding-bottom`
- [x] Loading state / skeleton — CSS `skeletonShimmer` via opt-in class `.loading-skeleton` (rule global `img{background:#e9ecef}` **dihapus 21 Sep** — area transparan PNG menampilkan background elemen sehingga logo putih tampak kotak; lihat commit cc19cd0)
- [x] Slider indikator — dot 3 titik `.uni-dots` di `home.blade.php`
- [x] Footer sitemap — home/about/courses/services/gallery/contact lengkap
- [x] 404 custom — `resources/views/errors/404.blade.php`
- [x] Form kontak → WA + language switch consistency — cek OK

### Fase 4 — Backend, Database & Security ✅ SELESAI (21 Sep 2026)
- [x] **CMS Filament v4.13.4** di `/admin` — Leads Kontak (filter status/bahasa, tombol WA per lead, tandai dihubungi), Testimoni, FAQ, Artikel Blog, Mitra, Galeri (semua form i18n 3 bahasa)
- [x] **Database** (SQLite `database/database.sqlite`): `contact_leads`(+`contacted_at`), `testimonials`, `faqs`, `partners`, `gallery_items`, `posts`, `site_settings`
- [x] **Halaman publik DB-first + fallback lang file** — testimoni/FAQ home, blog list + **detail blog baru** `/{locale}/blog/{slug}` (meta dinamis) — situs tidak pernah mati walau DB kosong
- [x] **SEO teknis**: `sitemap.xml` (13 URL × hreflang id/en/zh/x-default), `robots.txt` dinamis
- [x] **Security**: security headers (nosniff/SAMEORIGIN/referrer/permissions), CSP Report-Only (enforce via `SECURITY_CSP_ENFORCE=true` setelah log bersih), rate limit form 5/menit + honeypot + time-trap, rule `SafeImage` (MIME asli, ≤3MB, tolak PHP menyamar), IP allowlist admin opsional, SQLite pragmas (FK/busy_timeout/WAL), backup harian `db:backup` (retensi 7)
- [x] **Form kontak simpan lead ke DB** (fallback otomatis ke WhatsApp bila DB gagal)
- [x] **Analytics**: kerangka GA4 via `.env` (`GA_MEASUREMENT_ID`) + event `whatsapp_click`/`wechat_open`
- [x] Upgrade Bootstrap 5.3.0-alpha1 → **5.3.3**, Font Awesome beta → **6.7.2**
- [x] `.env.example` + `WHATSAPP_NUMBER` terpusat di config
- [x] Feature test security: **`php artisan test` → 29 passed (93 assertions)**
- [ ] CSP enforce (pantau report 1–2 hari)
- [ ] VPS Hosting + MySQL + domain custom (`iflanguage.com`/`ifls.id`) — **Fase 6, butuh akses VPS & domain**

### Fase 5 — Restrukturisasi Courses → Full CMS ✅ SELESAI (21 Sep 2026)
- [x] Tabel baru: `programs` (slug=anchor, badge/emoji/warna/gaya render i18n), `program_features` (level/tier/format/service_type/highlight), `pricing_plans`; `courses` + `program_id`, `price` **nullable**, `sort`
- [x] CMS baru grup "Kursus": **Program** (+RelationManager Fitur), **Kelas** (+RelationManager Jadwal), **Paket Harga**
- [x] `courses/index.blade.php` dirender dari DB (loop per program → tabs/stepper/cards otomatis); **fallback ke lang file** bila DB kosong
- [x] Anchor = slug: `courses#bahasa-indonesia/#mandarin/#english` dari beranda tetap valid
- [x] Harga null → tampil "Hubungi untuk harga" (key `contact_for_price`, 3 bahasa); semua harga demo dihapus
- [x] Nomor WA terpusat: 0 hardcode `628118887568` di courses — semua via `config('services.whatsapp.number')`
- [x] `CourseContentSeeder` membaca lang files (teks 100% identik) + test `CoursesCmsTest` (render DB, fallback, harga null, anchor, admin)
- [x] Menambah program baru (mis. Bahasa Jepang) kini cukup dari `/admin` — tanpa kode

### Fase 5.5 — Revisi Tampilan & Logo SVG ✅ SELESAI (21 Sep 2026)
- [x] Logo navbar/footer: PNG (padding transparan 37%) di-crop ulang → **divektorisasi ke SVG inline** (commit 0887017)
- [x] Card hero beranda & card services: teks hardcode Indonesia → **17 lang keys baru** (ikut terjemahan EN/ZH)
- [x] Tim profesional: foto bulat 64px → **kotak rounded 128px** (direksi 200px) + masuk CMS (tabel `team_members`, resource `/admin` → Konten → Tim, upload foto SafeImage + i18n jabatan/bio; fallback config; test `TeamCmsTest`)

**Arsitektur logo SVG (jangan kembalikan ke `<img>` PNG):**
- Sumber: `public/logo.png` & `public/logo-square.png` (putih + alpha, glyph penuh tanpa padding)
- Output: `public/logo.svg` + `public/logo-square.svg` (path `fill=currentColor`, `fill-rule=evenodd`) — untuk OG/JSON-LD
- Dipakai di view via partial self-contained: `resources/views/layouts/_logo-long.blade.php` (navbar) & `_logo-square.blade.php` (footer) — inline SVG `fill="currentColor"`, warna otomatis ikut konteks (putih di navbar gelap), mustahil kena bug rule `img{background}` lagi
- **Regenerasi** (setelah ganti PNG sumber): `php artisan logo:regenerate` — pipeline marching-squares + RDP (eps 1.0 @400px) + tulis ulang SVG & partial; output deterministik (fidelity terverifikasi IoU 0.93/0.89). Lalu `view:clear` bila perlu, commit hasilnya
- Larangan: JANGAN tambah rule global `img{background:...}` / JANGAN render logo sebagai `<img>` di atas latar gelap

### Fase 7 — Analitik CMS + Portal Guru & Translate ✅ SELESAI (22 Sep 2026)
- [x] **Analitik GA4 di `/admin`**: `spatie/laravel-analytics` v5.7 (GA4 Data API), service wrapper aman `AnalyticsService` (null bila tak terkonfigurasi), widget chart trend 7/14/30 hari, halaman **Laporan → Analitik** (kartu pengunjung/pageviews/hal-per-kunjungan + 15 halaman terpopuler) — respons API cache 24 jam; tanpa kredensial tampil petunjuk setup, TIDAK error
- [x] Kredensial: `ANALYTICS_PROPERTY_ID` (.env) + JSON service account di `storage/app/analytics/` (di-gitignore); **bonus fix**: `config('services.analytics.ga_id')` sebelumnya tidak terdaftar di `config/services.php` → script GA4 frontend selama ini mati — kini aktif
- [x] **Role pengguna**: kolom `users.role` (`admin|teacher|translator`) + matriks panel — `/admin` hanya admin, `/training` admin+guru, `/translate` admin+penerjemah; middleware `EnsureRole` (403 + logout paksa agar session bersih); admin melihat/mengelola akun di `/admin` → Sistem → Pengguna
- [x] **Panel Guru `/training`** (brand biru): dashboard ringkasan mengajar (kelas aktif, murid, absensi 7 hari, murid berisiko), Kelas Saya (scoping: guru hanya kelas miliknya di query + 404), Murid, **absensi bulk** (satu form per pertemuan, toggle Hadir/Izin/Sakit/Alpa per murid, `wire:model.live`), **nilai tertimbang** (tabel stand-alone per kelas), **laporan** (kehadiran %, rata-rata tertimbang, murid berisiko alpa≥3/nilai<70, tombol WhatsApp per murid), export CSV absensi & nilai (UTF-8 BOM)
- [x] **Panel Translate `/translate`** (brand teal): Proyek terjemahan (klien, pasangan bahasa, layanan, deadline, status, harga), **Dokumen di disk PRIVAT** (`storage/app/private/documents` — unduhan hanya via route ter-proteksi `auth+role`, validasi MIME + maks 20MB, file terhapus saat record dihapus), **Leads Website read-only** (lihat, filter, tandai sudah dihubungi, export CSV)
- [x] Route export/unduh: `/portal/training/{class}/absensi.csv|nilai.csv`, `/portal/translate/documents/{document}/download`, `/portal/translate/leads.csv` — semua `auth + role:...`; tamu diarahkan ke login portal masing-masing (`Authenticate::redirectUsing` di AppServiceProvider)
- [x] IP allowlist TETAP hanya di `/admin` (guru/penerjemah akses dari mana saja); keamanan portal dari auth + `AuthenticateSession` + password minimal 12 karakter
- [x] Backup: `documents:backup` (ZIP harian 23:05, retensi 14) melengkapi `db:backup` (23:00)
- [x] Test: **53 passed (149 assertions)** — matrix akses 3 panel, scoping kelas guru, unique absensi, nilai tertimbang, murid berisiko, dokumen privat (200/403/redirect + MIME + hapus file), CSV access control, fallback analytics
- [ ] Setup GA4 Data API (service account + property ID) — menunggu akses Google Analytics klien
- [ ] Subdomain `training.`/`translate.` → dipetakan saat deploy VPS Fase 6 (panel path sudah siap)

**Catatan arsitektur portal (jangan dilanggar):**
- 3 panel = **satu codebase, satu deploy** — resource training di `app/Filament/Training/`, translate di `app/Filament/Translate/`, admin tetap `app/Filament/Resources/` (auto-discover per panel via `discoverResources`)
- Dokumen TIDAK boleh pindah ke disk public; unduhan harus lewat route ter-proteksi
- Guru scoping wajib lewat query (`getEloquentQuery`/`mount` cek `teacher_id`), bukan hanya visibility UI
- Halaman custom record Filament v4: JANGAN override `mount(int|string $record)` — pakai `request()->route('record')` (sudah model ter-bind) + `getRecord()`

---

## Ringkasan Skor

| Aspek | Skor | Status |
|---|---|---|
| Design UI | 9/10 | Semua DONE (hero placeholder dihapus, hover, mobile OK) |
| Flow Fitur | 9/10 | Semua DONE + detail blog & form lead |
| Konten | 9/10 | Sisa gallery foto asli + testimoni asli (menunggu aset) |
| Backend/CMS | 9/10 | Fase 4–5+7: `/admin` kelola lead, konten, program, kelas, jadwal, harga, pengguna + analitik GA4 |
| Portal Internal | 9/10 | Fase 7: `/training` (absensi, nilai, laporan) & `/translate` (proyek, dokumen privat, leads) |
| Security | 8/10 | Headers + anti-spam + upload aman + role 3 panel + dokumen privat; CSP belum enforce; produksi ke VPS |
| **Rata-rata** | **9/10** | **Situs dinamis + 3 portal internal — tinggal aset foto, setup GA4 API & migrasi VPS (Fase 6)** |

**Sisa item:** (1) gallery foto asli `public/images/gallery/`, (2) testimoni asli, (3) CSP enforce, (4) VPS + domain + MySQL. Test suite: `php artisan test` → **23 passed (73 assertions)**.

---

## Catatan Deploy

> ⚠️ **PENTING (21 Sep 2026):** `vercel-preview/` adalah static export dari era landing-page — sekarang **usang dan tidak bisa menampilkan fitur dinamis** (admin `/admin`, form lead tersimpan, CMS konten, detail blog dari DB). Jangan mengiklankan URL Vercel sebagai situs resmi sebelum migrasi.

**Jalur produksi yang benar (Fase 6):** VPS Ubuntu + Nginx + PHP 8.3 + MySQL → deploy repo ini (bukan static export) → `composer install --no-dev --optimize-autoloader`, `.env` produksi (`APP_ENV=production`, `APP_DEBUG=false`, `DB_CONNECTION=mysql`, `SESSION_SECURE_COOKIE=true`), `php artisan migrate --force --seed`, storage:link, SSL Let's Encrypt, cron backup `db:backup`, lalu arahkan domain.

```bash
# Dev lokal (PC kantor sudah ter-setup — PHP 8.3.30 Laragon sudah di PATH):
php artisan serve --host=127.0.0.1 --port=8080   # → http://127.0.0.1:8080/id
php artisan test                                  # 53 tests (termasuk matrix akses 3 panel)
php artisan db:seed --force                       # ContentSeeder + CourseContentSeeder (idempotent)
```

**Setup PC baru:** ikuti langkah lengkap di `HANDOVER/README.md` (Laragon PATH → `composer install` → copy `.env.example` → `key:generate` → `migrate --seed` → serve).
