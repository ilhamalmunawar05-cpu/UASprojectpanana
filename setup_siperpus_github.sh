#!/usr/bin/env bash
# =============================================================================
# SETUP GITHUB PROJECT - SI-PERPUS (Sistem Informasi Perpustakaan)
# Repository : https://github.com/ilhamalmunawar05-cpu/UASprojectpanana
# Project    : PROJECT Si-Perpus
# Tim        : Backend (fajar1180) | Frontend (ilhamalmunawar05-cpu)
# =============================================================================
# FIX v2: Tidak menggunakan declare -A (tidak reliable di Git Bash/MINGW64)
#         Milestone number diambil langsung dari API saat membuat issue
# =============================================================================
# Cara pakai:
#   1. Pastikan GitHub CLI sudah terpasang  → https://cli.github.com
#   2. Login dulu                           → gh auth login
#   3. chmod +x setup_siperpus_github.sh
#   4. ./setup_siperpus_github.sh
# =============================================================================

# Jangan pakai set -e agar script tidak berhenti total saat 1 item gagal
set +e

REPO="ilhamalmunawar05-cpu/UASprojectpanana"
PROJECT_NAME="PROJECT Si-Perpus"
BACKEND_USER="fajar1180"
FRONTEND_USER="ilhamalmunawar05-cpu"

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m'

log_info()    { echo -e "${BLUE}[INFO]${NC} $1"; }
log_success() { echo -e "${GREEN}[OK]${NC}   $1"; }
log_warn()    { echo -e "${YELLOW}[SKIP]${NC} $1"; }
log_error()   { echo -e "${RED}[ERR]${NC}  $1"; }
log_section() {
  echo ""
  echo -e "${BOLD}${CYAN}══════════════════════════════════════${NC}"
  echo -e "${BOLD}${CYAN} $1${NC}"
  echo -e "${BOLD}${CYAN}══════════════════════════════════════${NC}"
}

# ─── PRE-CHECK ────────────────────────────────────────────────────────────────
log_section "Pre-flight Check"

if ! command -v gh &>/dev/null; then
  log_error "GitHub CLI (gh) tidak ditemukan. Install dari https://cli.github.com"
  exit 1
fi

if ! gh auth status &>/dev/null; then
  log_error "Belum login ke GitHub CLI. Jalankan: gh auth login"
  exit 1
fi

log_success "GitHub CLI tersedia dan sudah login"
log_info "Target repo : $REPO"

# ─── HELPERS ──────────────────────────────────────────────────────────────────

label_exists() {
  gh label list --repo "$REPO" --limit 100 --json name 2>/dev/null \
    | grep -q "\"$1\""
}

create_label() {
  local name="$1" color="$2" desc="$3"
  if label_exists "$name"; then
    log_warn "Label '$name' sudah ada — diskip"
  else
    if gh label create "$name" --repo "$REPO" --color "$color" --description "$desc" 2>/dev/null; then
      log_success "Label '$name' dibuat"
    else
      log_error "Gagal membuat label '$name'"
    fi
  fi
}

milestone_exists() {
  gh api "repos/$REPO/milestones?state=all&per_page=100" \
    --jq '.[].title' 2>/dev/null \
    | grep -qxF "$1"
}

# Ambil milestone number LANGSUNG dari API (tidak pakai cache)
get_ms_number() {
  local title="$1"
  gh api "repos/$REPO/milestones?state=all&per_page=100" \
    --jq ".[] | select(.title == \"$title\") | .number" 2>/dev/null \
    | head -1
}

create_milestone() {
  local title="$1" due="$2" desc="$3"
  if milestone_exists "$title"; then
    log_warn "Milestone '$title' sudah ada — diskip"
  else
    if gh api "repos/$REPO/milestones" \
        --method POST \
        --field title="$title" \
        --field description="$desc" \
        --field due_on="${due}T23:59:59Z" \
        --field state="open" > /dev/null 2>&1; then
      log_success "Milestone '$title' dibuat (due: $due)"
    else
      log_error "Gagal membuat milestone '$title'"
    fi
  fi
}

issue_exists() {
  gh issue list --repo "$REPO" --state all --limit 300 --json title 2>/dev/null \
    | grep -qF "$1"
}

# Buat issue — milestone number diambil fresh dari API
create_issue() {
  local title="$1"
  local body="$2"
  local assignee="$3"
  local labels="$4"
  local ms_title="$5"

  if issue_exists "$title"; then
    log_warn "Issue sudah ada: $title"
    return
  fi

  # Ambil milestone number langsung dari API
  local ms_num=""
  if [[ -n "$ms_title" ]]; then
    ms_num=$(get_ms_number "$ms_title")
  fi

  local cmd_args=("--repo" "$REPO" "--title" "$title" "--body" "$body")

  [[ -n "$assignee" ]]  && cmd_args+=("--assignee" "$assignee")
  [[ -n "$ms_num" ]]    && cmd_args+=("--milestone" "$ms_num")

  # Tambahkan tiap label satu per satu
  IFS=',' read -ra lbl_arr <<< "$labels"
  for lbl in "${lbl_arr[@]}"; do
    lbl="$(echo "$lbl" | xargs)"  # trim spasi
    [[ -n "$lbl" ]] && cmd_args+=("--label" "$lbl")
  done

  if gh issue create "${cmd_args[@]}" > /dev/null 2>&1; then
    log_success "Issue: $title"
  else
    log_error "Gagal membuat issue: $title"
  fi
}

# =============================================================================
# 1/5  LABELS
# =============================================================================
log_section "1/5  Membuat Labels"

