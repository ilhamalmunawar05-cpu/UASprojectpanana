#!/bin/bash

REPO="ilhamalmunawar05-cpu/UASprojectpanana"

echo "🚀 Membuat GitHub Issues menggunakan GitHub CLI..."
echo "📦 Repository: $REPO"
echo "=========================================="

# Create issues
gh issue create -R "$REPO" \
  --title "Fitur Login & Registrasi" \
  --body "## Deskripsi
Implementasi sistem login dan registrasi pengguna dengan validasi email dan password yang kuat.

## Acceptance Criteria
- [ ] Form login responsif
- [ ] Form registrasi dengan validasi
- [ ] Email verification
- [ ] Password recovery" \
  --label "feature,authentication"

gh issue create -R "$REPO" \
  --title "Dashboard Admin - Manajemen Buku" \
  --body "## Deskripsi
Buat dashboard untuk admin mengelola koleksi buku (CRUD).

## Acceptance Criteria
- [ ] List buku dengan pagination
- [ ] Form tambah/edit buku
- [ ] Upload cover buku
- [ ] Filter berdasarkan kategori
- [ ] Soft delete support" \
  --label "feature,admin"

gh issue create -R "$REPO" \
  --title "Sistem Peminjaman & Pengembalian Buku" \
  --body "## Deskripsi
Implementasi workflow peminjaman dan pengembalian buku dengan tracking denda otomatis.

## Acceptance Criteria
- [ ] Proses peminjaman user-friendly
- [ ] Auto-calculate denda ketika terlambat
- [ ] Tracking status pengembalian
- [ ] Email notification" \
  --label "feature,loans"

gh issue create -R "$REPO" \
  --title "Bug Fix - Database Connection Timeout" \
  --body "## Deskripsi
Database connection sering timeout saat traffic tinggi.

## Steps to Reproduce
1. Jalankan load test dengan 50+ concurrent users
2. Observe connection pool exhaustion

## Expected Behavior
Connection pool seharusnya handle gracefully

## Actual Behavior
Error 500 Internal Server Error" \
  --label "bug,database"

gh issue create -R "$REPO" \
  --title "Dokumentasi API Endpoints" \
  --body "## Deskripsi
Lengkapi dokumentasi untuk semua REST API endpoints dengan Swagger/OpenAPI.

## Acceptance Criteria
- [ ] API documentation complete
- [ ] Add OpenAPI spec
- [ ] Example requests & responses
- [ ] Authentication guide" \
  --label "documentation,api"

echo ""
echo "✅ Semua issues berhasil dibuat!"
