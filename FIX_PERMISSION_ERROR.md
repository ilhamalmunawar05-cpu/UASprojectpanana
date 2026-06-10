# FIX: Error "Target class [permission] does not exist"

## 🐛 Error yang Terjadi

Ketika staff login dan mengakses sidebar admin, muncul error:
```
Illuminate\Contracts\Container\BindingResolutionException
Target class [permission] does not exist.
```

Error terjadi di file: `app/Http/Middleware/CheckRole.php:19`

---

## 🔍 Penyebab Error

Middleware `permission` dari package Spatie Laravel Permission **TIDAK terdaftar** di file `app/Http/Kernel.php`. 

Pada routes, kita menggunakan:
```php
Route::resource('artworks', AdminArtworkController::class)
    ->middleware('permission:manage artworks');
```

Tetapi middleware alias `permission` tidak ada di `$middlewareAliases` sehingga Laravel tidak bisa menemukan class yang dimaksud.

---

## ✅ Solusi

### 1. Menambahkan Middleware Spatie ke Kernel.php

Ditambahkan 2 middleware alias dari Spatie Permission ke file `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    'role' => \App\Http\Middleware\CheckRole::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,  // ← BARU
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,  // ← BARU
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ... middleware lainnya
];
```

### 2. Clear Cache

Setelah menambahkan middleware, jalankan perintah:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## 📝 File yang Dimodifikasi

### app/Http/Kernel.php

**SEBELUM:**
```php
protected $middlewareAliases = [
    'role' => \App\Http\Middleware\CheckRole::class,
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ...
];
```

**SESUDAH:**
```php
protected $middlewareAliases = [
    'role' => \App\Http\Middleware\CheckRole::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ...
];
```

---

## 🧪 Testing

### Test 1: Login sebagai Staff Admin
1. Login dengan email: `staff@gallery.com`, password: `password123`
2. Klik menu sidebar (Karya Seni, Seniman, dll)
3. Seharusnya **TIDAK ADA ERROR** lagi
4. Halaman dapat diakses dengan normal

### Test 2: Cek Permission
1. Staff Admin dapat mengakses:
   - ✅ Karya Seni
   - ✅ Seniman & Kurator
   - ✅ Jadwal Pameran
   - ✅ Lelang Karya
   - ✅ Artikel & Ulasan
   - ✅ Koleksi Museum

2. Staff Admin TIDAK dapat mengakses:
   - ❌ Manajemen User (menu tidak muncul)

### Test 3: Login sebagai Super Admin
1. Login dengan email: `admin@gallery.com`, password: `password123`
2. Semua menu harus bisa diakses termasuk Manajemen User
3. Tidak ada error

---

## 📚 Penjelasan Middleware

### permission:manage artworks
Middleware ini mengecek apakah user yang login memiliki permission "manage artworks". Jika tidak, akan muncul error 403 Forbidden.

### role:super-admin|staff-admin
Middleware ini mengecek apakah user memiliki salah satu role: super-admin ATAU staff-admin.

### Kombinasi
Routes admin menggunakan kombinasi middleware:
```php
Route::middleware(['auth', 'role:super-admin|staff-admin'])
    ->prefix('admin')
    ->group(function () {
        
    Route::resource('artworks', AdminArtworkController::class)
        ->middleware('permission:manage artworks');
});
```

**Penjelasan:**
1. User harus login (`auth`)
2. User harus punya role super-admin ATAU staff-admin (`role:super-admin|staff-admin`)
3. User harus punya permission "manage artworks" (`permission:manage artworks`)

Jika salah satu kondisi tidak terpenuhi, user tidak bisa mengakses route tersebut.

---

## ⚠️ Catatan Penting

### Staff Admin dan Permission
- Staff Admin HANYA memiliki permission untuk modul tertentu
- Staff Admin TIDAK memiliki permission "manage users"
- Jika Staff Admin mencoba akses menu yang tidak ada permissionnya, akan muncul error 403

### Super Admin
- Super Admin memiliki SEMUA permission
- Dapat mengakses semua menu tanpa batasan

---

## 🎯 Kesimpulan

**Masalah:** Middleware `permission` tidak terdaftar di Kernel.php
**Solusi:** Menambahkan middleware Spatie Permission ke `$middlewareAliases`
**Status:** ✅ SELESAI DIPERBAIKI

Sekarang staff dapat mengakses sidebar admin tanpa error!

---

**Tanggal Fix:** 8 Januari 2026
**Error Fixed:** Target class [permission] does not exist