# Tipe
create_label "feature"       "0075ca" "Fitur baru"
create_label "bug"           "d73a4a" "Bug atau error"
create_label "enhancement"   "a2eeef" "Peningkatan fitur yang sudah ada"
create_label "documentation" "e4e669" "Dokumentasi"
create_label "testing"       "f9d0c4" "Unit / integration / UAT testing"
create_label "database"      "5319e7" "Migrasi, seeder, ERD"
create_label "security"      "b60205" "Keamanan & autentikasi"
create_label "ui-ux"         "fbca04" "Tampilan & pengalaman pengguna"
create_label "api"           "0e8a16" "Backend API endpoint"

# Prioritas
create_label "priority: high"   "e11d48" "Harus selesai segera"
create_label "priority: medium" "f59e0b" "Normal priority"
create_label "priority: low"    "6b7280" "Bisa dikerjakan belakangan"

# Status
create_label "status: in-progress" "1d4ed8" "Sedang dikerjakan"
create_label "status: review"      "7c3aed" "Menunggu code review"
create_label "status: blocked"     "991b1b" "Terblokir dependency"
create_label "status: done"        "065f46" "Selesai"

# Assignee
create_label "backend"   "16a34a" "Tugas Backend (fajar1180)"
create_label "frontend"  "2563eb" "Tugas Frontend (ilhamalmunawar05-cpu)"
create_label "fullstack" "7e22ce" "Backend + Frontend bersama"

# Modul
create_label "modul: auth"       "0ea5e9" "Modul Autentikasi & RBAC"
create_label "modul: opac"       "06b6d4" "Modul OPAC / Katalog Publik"
create_label "modul: sirkulasi"  "10b981" "Modul Sirkulasi Pinjam-Kembali"
create_label "modul: denda"      "f97316" "Modul Perhitungan Denda"
create_label "modul: anggota"    "8b5cf6" "Modul Manajemen Anggota"
create_label "modul: buku"       "ec4899" "Modul Manajemen Buku & Katalog"
create_label "modul: eresource"  "14b8a6" "Modul E-Resources"
create_label "modul: laporan"    "f43f5e" "Modul Laporan & Statistik"
create_label "modul: dashboard"  "a855f7" "Dashboard & Monitoring"

# =============================================================================
# 2/5  MILESTONES
# =============================================================================
log_section "2/5  Membuat Milestones"

create_milestone "M1: Analysis & Design"              "2026-06-24" "Requirement gathering, SRS finalisasi, ERD, UI Mockup"
create_milestone "M2: Development - Core"             "2026-07-15" "Setup project, Auth/RBAC, Manajemen Anggota & Buku"
create_milestone "M3: Development - Fitur Utama"      "2026-07-29" "OPAC, Sirkulasi, Denda, E-Resources"
create_milestone "M4: Development - Dashboard & Laporan" "2026-08-05" "Dashboard, Reporting, Export PDF/Excel"
create_milestone "M5: Testing & QA"                   "2026-08-19" "Unit test, Integration test, UAT, Bug fixing"
create_milestone "M6: Deployment & Training"          "2026-08-26" "Production deploy, training staf, go-live"

log_info "Verifikasi milestone numbers dari API..."
for ms_title in \
  "M1: Analysis & Design" \
  "M2: Development - Core" \
  "M3: Development - Fitur Utama" \
  "M4: Development - Dashboard & Laporan" \
  "M5: Testing & QA" \
  "M6: Deployment & Training"
do
  num=$(get_ms_number "$ms_title")
  if [[ -n "$num" ]]; then
    log_success "  '$ms_title' → #$num"
  else
    log_error "  '$ms_title' → tidak ditemukan!"
  fi
done

# =============================================================================
# 3/5  ISSUES
# =============================================================================
log_section "3/5  Membuat Issues"

# ── M1: Analysis & Design ─────────────────────────────────────────────────────
MS1="M1: Analysis & Design"

create_issue \
"[DOCS] Finalisasi SRS v2.0 & persetujuan stakeholder" \
"## Deskripsi
Finalisasi dokumen SRS versi 2.0 dan mendapatkan sign-off dari stakeholder.

## Acceptance Criteria
- [ ] SRS mencakup semua 20 Use Case (UC-001 s/d UC-020)
- [ ] Tabel stakeholder, aktor, dan batasan sistem lengkap
- [ ] Persetujuan dari Kepala Perpustakaan (Syahid Rohidin)
- [ ] Dokumen di-upload ke repository

## Referensi
- File: SRS_SIPERPUS_LENGKAP.md
- File: USTEK_KELOMPOK_6_SIPERPUS_LENGKAP.md" \
"$BACKEND_USER" \
"documentation,priority: high,modul: auth" \
"$MS1"

create_issue \
"[DOCS] Finalisasi ERD & LRS Database SIPERPUS" \
"## Deskripsi
Finalisasi Entity Relationship Diagram (ERD) dan Logical Record Structure (LRS) untuk semua tabel database SIPERPUS.

## Acceptance Criteria
- [ ] ERD mencakup semua entitas: users, roles, members, books, categories, loans, loan_returns, fine_payments, e_resources, audit_logs
- [ ] Foreign key & relasi antar tabel lengkap
- [ ] ERD dalam format Mermaid sudah divalidasi
- [ ] LRS diturunkan dari ERD dengan benar

## Referensi
- File: ERD_MERMAID.md
- File: STRUKTUR_DATABASE.md" \
"$BACKEND_USER" \
"documentation,database,priority: high" \
"$MS1"

create_issue \
"[DOCS] Buat UI/UX Mockup semua halaman SIPERPUS" \
"## Deskripsi
Buat wireframe/mockup untuk semua halaman yang akan diimplementasikan.

