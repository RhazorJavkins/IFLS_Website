# 📦 Panduan Melanjutkan Project IF Language School
## (dibuat khusus untuk transfer ke PC Kantor)

Paket ini dibuat pada: 18 Sep 2026.
File: `IFLS_Website-portable.tar.gz` (39 MB) — lokasi di folder home pengguna yang membuatnya.
Format: tar.gz (bukan zip). 
Pembuatan sudah dilakukan tanpa `vendor/`, `node_modules/`, dan `.git/` agar ukuran terkontrol dan nanti rebuild dari `composer.json` + `package.json` di PC tujuan.
Website IF Language School — Laravel 13.25.0, blade + Bootstrap 5.3.0-alpha1 + Font Awesome 6, multibahasa (id / en / zh).

Jika di PC kantor ingin membuka paket ini, ikuti langkah di bawah ini.

---

## 1) Ekstrak paket (di PC kantor)

A. Jika ada terminal / command line biasa:
```bash
# Pilih satu:
tar -xzf IFLS_Website-portable.tar.gz
```
Hasil: folder `IFLS_Website/` akan muncul di direktori tempat ekstraksi.

B. Jika PC kantor Windows dan tidak ada terminal:
- Ekstrak dengan WinRAR / 7-Zip / PeaZip. 
- Pastikan nama folder hasil ekstrak `IFLS_Website`.
- Setelah diekstrak, lanjut ke bagian "Setup di PC Kantor".

---

## 2) Setup di PC Kantor

### A. Cek versi lingkungan
Sebelum install, lebih baik cek apakah lingkungan mendekati versi yang dipakai saat pembuatan paket:
- PHP 8.3.x (saat pembuatan: 8.3.33)
- Composer 2.10.x+
- Node 22.x (saat pembuatan: 22.23.2)
- npm sesuai node

Jika PC kantor versi lain, kemungkinan besar tetap bisa jalan, tetapi jika ada masalah, ini urutan yang perlu dicek.

### B. Install dependency
Masuk ke folder `IFLS_Website/`:
```bash
cd IFLS_Website
composer install
```
Jika butuh asset development / rebuild:
```bash
npm install
```

Catatan: vendor/ dan node_modules/ sengaja tidak disertakan dalam paket. Itulah mengapa `composer install` dan (jika perlu) `npm install` perlu dijalankan di PC tujuan.

### C. Siapkan database (SQLite)
Saat ini project menggunakan SQLite. File `database/database.sqlite` sudah disertakan, jadi kalau ingin melanjutkan dengan data yang ada, cukup pastikan file itu ada dan `.env` mengarah ke SQLite.

Cek `.env` di folder `IFLS_Website/`. Pastikan bagian DB mirip:
```
DB_CONNECTION=sqlite
# path kosong berarti Laravel pakai database/database.sqlite
```
Jika ingin database kosong (start baru), buat file kosong:
```bash
touch database/database.sqlite
```
Atau hapus isi sqlite sekarang dan biarkan kosong.

Jika nanti PC kantor ingin pakai MySQL/Postgres, sesuaikan `.env` sesuai DB yang tersedia.

### D. Build assets (jika ingin preview langsung tanpa Vite dev)
Saat ini `public/build/...` sudah ada, tapi kalau ingin rebuild:
```bash
npm run build
```
Untuk development assets (hot-reload) gunakan:
```bash
npm run dev
```

### E. Jalankan server lokal untuk preview
```bash
php artisan serve --port=8080
```
Atau PHP built-in server (kalau tidak ingin pakai artisan):
```bash
php -S 0.0.0.0:8080 -t public
```
Lalu buka di browser:
- Beranda: `http://localhost:8080/id`
- Kursus: `http://localhost:8080/id/courses`
- Kontak: `http://localhost:8080/id/contact`

Untuk bahasa lain, ganti `/id/` dengan `/en/` atau `/zh/`.

### F. Migrasi (jika ada perubahan migrasi)
Jika di PC kantor ada perubahan `database/migrations/` yang belum pernah dijalankan, jalankan:
```bash
php artisan migrate
```
Saat ini belum ada migrasi yang perlu dijalankan secara manual; tetap bisa dicek jika ada perubahan.

---

