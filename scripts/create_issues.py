#!/usr/bin/env python3
"""
Script untuk membuat GitHub Issues menggunakan PyGithub library
Ini adalah alternative jika PAT token tidak bekerja dengan curl
"""

import os
import sys

try:
    from github import Github
except ImportError:
    print("❌ ERROR: PyGithub library tidak ditemukan")
    print("\nInstal dengan command:")
    print("  pip install PyGithub")
    sys.exit(1)

# Konfigurasi
OWNER = 'ilhamalmunawar05-cpu'
REPO = 'UASprojectpanana'
GITHUB_TOKEN = os.getenv('GITHUB_TOKEN')

if not GITHUB_TOKEN:
    print("❌ ERROR: GITHUB_TOKEN tidak ditemukan!")
    print("\nCara set token:")
    print("  Windows (cmd):      set GITHUB_TOKEN=ghp_xxxxxxxxxxxxx")
    print("  Windows (PowerShell): $env:GITHUB_TOKEN=\"ghp_xxxxxxxxxxxxx\"")
    print("  Linux/Mac:          export GITHUB_TOKEN=ghp_xxxxxxxxxxxxx")
    sys.exit(1)

# Data issues
issues_data = [
    {
        'title': 'Fitur Login & Registrasi',
        'body': '''## Deskripsi
Implementasi sistem login dan registrasi pengguna dengan validasi email dan password yang kuat.

## Acceptance Criteria
- [ ] Form login responsif
- [ ] Form registrasi dengan validasi
- [ ] Email verification
- [ ] Password recovery''',
        'labels': ['feature', 'authentication'],
    },
    {
        'title': 'Dashboard Admin - Manajemen Buku',
        'body': '''## Deskripsi
Buat dashboard untuk admin mengelola koleksi buku (CRUD).

## Acceptance Criteria
- [ ] List buku dengan pagination
- [ ] Form tambah/edit buku
- [ ] Upload cover buku
- [ ] Filter berdasarkan kategori
- [ ] Soft delete support''',
        'labels': ['feature', 'admin'],
    },
    {
        'title': 'Sistem Peminjaman & Pengembalian Buku',
        'body': '''## Deskripsi
Implementasi workflow peminjaman dan pengembalian buku dengan tracking denda otomatis.

## Acceptance Criteria
- [ ] Proses peminjaman user-friendly
- [ ] Auto-calculate denda ketika terlambat
- [ ] Tracking status pengembalian
- [ ] Email notification''',
        'labels': ['feature', 'loans'],
    },
    {
        'title': 'Bug Fix - Database Connection Timeout',
        'body': '''## Deskripsi
Database connection sering timeout saat traffic tinggi.

## Steps to Reproduce
1. Jalankan load test dengan 50+ concurrent users
2. Observe connection pool exhaustion

## Expected Behavior
Connection pool seharusnya handle gracefully

## Actual Behavior
Error 500 Internal Server Error''',
        'labels': ['bug', 'database'],
    },
    {
        'title': 'Dokumentasi API Endpoints',
        'body': '''## Deskripsi
Lengkapi dokumentasi untuk semua REST API endpoints dengan Swagger/OpenAPI.

## Acceptance Criteria
- [ ] API documentation complete
- [ ] Add OpenAPI spec
- [ ] Example requests & responses
- [ ] Authentication guide''',
        'labels': ['documentation', 'api'],
    },
]

print("🚀 Memulai pembuatan GitHub Issues...")
print(f"📦 Repository: {OWNER}/{REPO}")
print("=" * 60)

try:
    # Connect to GitHub
    g = Github(GITHUB_TOKEN)
    repo = g.get_user(OWNER).get_repo(REPO)
    
    success_count = 0
    fail_count = 0
    
    for index, issue_data in enumerate(issues_data, 1):
        print(f"\n[{index}/{len(issues_data)}] Membuat issue: {issue_data['title']}")
        
        try:
            # Create issue
            issue = repo.create_issue(
                title=issue_data['title'],
                body=issue_data['body'],
                labels=issue_data['labels']
            )
            
            print(f"  ✅ Berhasil! Issue #{issue.number}")
            print(f"  URL: {issue.html_url}")
            success_count += 1
            
        except Exception as e:
            print(f"  ❌ Gagal: {str(e)}")
            fail_count += 1
    
    print("\n" + "=" * 60)
    print("📊 Ringkasan:")
    print(f"  ✅ Berhasil: {success_count}")
    print(f"  ❌ Gagal: {fail_count}")
    print(f"  📝 Total: {len(issues_data)}\n")
    
    if success_count == len(issues_data):
        print("🎉 Semua issues berhasil dibuat!")
    elif success_count > 0:
        print("⚠️  Beberapa issues gagal dibuat.")
    else:
        print("❌ Semua issues gagal dibuat.")
        
except Exception as e:
    print(f"\n❌ ERROR: {str(e)}")
    sys.exit(1)
