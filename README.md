 # Project: Gallery Art Lelang (UAS - Galeri Seni Digital)

**Mata Kuliah:** Pemrograman Berbasis Web

**Dosen Pengampu:** Adam Husain, ST., M.Kom.

**Waktu Pengumpulan:** 30 Januari 2026

---

## Identitas Kelompok (Kelompok 4)

- Julia
- Fajar
- Caryksha
- Fito
- Kiara
- Aal Maulana
- Ilham

---

## Deskripsi Singkat
Proyek ini adalah Sistem Informasi Galeri Seni Digital & Manajemen Pameran yang dibangun menggunakan Laravel (tema kelompok: Seni Rupa & Desain Kreatif). Sistem menyediakan:

- Halaman Publik: menampilkan katalog karya seni, profil seniman, jadwal pameran, halaman lelang, artikel, koleksi museum, dan buku tamu.
- Halaman Admin: panel CRUD untuk mengelola karya seni, seniman, pameran, lelang, artikel, komentar, dan koleksi museum.
- Autentikasi dan Role-Based Access Control (Spatie Laravel Permission) dengan role `super-admin`, `staff-admin`, dan `public`.

---

## Modul (Opsi individual yang bisa dibagi ke anggota)

1. Katalog Karya Seni (Artwork Database) — Frontend: Virtual Gallery / Backend: CRUD Artwork
2. Profil Seniman & Kurator — Frontend: Artist Bio / Backend: CRUD Artist
3. Jadwal Pameran / Exhibition — Frontend: Calendar / Backend: CRUD Exhibition
4. Manajemen Lelang Karya — Frontend: Bidding Simulation / Backend: CRUD Auction
5. Artikel Kritik & Ulasan Seni — Frontend: Blog / Backend: CRUD Article
6. Buku Tamu & Komentar — Frontend: Wall of Comment / Backend: CRUD Comment
7. Koleksi Museum / Arsip — Frontend: Museum Online / Backend: CRUD Collection

> Catatan: Silakan susun pembagian tugas internal kelompok sesuai kesepakatan.

---

## Akun Dummy (seeders)
- Super Admin: `admin@gallery.com` / `password123`
- Staff Admin: `staff@gallery.com` / `password123`
- Public/User: `user@example.com` / `password123`

Seeder yang membuat role & sample user:
`database/seeders/RolePermissionSeeder.php`

Seeder sample data:
`database/seeders/SampleDataSeeder.php`

---

## Persyaratan & Teknologi

- Framework: Laravel 10.x
- Package hak akses: `spatie/laravel-permission`
- Database: MySQL / MariaDB
- Frontend: Bootstrap 5 (publik) + AdminLTE (admin)
- Storage: upload file ke disk `public` (disimpan di `storage/app/public`), symlink `public/storage`

---

## Instalasi & Jalankan (lokal)

1. Clone repository

```bash
git clone <repo-url>
cd gallery_art_lelang
```

2. Install dependency PHP

```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. Konfigurasi database

- Edit file `.env` dan isi `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai MySQL Anda.

4. Migrasi & Seed data

```bash
php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=SampleDataSeeder
```

5. Buat symlink storage (jika belum)

```bash
php artisan storage:link
```

6. Install frontend assets & build

```bash
npm install
npm run build
```

7. Jalankan server lokal

```bash
php artisan serve
```

Kunjungi: `http://127.0.0.1:8000`

---

## Periksa Hak Akses (RBAC)

- Seeder `RolePermissionSeeder` membuat permission seperti `manage artworks`, `manage artists`, `manage exhibitions`, `manage auctions`, `manage articles`, `manage comments`, `manage collections`, dan role `super-admin`, `staff-admin`, `public`.
- Di `routes/web.php` dan sidebar admin, akses modul dibatasi menggunakan middleware `permission:manage ...` dan Blade `@can(...)` sehingga staff hanya melihat menu yang sesuai permission.

Jika Anda ingin menyesuaikan permission staff, edit `database/seeders/RolePermissionSeeder.php` lalu jalankan ulang seeder (atau update role via Tinker).

---

## Checklist Pengumpulan

- [ ] README terisi lengkap (identitas + cara instalasi + akun dummy)
- [ ] Semua migrasi berjalan tanpa error
- [ ] Seeder role & sample data berjalan
- [ ] Storage symlink dibuat dan file image dapat diakses via `asset('storage/...')`
- [ ] Role-based access diuji (login sebagai admin, staff, public)
- [ ] Dokumentasi modul & pembagian tugas kolektif

---

## Catatan Pengembang / Tips

- Pastikan file default/fallback image yang dipakai seeder (`artworks/default.jpg`, `collections/default.jpg`) tersedia di `storage/app/public` atau ganti path di seeder.
- Untuk menambahkan akun anggota kelompok, tambahkan seeder atau gunakan form register (jika diizinkan) lalu assign role.
- Jika butuh bantuan menyiapkan README final dengan NIM/nomor grup, beri detail anggota dan saya akan memperbarui.

---

Jika mau, saya bisa:
- Perbarui README dengan pembagian modul per anggota (berikan mapping), atau
- Tambahkan file placeholder gambar di `public/images` dan perbarui seeder untuk menggunakan file tersebut.

Selamat mengerjakan UAS — beri tahu saya langkah selanjutnya yang Anda ingin saya kerjakan.
