# Panduan Hak Akses User (RBAC)

## Perubahan Terbaru

Sistem sekarang memiliki **3 level role** dengan hak akses yang berbeda:

### 1. Super Admin
- **Hak Akses Penuh** ke seluruh sistem
- Dapat **membuat, mengedit, dan menghapus** akun Staff Admin dan Public
- Dapat mengakses semua modul:
  - ✅ Karya Seni (Artworks)
  - ✅ Seniman & Kurator (Artists)
  - ✅ Jadwal Pameran (Exhibitions)
  - ✅ Lelang Karya (Auctions)
  - ✅ Artikel & Ulasan (Articles)
  - ✅ Buku Tamu/Komentar (Comments)
  - ✅ Koleksi Museum (Collections)
  - ✅ **Manajemen User** (HANYA SUPER ADMIN)

**Credentials Default:**
- Email: `admin@gallery.com`
- Password: `password123`

---

### 2. Staff Admin
- **Hak Akses Terbatas** untuk mengelola konten
- **TIDAK DAPAT** membuat atau mengelola akun user lain
- **TIDAK DAPAT** mengakses menu Manajemen User
- Dapat mengakses modul:
  - ✅ Karya Seni (Artworks)
  - ✅ Seniman & Kurator (Artists)
  - ✅ Jadwal Pameran (Exhibitions)
  - ✅ Lelang Karya (Auctions)
  - ✅ Artikel & Ulasan (Articles)
  - ✅ Koleksi Museum (Collections)
  - ❌ Buku Tamu/Komentar (Hanya view, tidak ada permission)
  - ❌ **Manajemen User** (TIDAK ADA AKSES)

**Credentials Default:**
- Email: `staff@gallery.com`
- Password: `password123`

---

### 3. Public (User Biasa)
- **Hanya dapat** melihat konten publik
- Dapat berinteraksi dengan:
  - View galeri karya seni
  - View profil seniman
  - Berpartisipasi dalam lelang (jika sudah login)
  - Memberikan komentar
- **TIDAK DAPAT** mengakses panel admin

**Credentials Default:**
- Email: `user@example.com`
- Password: `password123`

---

## Fitur Manajemen User

### Membuat User Baru (Super Admin Only)
1. Login sebagai Super Admin
2. Buka menu **Manajemen User** di sidebar admin
3. Klik tombol **Tambah User**
4. Isi form:
   - Nama Lengkap
   - Email (akan otomatis lowercase)
   - Password & Konfirmasi Password
   - Pilih Role: **Staff Admin** atau **Public**
5. Klik **Simpan**

### Edit User (Super Admin Only)
- Tidak dapat mengedit akun Super Admin
- Dapat mengubah nama, email, password, dan role
- Password bersifat opsional saat edit (kosongkan jika tidak ingin mengubah)

### Hapus User (Super Admin Only)
- Tidak dapat menghapus akun Super Admin
- Tidak dapat menghapus akun sendiri
- Konfirmasi diperlukan sebelum menghapus

---

## Struktur Permission

### Permissions yang Tersedia:
- `manage artworks` - Kelola karya seni
- `manage artists` - Kelola seniman & kurator
- `manage exhibitions` - Kelola pameran
- `manage auctions` - Kelola lelang
- `manage articles` - Kelola artikel
- `manage comments` - Kelola komentar
- `manage collections` - Kelola koleksi museum
- **`manage users`** - **Kelola user (HANYA SUPER ADMIN)**
- `view public content` - Lihat konten publik

### Mapping Role & Permission:

**Super Admin:**
- Semua permission (ALL)

**Staff Admin:**
- manage artworks
- manage artists
- manage exhibitions
- manage auctions
- manage articles
- manage collections
- ❌ TIDAK ADA `manage users`
- ❌ TIDAK ADA `manage comments`

**Public:**
- view public content

---

## Cara Menerapkan Perubahan