## 3) Struktur yang sudah ada (untuk referensi cepat)

Beberapa hal yang sudah dikerjakan pada sesi ini (berdasarkan catatan handover):

1. Beranda one-page scroll (`resources/views/home.blade.php`)
   - Hero, stat strip, program unggulan, mengapa kami, testimoni, CTA akhir.
   - Semua multibahasa via lang files.

2. Halaman kursus one-page + sticky sidebar (`resources/views/courses/index.blade.php`)
   - Overview, Indonesia untuk WNA, Mandarin, English, dengan tab/stepper sesuai program.
   - ScrollSpy aktif, smooth scroll.

3. Kontak (`resources/views/contact.blade.php`)
   - 5 placeholder QR (bisa diganti gambar asli nanti), lokasi 3 cabang + learning sites Jakarta, Google Maps embed, form kontak.
   - WhatsApp: +62 811-8887-568.

4. Lang files (`lang/id/messages.php`, `lang/en/messages.php`, `lang/zh/messages.php`)
   - Sudah memiliki banyak key untuk halaman home, courses, contact.

5. Lokasi yang digunakan di kontak:
   - Head Office: Rukan Cordoba Blok G No. 21-22, Bukit Golf Mediterania, PIK, Jakarta Utara
   - Jakarta Learning Sites: PIK 1, Golf Island, Central Park 2, Bellagio, Serpong
   - Surabaya Branch: Plaza Ruko Graha Family, Blok C 42 Pradahkalikendal
   - Semarang Branch: Jl. Batan Selatan, Miroto, Semarang Tengah
   - Map: VPQW+63 Kamal Muara, PIK; link: https://maps.app.goo.gl/PqB2Au16fx1MPTK6A

---

## 4) Checklist transfer ke PC kantor

- [ ] Paket diekstrak ke folder `IFLS_Website/`
- [ ] `.env` ada dan konfigurasi DB sesuai target (SQLite atau DB lain)
- [ ] `database/database.sqlite` ada jika ingin melanjutkan dengan data yang ada
- [ ] `composer install` berhasil
- [ ] `npm install` berhasil jika butuh asset
- [ ] `public/build/` ada atau `npm run build` sudah dijalankan
- [ ] Logo, favicon, dan file statis tersedia di `public/` agar preview tidak kosong (misalnya `public/logo.png`)
- [ ] Server bisa dijalankan dan halaman utama muncul

---

## 5) Hal yang masih perlu diselesaikan nanti

1. QR placeholder kontak perlu diganti dengan gambar asli di `public/qrcodes/qr1..5.png` (panggil via `asset('qrcodes/qr'.$i.'.png')`).
2. Ganti angka placeholder di beranda (alumni 20.000+, tahun 2019, mitra 50+).
3. Ganti testimoni fiktif dengan testimoni siswa asli.
4. Review halaman selanjutnya: blog, gallery, about, services (masih placeholder).
5. Jika ingin go-live: domain, SSL, storage permission, optimasi server.
6. Jika ingin deploy statis ke GitHub Pages/Vercel, pertimbangkan export halaman statis atau pendekatan lain karena ini Laravel.

---

## 6) Jika ada masalah di PC kantor

Biasanya masalah yang paling sering:
- `composer install` gagal → periksa PHP versi dan memastikan Composer versi memadai
- Assets tidak muncul → cek `public/build/` ada atau jalankan `npm run build`
- Halaman blank / error → cek log `storage/logs/laravel.log`
- Database tidak terbaca → cek `.env` dan keberadaan `database/database.sqlite`
- Logo/gambar hilang → pastikan file statis ada di `public/`

---

## 7) Catatan tambahan

- Paket ini dibuat dengan `tar -czf` (bukan zip), jadi ekstrak pakai `tar -xzf`.
- Ukuran awal ~39 MB tanpa vendor/node_modules/.git.
- Folder `vercel-preview/` dan `public/upload/` sudah ada; tidak dijamin relevan dengan pekerjaan sesi ini, tapi disertakan.
- File `README.md` dan `HANDOVER/` juga disertakan sebagai referensi.

---

Dibuat untuk: lanjutan pekerjaan IF Language School website di PC kantor.
Tanggal: 18 Sep 2026.