## Halaman yang Perlu Di-mockup
- [ ] Halaman Login
- [ ] Dashboard Admin
- [ ] OPAC (pencarian publik)
- [ ] Manajemen Buku (list, create, edit)
- [ ] Manajemen Anggota
- [ ] Form Sirkulasi (pinjam & kembali)
- [ ] Halaman Laporan

## Acceptance Criteria
- [ ] Mockup setiap halaman sudah disetujui tim
- [ ] Konsisten dengan tema Navy Blue SIPERPUS
- [ ] Responsive layout (mobile + desktop)" \
"$FRONTEND_USER" \
"documentation,ui-ux,priority: medium" \
"$MS1"

# ── M2: Development - Core ────────────────────────────────────────────────────
MS2="M2: Development - Core"

create_issue \
"[BE] Setup Project Laravel & Konfigurasi Database" \
"## Deskripsi
Setup awal project Laravel, konfigurasi database MySQL, instalasi package Spatie Permission untuk RBAC.

## Acceptance Criteria
- [ ] Laravel 10 terinstall dengan struktur direktori bersih
- [ ] Koneksi MySQL terkonfigurasi di .env
- [ ] Package spatie/laravel-permission terinstall
- [ ] Storage link dibuat (php artisan storage:link)
- [ ] README.md berisi instruksi instalasi
- [ ] .gitignore sudah mengecualikan .env & vendor/

## Tech Stack
- PHP 8.1+ / Laravel 10 / MySQL 8.0 / Spatie Laravel Permission" \
"$BACKEND_USER" \
"feature,backend,priority: high,modul: auth" \
"$MS2"

create_issue \
"[BE] Implementasi Migrasi & Seeder Database Lengkap" \
"## Deskripsi
Buat semua file migrasi database sesuai ERD SIPERPUS dan seeder untuk data awal.

## Tabel yang Harus Dibuat
- [ ] users, roles, permissions (via Spatie)
- [ ] categories
- [ ] books (isbn, title, author, publisher, year, category_id, location, stock_total, stock_available, condition, cover_image)
- [ ] members (user_id, nim_nidn, full_name, phone, address, department, status, joined_date)
- [ ] loans (member_id, book_id, loan_date, due_date, status)
- [ ] loan_returns (loan_id, return_date, late_days, fine_amount, notes)
- [ ] fine_payments (loan_return_id, payment_date, amount, payment_method)
- [ ] e_resources (title, type, file_path, url, category, uploaded_by, description)
- [ ] audit_logs (user_id, action, model, model_id, old_values, new_values, ip_address)

## Seeder yang Harus Ada
- [ ] RolePermissionSeeder
- [ ] UserSeeder (3 akun default)
- [ ] CategorySeeder (min 10 kategori)
- [ ] BookSeeder (min 7 sample buku)
- [ ] MemberSeeder (5 anggota)
- [ ] LibrarySeeder (3 loan + e-resources)

## Acceptance Criteria
- [ ] php artisan migrate berjalan tanpa error
- [ ] php artisan db:seed berjalan tanpa error
- [ ] Semua FK constraint benar

## Referensi
- STRUKTUR_DATABASE.md / ERD_MERMAID.md" \
"$BACKEND_USER" \
"database,backend,priority: high" \
"$MS2"

create_issue \
"[BE] Implementasi Autentikasi & RBAC (UC-001 s/d UC-004)" \
"## Deskripsi
Implementasi sistem autentikasi lengkap dengan RBAC menggunakan Spatie Laravel Permission.

## Use Case yang Dicakup
- UC-001: Login (lockout 3x gagal = 15 menit)
- UC-002: Logout (destroy session)
- UC-003: Reset Password (via email, valid 24 jam)
- UC-004: Manajemen Data Pengguna (Admin Only)

## Role & Permission
- Super Admin: semua permission termasuk manage users
- Staff Admin: semua kecuali manage users & manage comments
- Public: view public content

## Acceptance Criteria
- [ ] Login/logout berfungsi, session 30 menit timeout
- [ ] Lockout setelah 3x gagal (15 menit)
- [ ] Reset password via email
- [ ] Middleware role:super-admin berjalan
- [ ] Error 403 jika akses tanpa permission
- [ ] Login attempt di-log ke audit_logs

## Referensi
- PANDUAN_HAK_AKSES.md / PERBANDINGAN_SEBELUM_SESUDAH.md" \
"$BACKEND_USER" \
"feature,backend,security,priority: high,modul: auth" \
"$MS2"

create_issue \
"[BE] CRUD Manajemen Anggota Perpustakaan (UC-005)" \
"## Deskripsi
Implementasi full CRUD untuk manajemen anggota perpustakaan dengan validasi lengkap.

## Field Anggota
NIM/NIDN (unique), Nama Lengkap, Program Studi, No HP (11-13 digit), Alamat, Status (aktif/non-aktif/suspend), Tanggal daftar

## Fitur yang Harus Ada
- [ ] Create/Read/Update/Delete anggota dengan validasi
- [ ] Pagination + search by NIM/nama
- [ ] Export PDF & Excel
- [ ] Bulk import dari CSV (max 1000 records)
- [ ] Suspend anggota jika tunggakan denda melebihi batas
- [ ] Riwayat peminjaman per anggota

## Acceptance Criteria
- [ ] CRUD berjalan tanpa error
- [ ] NIM duplikat terdeteksi
- [ ] Pencarian response < 2 detik
- [ ] Export PDF/Excel generate < 5 detik

## API Endpoints
GET/POST/PUT/DELETE /admin/members
POST /admin/members/import
GET /admin/members/export
POST /admin/members/{id}/suspend" \
"$BACKEND_USER" \
"feature,backend,api,priority: high,modul: anggota" \
"$MS2"