### 1. Jalankan Seeder untuk Update Permission
```bash
cd gallery_art_lelang
php artisan db:seed --class=RolePermissionSeeder
```

### 2. Clear Cache (Opsional)
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### 3. Restart Server (jika menggunakan `php artisan serve`)
```bash
php artisan serve
```

---

## Testing

### Test 1: Login sebagai Super Admin
1. Login dengan email `admin@gallery.com`
2. Verifikasi menu **Manajemen User** muncul di sidebar
3. Coba buat user baru dengan role Staff Admin
4. Logout

### Test 2: Login sebagai Staff Admin
1. Login dengan email `staff@gallery.com` (atau akun staff yang baru dibuat)
2. Verifikasi menu **Manajemen User** TIDAK muncul di sidebar
3. Coba akses `http://localhost:8000/admin/users` secara manual
4. Seharusnya muncul error 403 Forbidden atau redirect
5. Verifikasi dapat mengakses modul lain (Artworks, Artists, dll)

### Test 3: Coba Edit/Hapus User
1. Login sebagai Super Admin
2. Buka Manajemen User
3. Coba edit user Staff Admin - **Berhasil**
4. Coba hapus user Public - **Berhasil**
5. Coba edit/hapus Super Admin - **Gagal (Protected)**

---

## File yang Dimodifikasi

### 1. **Database Seeder**
- `database/seeders/RolePermissionSeeder.php`
  - Menambahkan permission `manage users`
  - Hanya super-admin yang mendapat permission ini

### 2. **Controller**
- `app/Http/Controllers/Admin/UserController.php` (BARU)
  - CRUD user dengan middleware `role:super-admin`
  - Middleware `permission:manage users`
  - Proteksi untuk tidak bisa edit/hapus super-admin

### 3. **Routes**
- `routes/web.php`
  - Menambahkan route resource `admin.users`
  - Middleware `permission:manage users`

### 4. **Views**
- `resources/views/admin/users/index.blade.php` (BARU)
- `resources/views/admin/users/create.blade.php` (BARU)
- `resources/views/admin/users/edit.blade.php` (BARU)
- `resources/views/admin/users/show.blade.php` (BARU)
- `resources/views/layouts/app.blade.php` (UPDATE)
  - Menambahkan menu Manajemen User dengan `@can('manage users')`
- `resources/views/admin/dashboard.blade.php` (UPDATE)
  - Menambahkan card Users di dashboard

### 5. **Dashboard Controller**
- `app/Http/Controllers/Admin/DashboardController.php`
  - Menambahkan counting users

---

## Keamanan

### Proteksi yang Diterapkan:
1. ✅ Middleware `role:super-admin` pada UserController
2. ✅ Middleware `permission:manage users` pada routes
3. ✅ Tidak dapat membuat user dengan role super-admin
4. ✅ Tidak dapat edit/hapus akun super-admin
5. ✅ Tidak dapat hapus akun sendiri
6. ✅ Email otomatis lowercase untuk konsistensi
7. ✅ Validasi password dengan Rules\Password
8. ✅ Menu hanya muncul jika ada permission (`@can('manage users')`)

---

## FAQ

**Q: Bagaimana jika saya lupa password Super Admin?**
A: Jalankan seeder ulang dengan `php artisan db:seed --class=RolePermissionSeeder` untuk reset user default.

**Q: Apakah Staff Admin bisa melihat daftar user?**
A: Tidak. Staff Admin tidak memiliki permission `manage users` sehingga tidak bisa mengakses menu dan halaman user management.

**Q: Bagaimana cara membuat Super Admin baru?**
A: Saat ini tidak bisa melalui UI. Super Admin hanya bisa dibuat melalui seeder atau Tinker untuk keamanan.

**Q: Apa yang terjadi jika Staff Admin mencoba akses URL user management langsung?**
A: Akan muncul error 403 Forbidden karena middleware akan memblokir akses.

---

**Dibuat:** {{ date('d F Y') }}
**Versi:** 1.0
**Author:** System Administrator