create_issue \
"[BE] CRUD Manajemen Buku & Kategori (UC-006 & UC-007)" \
"## Deskripsi
Implementasi CRUD untuk manajemen buku dan kategori buku.

## Field Buku
ISBN (unique, 10/13 digit), Judul, Penulis, Penerbit, Tahun (1900-2100), Kategori (FK), Lokasi Rak (format A-01-03), Stok total & tersedia, Kondisi fisik, Cover image

## Fitur yang Harus Ada
- [ ] CRUD buku dengan validasi ISBN
- [ ] Bulk import buku dari Excel
- [ ] Upload cover image (JPG/PNG max 2MB)
- [ ] Update stok otomatis saat pinjam/kembali (via observer)
- [ ] Pencarian duplikat ISBN
- [ ] CRUD Kategori (dengan soft delete)
- [ ] Durasi peminjaman default per kategori (override 14 hari)

## Acceptance Criteria
- [ ] Validasi ISBN 10 atau 13 digit
- [ ] Stok tidak bisa negatif
- [ ] Bulk import 500 records < 10 detik
- [ ] Duplikat ISBN terblokir" \
"$BACKEND_USER" \
"feature,backend,api,priority: high,modul: buku" \
"$MS2"

create_issue \
"[FE] Implementasi Layout Admin: Sidebar, Navbar, Theme Navy Blue" \
"## Deskripsi
Buat layout utama panel admin SIPERPUS dengan sidebar navigasi, navbar, dan tema Navy Blue.

## Komponen yang Harus Dibuat
- [ ] layouts/admin.blade.php (master layout)
- [ ] Sidebar dengan semua menu modul
- [ ] Navbar top (user info, logout button)
- [ ] Active state detection di sidebar
- [ ] Role-based menu visibility via @can directive
- [ ] Responsive collapsed sidebar di mobile

## Menu Sidebar
Dashboard / Manajemen Buku / Manajemen Anggota / Sirkulasi / E-Resources / Laporan / Manajemen User (hanya Super Admin)

## Acceptance Criteria
- [ ] Tema Navy Blue konsisten di semua halaman
- [ ] Menu Manajemen User hanya muncul untuk super-admin
- [ ] Responsive di layar >= 375px
- [ ] Bootstrap 5.3 & FontAwesome digunakan

## Referensi
- PANDUAN_HAK_AKSES.md bagian Visual Interface" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: dashboard" \
"$MS2"

create_issue \
"[FE] Halaman Login, Logout & Reset Password (UC-001 s/d UC-003)" \
"## Deskripsi
Implementasi halaman autentikasi: login, logout, dan reset password.

## Halaman yang Harus Dibuat
- [ ] /login (form login dengan validasi client-side)
- [ ] /forgot-password (form input email untuk reset)
- [ ] /reset-password/{token} (form buat password baru)

## Acceptance Criteria
- [ ] Error message muncul jika credential salah
- [ ] Pesan lockout 15 menit muncul setelah 3x gagal
- [ ] Responsive di mobile
- [ ] Loading state saat submit
- [ ] Logo & branding SIPERPUS tampil di halaman login
- [ ] Redirect ke dashboard setelah login sukses" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: auth" \
"$MS2"

create_issue \
"[FE] Halaman Dashboard Admin (Statistik & Quick Links)" \
"## Deskripsi
Implementasi halaman dashboard admin dengan kartu statistik dan grafik.

## Kartu Statistik
- [ ] Total Buku, Total Anggota, Peminjaman Aktif
- [ ] Buku Terlambat Dikembalikan
- [ ] Total Denda Belum Dibayar
- [ ] Total Kategori, Total E-Resources
- [ ] Total Users (khusus super-admin)

## Komponen Tambahan
- [ ] Grafik peminjaman 30 hari terakhir (Chart.js)
- [ ] Tabel top 5 buku paling sering dipinjam
- [ ] Alert buku overdue

## Acceptance Criteria
- [ ] Semua kartu menampilkan data real dari backend
- [ ] Load dashboard < 3 detik
- [ ] Responsive grid layout" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: dashboard" \
"$MS2"

create_issue \
"[FE] Halaman CRUD Manajemen Anggota (UC-005)" \
"## Deskripsi
Implementasi halaman CRUD untuk manajemen anggota perpustakaan.

## Halaman yang Harus Dibuat
- [ ] /admin/members (list: datatable + search + filter status)
- [ ] /admin/members/create (form tambah anggota)
- [ ] /admin/members/{id}/edit (form edit)
- [ ] /admin/members/{id} (detail + riwayat pinjaman)
- [ ] Modal konfirmasi hapus & modal suspend

## Acceptance Criteria
- [ ] Datatable dengan pagination (10/25/50 per halaman)
- [ ] Search realtime by NIM/nama
- [ ] Filter dropdown: status (aktif/non-aktif/suspend)
- [ ] Badge warna untuk status anggota
- [ ] Tombol Export PDF & Export Excel
- [ ] Form validation client-side
- [ ] Toast notification sukses/gagal" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: anggota" \
"$MS2"

create_issue \
"[FE] Halaman CRUD Manajemen Buku & Kategori (UC-006 & UC-007)" \
"## Deskripsi
Implementasi halaman CRUD untuk manajemen buku dan kategori.

## Halaman Buku
- [ ] List buku (datatable: ISBN, judul, penulis, stok, kondisi)
- [ ] Form tambah/edit buku (preview upload cover)
- [ ] Detail buku + riwayat peminjaman buku
- [ ] Modal hapus + konfirmasi
- [ ] Filter: kategori, kondisi, stok tersedia
- [ ] Import Excel (form upload + progress bar)

## Halaman Kategori
- [ ] List kategori (nama + durasi default + jumlah buku)
- [ ] Form tambah/edit kategori

## Acceptance Criteria
- [ ] Preview cover image sebelum upload
- [ ] Validasi ISBN format di frontend
- [ ] Badge stok: Tersedia / Terbatas / Habis
- [ ] Bulk import dengan progress indicator" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: buku" \
"$MS2"

# ── M3: Development - Fitur Utama ─────────────────────────────────────────────
MS3="M3: Development - Fitur Utama"

create_issue \
"[BE] Implementasi Modul OPAC - Pencarian Katalog Publik (UC-008 & UC-009)" \
"## Deskripsi
Implementasi OPAC — pencarian katalog buku yang bisa diakses tanpa login.

## Fitur yang Harus Ada
- [ ] Pencarian full-text: judul, penulis, ISBN, penerbit
- [ ] Filter: kategori, tahun, kondisi, ketersediaan
- [ ] Pagination hasil pencarian
- [ ] Detail buku + status ketersediaan stok real-time
- [ ] Reservasi buku (stok 0, anggota login bisa reserve)
- [ ] Tampil jumlah antrian reservasi

## Acceptance Criteria
- [ ] Response pencarian < 2 detik
- [ ] Accessible tanpa login
- [ ] Detail buku menampilkan stok real-time

## API Endpoints
GET /opac/search?q=&category=&year=&available=
GET /opac/books/{id}
POST /opac/books/{id}/reserve (harus login)" \
"$BACKEND_USER" \
"feature,backend,api,priority: high,modul: opac" \
"$MS3"

create_issue \
"[BE] Implementasi Modul Sirkulasi: Peminjaman & Pengembalian (UC-010 s/d UC-013)" \
"## Deskripsi
Implementasi modul sirkulasi lengkap: catat peminjaman, proses pengembalian, perhitungan denda otomatis.

## Use Case yang Dicakup
UC-010: Peminjaman Buku / UC-011: Pengembalian / UC-012: Hitung Denda / UC-013: Bayar Denda

## Business Logic
- Durasi default 14 hari (atau sesuai kategori buku)
- Denda: Rp 5.000 per hari keterlambatan
- late_days = max(0, returnDate.diffInDays(dueDate))
- fine_amount = late_days * 5000

## Fitur yang Harus Ada
- [ ] Catat peminjaman (pilih anggota + buku, set due_date)
- [ ] Validasi: anggota aktif? stok tersedia? tidak suspend?
- [ ] Proses pengembalian + hitung denda otomatis
- [ ] Catat pembayaran denda (cash/bank/card)
- [ ] Update stok buku otomatis (decrement/increment)
- [ ] List peminjaman overdue
- [ ] Suspend anggota jika denda melebihi batas

## Acceptance Criteria
- [ ] Stok buku tidak bisa negatif
- [ ] Denda dihitung otomatis Rp 5.000/hari
- [ ] Pengembalian terlambat terdeteksi akurat

## Referensi
- SIPERPUS_PROGRESS.md bagian Catatan Teknis" \
"$BACKEND_USER" \
"feature,backend,api,priority: high,modul: sirkulasi,modul: denda" \
"$MS3"

create_issue \
"[BE] Implementasi Modul E-Resources (UC-016 & UC-017)" \
"## Deskripsi
Implementasi modul E-Resources untuk upload dan manajemen konten digital.

## Fitur yang Harus Ada
- [ ] Upload file: PDF, EPUB, DOC, DOCX, ZIP (max 100MB)
- [ ] Alternatif: simpan URL eksternal
- [ ] CRUD e-resource dengan kategorisasi
- [ ] Download log (tracking siapa & kapan download)
- [ ] Validasi format & ukuran file
- [ ] Soft delete

## Storage
storage/app/public/eresources/ (via php artisan storage:link)

## Acceptance Criteria
- [ ] Upload file max 100MB berhasil
- [ ] Format tidak valid ditolak
- [ ] Download log tercatat
- [ ] File terhapus dari storage saat record dihapus" \
"$BACKEND_USER" \
"feature,backend,api,priority: medium,modul: eresource" \
"$MS3"

create_issue \
"[FE] Halaman OPAC - Interface Pencarian Publik (UC-008 & UC-009)" \
"## Deskripsi
Implementasi halaman OPAC yang bisa diakses tanpa login — interface pencarian katalog untuk mahasiswa/dosen.

## Halaman yang Harus Dibuat
- [ ] /opac (halaman pencarian utama dengan search bar besar)
- [ ] Filter sidebar: kategori, tahun, kondisi, ketersediaan
- [ ] Grid/list hasil pencarian (toggle view)
- [ ] Card buku: cover, judul, penulis, badge ketersediaan
- [ ] /opac/books/{id} (detail buku)
- [ ] Tombol Reservasi (hanya jika login & stok = 0)

## Acceptance Criteria
- [ ] Tampilan bersih dan user-friendly
- [ ] Badge Tersedia (hijau) / Tidak Tersedia (merah)
- [ ] Pagination dengan info total hasil
- [ ] Accessible tanpa login
- [ ] Mobile responsive" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: opac" \
"$MS3"

create_issue \
"[FE] Halaman Sirkulasi: Form Peminjaman & Pengembalian (UC-010 s/d UC-012)" \
"## Deskripsi
Implementasi halaman sirkulasi untuk mencatat peminjaman dan memproses pengembalian buku.

## Halaman yang Harus Dibuat
- [ ] /admin/loans (list dengan tab: Aktif | Dikembalikan | Terlambat)
- [ ] /admin/loans/create (form catat peminjaman: pilih anggota & buku via autocomplete)
- [ ] /admin/loans/{id} (detail peminjaman)
- [ ] /admin/loans/{id}/return (form pengembalian + preview denda live)

## Acceptance Criteria
- [ ] Autocomplete anggota & buku (search as you type)
- [ ] Preview denda real-time saat input tanggal kembali
- [ ] Badge status: Aktif (biru) / Dikembalikan (hijau) / Terlambat (merah)
- [ ] Konfirmasi sebelum proses pengembalian

## Referensi
- SIPERPUS_PROGRESS.md bagian Test Loan System" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: high,modul: sirkulasi,modul: denda" \
"$MS3"

create_issue \
"[FE] Halaman E-Resources: Upload & Manajemen Konten Digital" \
"## Deskripsi
Implementasi halaman untuk upload dan manajemen e-resources.

## Halaman yang Harus Dibuat
- [ ] /admin/eresources (list dengan filter tipe & kategori)
- [ ] /admin/eresources/create (form upload: toggle File vs URL, drag & drop, progress bar)
- [ ] /admin/eresources/{id}/edit (edit metadata)
- [ ] /eresources (public view untuk member)

## Acceptance Criteria
- [ ] Drag & drop upload dengan progress bar
- [ ] Validasi format file di client-side
- [ ] Toggle upload/URL yang smooth
- [ ] Icon berbeda per tipe file (PDF, EPUB, DOC)
- [ ] Tombol Download / Open Link yang jelas" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: medium,modul: eresource" \
"$MS3"

create_issue \
"[FE] Halaman Manajemen User (Super Admin Only)" \
"## Deskripsi
Implementasi halaman CRUD manajemen user — hanya accessible oleh Super Admin.

## Halaman yang Harus Dibuat
- [ ] /admin/users (list user: badge role, status)
- [ ] /admin/users/create (form tambah user, role: Staff Admin / Public saja)
- [ ] /admin/users/{id}/edit (form edit, password opsional)
- [ ] /admin/users/{id} (detail + activity log)

## Aturan UI
- [ ] Tombol Edit/Hapus TIDAK MUNCUL untuk akun Super Admin (badge Protected)
- [ ] Role dropdown hanya: Staff Admin, Public
- [ ] Konfirmasi sebelum hapus user
- [ ] Tidak bisa hapus akun sendiri

## Acceptance Criteria
- [ ] Menu hanya muncul jika user adalah super-admin
- [ ] Akses URL /admin/users oleh staff = redirect 403
- [ ] Badge role warna berbeda

## Referensi
- PANDUAN_HAK_AKSES.md / PERBANDINGAN_SEBELUM_SESUDAH.md" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,security,priority: high,modul: auth" \
"$MS3"

# ── M4: Dashboard & Laporan ───────────────────────────────────────────────────
MS4="M4: Development - Dashboard & Laporan"

create_issue \
"[BE] Implementasi Modul Laporan & Export PDF/Excel (UC-018)" \
"## Deskripsi
Implementasi modul laporan statistik dengan export PDF dan Excel.

## Laporan yang Harus Tersedia
- [ ] Laporan Peminjaman per periode (date range filter)
- [ ] Laporan Pengembalian & Keterlambatan
- [ ] Laporan Denda (total, terbayar, tunggakan)
- [ ] Laporan Anggota (aktif, non-aktif, suspend)
- [ ] Laporan Buku (stok, kondisi, paling sering dipinjam)
- [ ] Laporan E-Resources (download count)

## Export Format
- [ ] PDF via Laravel DomPDF
- [ ] Excel via Maatwebsite/Laravel-Excel

## Acceptance Criteria
- [ ] Date range filter berjalan
- [ ] Export PDF generate < 5 detik
- [ ] Export Excel dengan header kolom yang benar
- [ ] Laporan menampilkan nama pembuat & tanggal cetak" \
"$BACKEND_USER" \
"feature,backend,api,priority: medium,modul: laporan" \
"$MS4"

create_issue \
"[BE] Implementasi Dashboard API & Audit Log (UC-019)" \
"## Deskripsi
Implementasi API endpoint untuk data dashboard dan sistem audit log.

## Dashboard Data Endpoints
- [ ] Total buku, anggota, loan aktif, overdue, denda
- [ ] Grafik peminjaman 30 hari terakhir
- [ ] Top 5 buku paling sering dipinjam
- [ ] Statistik e-resource download

## Audit Log
- [ ] Log semua aksi CRUD (create, update, delete)
- [ ] Capture: user_id, action, model, old_values, new_values, ip_address, timestamp
- [ ] Implementasi via Observer atau Trait
- [ ] API endpoint untuk view audit log (admin only)

## Acceptance Criteria
- [ ] API dashboard response < 500ms
- [ ] Audit log tercatat untuk semua operasi sensitif
- [ ] Log tidak bisa diedit/dihapus oleh siapapun" \
"$BACKEND_USER" \
"feature,backend,api,security,priority: medium,modul: dashboard" \
"$MS4"

create_issue \
"[FE] Halaman Laporan & Export PDF/Excel (UC-018)" \
"## Deskripsi
Implementasi halaman modul laporan dengan filter tanggal dan tombol export.

## Halaman yang Harus Dibuat
- [ ] /admin/reports (halaman utama laporan)
- [ ] Tab navigasi: Peminjaman | Denda | Anggota | Buku
- [ ] Date range picker untuk filter periode
- [ ] Preview tabel data sebelum export
- [ ] Tombol Export PDF & Export Excel per laporan
- [ ] Loading state saat generate laporan

## Acceptance Criteria
- [ ] Date range picker UX nyaman
- [ ] Tabel preview data real dari API
- [ ] Tombol export mendownload file langsung
- [ ] Loading spinner saat generate
- [ ] Empty state jika tidak ada data" \
"$FRONTEND_USER" \
"feature,frontend,ui-ux,priority: medium,modul: laporan" \
"$MS4"

# ── M5: Testing & QA ──────────────────────────────────────────────────────────
MS5="M5: Testing & QA"

create_issue \
"[BE] Unit Testing & Integration Testing (Coverage >= 80%)" \
"## Deskripsi
Implementasi unit test dan integration test untuk semua business logic kritis.

## Scope Testing
### Unit Test (PHPUnit)
- [ ] LoanController: createLoan, processReturn, calculateFine
- [ ] MemberController: create, update, suspend logic
- [ ] BookController: stock management, ISBN validation
- [ ] FineCalculationService: Rp 5.000/hari, edge cases
- [ ] AuthController: login, lockout, reset password

### Integration Test
- [ ] Loan + Fine calculation flow (end-to-end)
- [ ] OPAC search + stock availability
- [ ] Member registration + loan eligibility
- [ ] File upload + storage (e-resources)

## Acceptance Criteria
- [ ] Coverage >= 80% untuk business logic
- [ ] Semua test pass (php artisan test)
- [ ] Test report di-generate" \
"$BACKEND_USER" \
"testing,backend,priority: high" \
"$MS5"

create_issue \
"[FE] Cross-Browser Testing & Responsive Testing" \
"## Deskripsi
Testing tampilan dan fungsi di berbagai browser dan ukuran layar.

## Browser yang Harus Ditest
- [ ] Chrome latest / Firefox latest / Safari / Edge latest

## Breakpoint yang Harus Ditest
- [ ] Mobile 375px, 414px
- [ ] Tablet 768px
- [ ] Desktop 1024px, 1440px

## Halaman yang Ditest
Login / Dashboard / OPAC search / Form peminjaman / Halaman laporan

## Acceptance Criteria
- [ ] Tidak ada layout rusak di semua breakpoint
- [ ] Form input usable di mobile
- [ ] Tabel horizontal scroll di mobile
- [ ] Semua tombol min 44x44px touch target" \
"$FRONTEND_USER" \
"testing,frontend,priority: medium" \
"$MS5"

create_issue \
"[FULLSTACK] Security Testing: OWASP Top 10 Check" \
"## Deskripsi
Melakukan security testing berdasarkan OWASP Top 10.

## Checklist OWASP
- [ ] SQL Injection: test semua input form & query parameter
- [ ] XSS: test input yang di-render ke HTML
- [ ] CSRF: verifikasi semua form pakai CSRF token
- [ ] Broken Authentication: test session management, token expiry
- [ ] Broken Access Control: test akses role-based (403 untuk unauthorized)
- [ ] Sensitive Data Exposure: cek tidak ada credential di response/log
- [ ] Security Misconfiguration: .env tidak exposed, APP_DEBUG=false
- [ ] Insecure Direct Object Reference: test ID manipulation di URL
- [ ] File Upload Security: test upload file berbahaya
- [ ] Rate Limiting: test brute force login (3x lockout)

## Acceptance Criteria
- [ ] Semua item checklist passed
- [ ] Security report didokumentasikan
- [ ] Critical/High vulnerabilities diperbaiki sebelum go-live" \
"$BACKEND_USER" \
"testing,security,fullstack,priority: high" \
"$MS5"

create_issue \
"[FULLSTACK] User Acceptance Testing (UAT) dengan Stakeholder" \
"## Deskripsi
Pelaksanaan UAT bersama stakeholder perpustakaan.

## Sesi UAT
- [ ] Sesi 1: Auth, Dashboard, Manajemen Buku & Anggota
- [ ] Sesi 2: Sirkulasi, Denda, E-Resources, OPAC
- [ ] Sesi 3: Laporan, User Management, Final feedback

## Participants
- Syahid Rohidin (Kepala Perpustakaan)
- Yayan Skakmat (Staf Administrasi)

## Acceptance Criteria
- [ ] Maksimal 5 minor bug ditemukan saat UAT
- [ ] Semua critical bug diperbaiki sebelum sign-off
- [ ] UAT report dibuat dan ditandatangani
- [ ] BAST (Berita Acara Serah Terima) disiapkan

## Referensi
- SRS_SIPERPUS_LENGKAP.md Section 9.4 & Section 8" \
"$BACKEND_USER" \
"testing,fullstack,priority: high" \
"$MS5"

create_issue \
"[FULLSTACK] Performance & Load Testing (50 Concurrent Users)" \
"## Deskripsi
Performance testing dan load testing untuk memastikan sistem handle 50 concurrent users.

## Scenario Load Test
- [ ] 50 concurrent users pencarian OPAC
- [ ] 20 concurrent users proses peminjaman
- [ ] 10 concurrent users generate laporan
- [ ] Duration: 30 menit

## Target Metrics
| Metric | Target |
|--------|--------|
| Response pencarian | < 2 detik (P95) |
| Response laporan | < 5 detik |
| API response | < 500ms |
| Frontend load | < 3 detik |
| Error rate | < 1% |

## Acceptance Criteria
- [ ] Semua target metrics terpenuhi
- [ ] Tidak ada memory leak
- [ ] Performance report didokumentasikan" \
"$BACKEND_USER" \
"testing,fullstack,priority: medium" \
"$MS5"

# ── M6: Deployment & Training ─────────────────────────────────────────────────
MS6="M6: Deployment & Training"

create_issue \
"[BE] Setup Production Environment & Deployment" \
"## Deskripsi
Persiapan dan eksekusi deployment ke production server.

## Checklist Deployment
- [ ] Setup server (Ubuntu 22.04 + Nginx + PHP 8.1 + MySQL 8.0)
- [ ] Clone repository & install dependencies
- [ ] Konfigurasi .env production (APP_ENV=production, APP_DEBUG=false)
- [ ] Run migrations production (php artisan migrate --force)
- [ ] Run seeders initial data
- [ ] Setup storage link
- [ ] Setup SSL certificate (HTTPS)
- [ ] Konfigurasi backup otomatis (daily)
- [ ] Performance optimization: config:cache, route:cache, view:cache

## Acceptance Criteria
- [ ] Aplikasi accessible via HTTPS
- [ ] APP_DEBUG=false di production
- [ ] Backup berjalan otomatis
- [ ] SSL certificate valid" \
"$BACKEND_USER" \
"feature,backend,priority: high" \
"$MS6"

create_issue \
"[DOCS] Dokumentasi Teknis: API Docs & README Lengkap" \
"## Deskripsi
Buat dokumentasi teknis lengkap: API documentation (Swagger/OpenAPI), README, dan user manual.

## Dokumen yang Harus Dibuat
- [ ] README.md (instalasi, konfigurasi, cara jalankan)
- [ ] API Documentation (Swagger/OpenAPI 3.0) — semua endpoint dengan parameter, request body, response
- [ ] User Manual untuk Staf Perpustakaan
- [ ] Technical Architecture Document (singkat)

## Acceptance Criteria
- [ ] README cukup untuk developer baru setup tanpa bantuan
- [ ] Semua endpoint terdokumentasi di Swagger
- [ ] User manual mudah dipahami non-technical user
- [ ] Dokumen di-commit ke repository" \
"$BACKEND_USER" \
"documentation,priority: medium" \
"$MS6"

create_issue \
"[FULLSTACK] Finalisasi & Go-Live Checklist" \
"## Deskripsi
Checklist final sebelum SIPERPUS resmi go-live dan diserahterimakan ke klien.

## Go-Live Checklist
### Teknis
- [ ] Semua bug dari UAT sudah diperbaiki
- [ ] Security check passed
- [ ] Performance test passed
- [ ] Backup system aktif & SSL aktif

### Dokumentasi
- [ ] SRS final di-sign / UAT report di-sign
- [ ] API docs & User manual selesai
- [ ] BAST disiapkan

### Training
- [ ] Sesi training staf perpustakaan (2x 2 jam)
- [ ] Q&A session & handover admin credentials

### Repository
- [ ] Kode bersih (tidak ada debug print / console.log)
- [ ] .env.example terupdate
- [ ] Tag release v1.0.0 dibuat

## Acceptance Criteria
- [ ] Semua item checklist selesai
- [ ] BAST ditandatangani Kepala Perpustakaan
- [ ] Release tag v1.0.0 di-push ke GitHub" \
"$BACKEND_USER" \
"documentation,fullstack,priority: high" \
"$MS6"

# =============================================================================
# 4/5  PROJECT BOARD
# =============================================================================
log_section "4/5  Membuat GitHub Project Board"

PROJECT_EXISTS=$(gh project list --owner "$FRONTEND_USER" --format json 2>/dev/null \
  | grep -c "\"$PROJECT_NAME\"" || true)

if [[ "$PROJECT_EXISTS" -gt 0 ]]; then
  log_warn "Project '$PROJECT_NAME' sudah ada — diskip"
else
  PROJECT_URL=$(gh project create \
    --owner "$FRONTEND_USER" \
    --title "$PROJECT_NAME" \
    --format json 2>/dev/null \
    | grep -o '"url":"[^"]*"' | cut -d'"' -f4 || true)

  if [[ -n "$PROJECT_URL" ]]; then
    log_success "Project board '$PROJECT_NAME' dibuat: $PROJECT_URL"
  else
    log_warn "Project board tidak bisa dibuat via CLI."
    log_warn "Buat manual di: https://github.com/users/$FRONTEND_USER/projects/new"
  fi
fi

# =============================================================================
# 5/5  RINGKASAN
# =============================================================================
log_section "5/5  Selesai!"

echo ""
echo -e "${GREEN}${BOLD}Setup GitHub SIPERPUS selesai!${NC}"
echo ""
echo -e "${BOLD}Yang sudah dibuat:${NC}"
echo -e "  ${CYAN}Labels    ${NC}: 28 labels"
echo -e "  ${CYAN}Milestones${NC}: 6 milestones (M1 s/d M6)"
echo -e "  ${CYAN}Issues    ${NC}: 26 issues"
echo ""
echo -e "${BOLD}Distribusi Tim:${NC}"
echo -e "  ${GREEN}Backend  (fajar1180)          ${NC}: ~14 issues"
echo -e "  ${BLUE}Frontend (ilhamalmunawar05-cpu)${NC}: ~12 issues"
echo ""
echo -e "${BOLD}Links:${NC}"
echo -e "  Repo      : https://github.com/$REPO"
echo -e "  Issues    : https://github.com/$REPO/issues"
echo -e "  Milestones: https://github.com/$REPO/milestones"
echo -e "  Projects  : https://github.com/$FRONTEND_USER?tab=projects"
echo ""
echo -e "${YELLOW}Tips selanjutnya:${NC}"
echo -e "  1. Buka Project Board, tambah kolom: Backlog | In Progress | Review | Done"
echo -e "  2. Set branch protection rule untuk 'main'"
echo -e "  3. Naming branch: feature/BE-xxx-nama atau feature/FE-xxx-nama"