# SPESIFIKASI KEBUTUHAN PERANGKAT LUNAK (SRS)
## Sistem Informasi Perpustakaan Berbasis Web

**Klien**: Universitas Kebangsaan Republik Indonesia  
**Pengembang**: Kelompok 6 – Program Studi Sistem Informasi  
**Versi**: 2.0  
**Tanggal**: 2026-06-10  
**Status**: Final

---

## 1. PENDAHULUAN

### 1.1 Tujuan Dokumen
Dokumen ini mendefisikan spesifikasi kebutuhan fungsional dan non-fungsional untuk pengembangan Sistem Informasi Perpustakaan Berbasis Web yang akan diimplementasikan di Universitas Kebangsaan Republik Indonesia.

### 1.2 Cakupan Proyek
Sistem yang akan dibangun mencakup:
- Modul autentikasi dan manajemen pengguna
- Katalog online (OPAC - Online Public Access Catalog)
- Modul sirkulasi (peminjaman & pengembalian)
- Sistem perhitungan denda otomatis
- Modul e-resources (e-book, jurnal)
- Dashboard monitoring dan laporan

### 1.3 Referensi Dokumen
| No | Dokumen | Versi | Keterangan |
|----|---------|-------|-----------|
| 1 | KAK Perpustakaan UKRI | 1.0 | Kerangka Acuan Kerja |
| 2 | Notulen Wawancara | 1.0 | Hasil analisis kebutuhan |
| 3 | Form Observasi Proses Bisnis | 1.0 | Dokumentasi As-Is |
| 4 | Daftar Hadir Kegiatan | 1.0 | Bukti keterlibatan stakeholder |
| 5 | ERD_MERMAID.md | 1.0 | Entity Relationship Diagram |
| 6 | STRUKTUR_DATABASE.md | 1.0 | Database Structure Detail |

---

## 2. GAMBARAN UMUM SISTEM

### 2.1 Konteks Sistem
Perpustakaan Universitas Kebangsaan Republik Indonesia saat ini masih menggunakan sistem manual dalam mengelola koleksi buku, peminjaman, dan pengembalian. Hal ini menyebabkan:
- Risiko kehilangan data historis
- Kesalahan perhitungan denda
- Pencarian koleksi tidak efisien
- Laporan membutuhkan waktu lama
- Sulitnya tracking riwayat peminjaman

**Solusi**: Sistem Informasi Perpustakaan Berbasis Web yang terintegrasi dan otomatis.

### 2.2 Stakeholder Utama
| Stakeholder | Peran | Kebutuhan |
|-------------|------|----------|
| Kepala Perpustakaan | Validasi & approval | Laporan monitoring, kontrol akses, statistik |
| Staf Perpustakaan | Operator | Kemudahan pencatatan, filter cepat, UI intuitif |
| Mahasiswa/Dosen | Member/User | OPAC user-friendly, akses e-resources, tracking pinjaman |
| Admin IT | Support | Backup, security, monitoring, maintenance |

### 2.3 Aktor Sistem
1. **Admin** → Mengelola data buku, anggota, laporan, dan sistem
2. **Pustakawan** → Mengelola sirkulasi (pinjam/kembali), denda
3. **Anggota (Member)** → Pencarian buku, riwayat peminjaman, e-resources

### 2.4 Batasan & Asumsi
**Batasan:**
- Hanya mendukung role: Admin, Pustakawan, Member
- Pembayaran denda via offline (tunai/cheque)
- Tidak terintegrasi langsung dengan sistem akademik (sync manual/import)
- Max file upload: 100MB per file
- Concurrent users: minimal 50 user

**Asumsi:**
- Koneksi internet stabil (minimal 1 Mbps)
- Member sudah terdaftar di sistem akademik
- Perpustakaan buka 24/7 (akses sistem)
- Server tersedia di local atau cloud infrastructure

---

## 3. KEBUTUHAN FUNGSIONAL

### 3.1 Modul Autentikasi & Manajemen Pengguna

#### UC-001: Login Sistem
**Aktor**: Semua pengguna (Admin, Pustakawan, Member)  
**Precondition**: User terdaftar di database  
**Main Flow**:
1. User membuka halaman login (`/login`)
2. User memasukkan email & password
3. Sistem validasi kredensial (bcrypt comparison)
4. Jika valid → Set session (30 menit timeout) & redirect ke dashboard
5. Jika invalid → Tampilkan pesan error (max 3x attempts = lock 15 menit)
6. Sistem log login attempt (untuk audit trail)

**Postcondition**: 
- User berhasil masuk sesuai role-nya
- Session created dengan security token
- Login event logged

**Validasi**:
- Email format valid
- Password tidak kosong
- Case-sensitive password

#### UC-002: Logout
**Aktor**: Semua pengguna  
**Main Flow**:
1. User klik tombol logout
2. Sistem destroy session & clear cookies
3. Redirect ke halaman login
4. Log logout event

#### UC-003: Reset Password
**Aktor**: User yang lupa password  
**Flow**:
1. User klik "Lupa Password" di login page
2. Input email → sistem send reset link via email
3. Link valid 24 jam
4. User buat password baru
5. Sistem validasi strength & update password

#### UC-004: Manajemen Data Pengguna (Admin Only)
**Aktor**: Admin  
**Fitur**:
- CRUD pengguna (Create, Read, Update, Delete)
- Assign role (Admin, Pustakawan, Member)
- Aktivasi/deaktivasi akun
- Reset password (force reset)
- View login history & activity

**Validasi**:
- Email harus unik
- Password minimal 8 karakter (upper, lower, number, special char)
- Role hanya admin yang bisa assign
- Tidak boleh delete user yang masih punya transaksi aktif

---

### 3.2 Modul Data Anggota

#### UC-005: Manajemen Data Anggota (Admin & Pustakawan)
**Field Anggota**:
- NIM/NIDN (Nomor Identitas Mahasiswa/Dosen) - UK
- Nama lengkap
- Program Studi/Fakultas
- No. HP
- Alamat
- Status keanggotaan (aktif/non-aktif/suspend)
- Tanggal daftar
- Tanggal kadaluarsa (jika ada)

**Fitur**:
- CRUD data anggota (dengan validation)
- Pencarian anggota by NIM/nama (with pagination)
- Export data anggota (PDF/Excel)
- Suspend anggota (if tunggakan denda > limit)
- Bulk import dari CSV

**Validasi**:
- NIM/NIDN tidak boleh duplikat
- Status aktif hanya jika tidak ada tunggakan
- No HP format valid (11-13 digit Indonesia)
- Nama tidak boleh kosong

**Acceptance Criteria**:
- [ ] Bisa CRUD data anggota dengan form validation
- [ ] Pencarian response < 2 detik
- [ ] Export PDF/Excel generate < 5 detik
- [ ] Bulk import max 1000 records per file

---

### 3.3 Modul Data Buku (Katalog)

#### UC-006: Manajemen Data Buku (Admin)
**Field Buku**:
- ISBN (unik) - Format valid: 10 atau 13 digit
- Judul
- Penulis
- Penerbit
- Tahun publikasi
- Kategori/Genre (FK)
- Lokasi rak (format: A-01-03)
- Stok total & stok tersedia
- Kondisi fisik (baik/rusak ringan/rusak berat)
- Upload cover image (optional)

**Fitur**:
- CRUD data buku
- Bulk import dari Excel
- Upload cover buku (JPG/PNG, max 2MB)
- Update stok otomatis saat peminjaman/pengembalian (via trigger)
- Pencarian duplikat ISBN (prevent duplicate)
- Automatic stok availability check

**Validasi**:
- ISBN format valid (10 atau 13 digit)
- Stok tidak boleh negatif
- Kategori harus ada di master kategori
- Judul tidak boleh kosong
- Tahun publikasi reasonable (1900-2100)

**Acceptance Criteria**:
- [ ] CRUD berjalan dengan validation
- [ ] Bulk import 500 records < 10 detik
- [ ] Stok update otomatis saat pinjam/kembali
- [ ] ISBN duplikat detection akurat

#### UC-007: Manajemen Kategori Buku
**Fitur**:
- Daftar kategori standar (Fiksi, Non-Fiksi, Referensi, Teknologi, dll)
- CRUD kategori
- Soft delete untuk kategori yang sudah digunakan
- Set default durasi peminjaman per kategori (override 14 hari default)

**Validasi**:
- Nama kategori unik
- Durasi default positif integer

---

### 3.4 Modul OPAC (Online Public Access Catalog)

#### UC-008: Pencarian Buku (Public Access)
**Aktor**: Semua user (Member, Admin, Pustakawan)  
**Fitur Pencarian**:
- By judul (LIKE search, case-insensitive)
- By penulis
- By kategori (dropdown filter)
- By tahun publikasi (range picker: dari - sampai)
- By ISBN (exact match)
- Advanced search (kombinasi filter)
- Save search preferences (optional)

**Hasil Pencarian**:
- List buku dengan pagination (10 per halaman, configurable)
- Tampilkan: Judul, Penulis, Kategori, Stok tersedia, Status
- Sort by: Judul (A-Z), Tahun (terbaru/terlama), Popularitas (most borrowed)
- Highlight stock status: Available (green) / Limited (yellow) / Out of Stock (red)

**Validasi**:
- Query tidak boleh kosong (min 1 karakter)
- Max 2 detik search response time (via database indexing)
- Min 1 filter harus dipilih untuk Advanced Search

**Acceptance Criteria**:
- [ ] Pencarian response < 2 detik untuk 10.000 records
- [ ] Sort akurat sesuai pilihan
- [ ] Pagination working correctly
- [ ] Advanced search dengan 3+ filter jalan

#### UC-009: Lihat Detail Buku
**Fitur**:
- Tampilkan cover buku (if uploaded)
- Metadata lengkap (ISBN, penerbit, tahun, dll)
- Daftar peminjam saat ini
- Rata-rata rating dari member (optional)
- Tombol "Request peminjaman" jika member login
- Related books (buku dari kategori/penulis sama)
- Review/comment dari member (optional)

**Validasi**:
- Buku harus ada di database
- Rating hanya dari member yang pernah pinjam
- Comment harus appropriate (moderation optional)

---

### 3.5 Modul Sirkulasi (Peminjaman & Pengembalian)

#### UC-010: Peminjaman Buku
**Aktor**: Pustakawan (operator meja sirkulasi)  
**Precondition**:
- Member aktif & tidak suspend
- Buku tersedia (stok > 0)
- Member belum mencapai limit peminjaman (max 5 buku)
- Member tidak punya tunggakan denda > limit

**Main Flow**:
1. Pustakawan input NIM anggota atau scan card
2. Sistem validate status member & denda tertunggak
3. Sistem cek limit peminjaman (max 5 active loans)
4. Pustakawan pilih buku atau scan barcode
5. Sistem validasi:
   - Buku stok > 0?
   - Member belum pinjam buku yang sama?
   - Limit loan items < 5?
6. Sistem hitung due date:
   - Default: due_date = loan_date + 14 hari
   - Kategori buku dapat override durasi (misal: referensi hanya 3 hari)
7. Create transaksi peminjaman & loan items
8. Update stok buku (trigger auto-execute)
9. Cetak bukti peminjaman (struk + QR code)
10. Notify member (optional: email/SMS)

**Postcondition**:
- LOANS & LOAN_ITEMS record created
- BOOKS.stok_tersedia -= 1
- Bukti peminjaman dicetak
- Member terima struk

**Validasi**:
- Member aktif atau suspend?
- Denda tertunggak amount?
- Stok availability?
- Limit exceeded?

**Acceptance Criteria**:
- [ ] Peminjaman process < 1 menit (end-to-end)
- [ ] Bukti cetak otomatis
- [ ] Stok update akurat
- [ ] No double-booking (same book, same member, same loan)

#### UC-011: Perpanjangan Peminjaman (Optional)
**Aktor**: Member atau Pustakawan  
**Condition**:
- Peminjaman belum jatuh tempo (return_date < due_date)
- Belum ada pemesanan buku dari member lain
- Max 1x perpanjangan per loan
- No outstanding fines

**Flow**:
1. Member/Pustakawan request perpanjangan
2. Sistem validasi kondisi
3. Update due_date += 7 hari
4. Create log extension history
5. Notify member (optional)

**Acceptance Criteria**:
- [ ] Extension logic validated correctly
- [ ] Due date updated properly
- [ ] Log recorded for audit

#### UC-012: Pengembalian Buku
**Aktor**: Pustakawan  
**Precondition**: 
- Ada transaksi peminjaman aktif (LOANS.status = 'active')

**Main Flow**:
1. Pustakawan input/scan transaksi peminjaman (loan_id) atau member NIM
2. Sistem tampilkan active loans member (list)
3. Pustakawan pilih transaksi & scan buku
4. Sistem validate kondisi pengembalian:
   - Buku apa yang dikembalikan?
   - Kondisi: Normal/Rusak ringan/Rusak berat/Hilang?
5. Sistem validasi return_date vs due_date:
   - IF return_date ≤ due_date → On-time, denda = 0
   - IF return_date > due_date → Late return
6. **Perhitungan Denda Otomatis** (via stored procedure):
   ```
   late_days = DATEDIFF(return_date, due_date)
   daily_rate = 5000 (Rp per hari, configurable)
   fine_amount = late_days × daily_rate
   max_fine = 500000 (cap, optional)
   ```
7. Sistem create RETURNS record dengan late_days & fine_amount
8. Trigger auto-create FINES record (if late_days > 0)
9. Update stok buku (stok_tersedia += 1) via trigger
10. Set LOANS.status = "returned"
11. Cetak bukti pengembalian
12. IF fine > 0 → Show payment info & due date

**Postcondition**:
- RETURNS record created
- FINES record created (if late)
- BOOKS.stok_tersedia += 1
- LOANS.status = "returned"
- Bukti pengembalian dicetak

**Validation**:
- Loan exists & active?
- Return date format valid?
- Book condition selected?

**Acceptance Criteria**:
- [ ] Return process < 1 menit
- [ ] Fine calculation accurate
- [ ] Stok recount correct
- [ ] Bukti cetak otomatis

---

### 3.6 Modul Denda

#### UC-013: Manajemen Denda (Admin & Pustakawan)
**Fitur**:
- List denda belum lunas (real-time)
- Filter by: member, periode, status (unpaid/partial/paid)
- Lihat detail denda (transaksi peminjaman → return → fine)
- Suspend member otomatis jika denda > limit
- Search member by NIM untuk cek denda

**Field Denda**:
- Return ID (FK)
- Member ID (derived)
- Jumlah hari terlambat
- Nominal denda
- Status (unpaid/partial/paid)
- Tanggal jatuh tempo pembayaran (return_date + 7 hari default)
- Created at & Updated at

**Fitur Lanjutan**:
- Export denda report (PDF/Excel)
- Remind member (via email/SMS)
- Amnesty denda (admin only, dengan approval)
- Denda history log

#### UC-014: Pembayaran Denda
**Aktor**: Pustakawan (recording payment)  
**Precondition**: 
- Fine record exists dengan status unpaid/partial

**Flow**:
1. Member datang & bayar tunai/cheque
2. Pustakawan cari denda member (by NIM)
3. Tampilkan list outstanding fines
4. Pustakawan select fine(s) & input nominal bayar
5. Sistem validasi:
   - Nominal bayar > 0?
   - Nominal bayar ≤ remaining balance?
6. Create FINE_PAYMENTS record
7. Update FINES.status:
   - IF total_paid = nominal_denda → "paid"
   - IF total_paid < nominal_denda → "partial"
8. IF status berubah menjadi "paid" → Update MEMBERS.status = "aktif" (un-suspend)
9. Cetak kwitansi pembayaran
10. Notify member (optional)

**Field Pembayaran**:
- Fine ID (FK)
- Nominal bayar
- Metode pembayaran (tunai/cheque/transfer)
- Tanggal pembayaran
- No. Referensi (untuk cheque/transfer)
- Catatan tambahan
- Recorded by (user_id)
- Created at

**Validation**:
- Fine exists?
- Payment amount valid?
- Member status?

**Acceptance Criteria**:
- [ ] Payment recorded correctly
- [ ] Fine status updated
- [ ] Kwitansi print otomatis
- [ ] Member un-suspended otomatis saat fine paid

---

### 3.7 Modul E-Resources

#### UC-015: Upload E-Resources (Admin & Pustakawan)
**Fitur**:
- Upload file (PDF, ePub, Mobi, DOC, PPTX)
- Input metadata: Judul, Pengarang, Kategori, Deskripsi, Tags
- Akses control: Public / Member Only / Admin Only
- Max file size: 100 MB per file
- Virus scan (optional, via ClamAV)
- Thumbnail generation (for preview)

**Flow**:
1. Admin/Pustakawan klik "Upload E-Resource"
2. Pilih file & isi metadata form
3. Sistem validate file:
   - Format allowed?
   - Size ≤ 100MB?
   - No virus?
4. Sistem process file:
   - Generate thumbnail
   - Extract metadata (title, author dari file, if available)
   - Generate download token/URL
5. Simpan file ke storage (local disk atau cloud: S3/GCS)
6. Create ERESOURCES record di database
7. Set permission akses
8. Index untuk search (elasticsearch optional)

**Field E-Resource**:
- Judul
- Pengarang
- Kategori
- Deskripsi
- Tipe file (pdf, epub, mobi, doc, link)
- File path (local) atau URL (external link)
- Uploaded by (user_id)
- Permission access (enum)
- Download count (tracking)
- View count (tracking)
- Created at & Updated at

**Validation**:
- File format whitelist: pdf, epub, mobi, doc, pptx, txt
- File size ≤ 100MB
- Required fields: judul, kategori
- Permission must be valid enum

#### UC-016: Pencarian & Download E-Resources
**Aktor**: Member atau higher role  
**Fitur**:
- Search e-resource (sama seperti OPAC)
- Filter by tipe file (PDF, ePub, dll)
- Filter by kategori
- Preview inline (if support: PDF via PDF.js, ePub via ReadEpub)
- Download dengan tracking
- Recent downloads list
- Most popular e-resources

**Access Control**:
- Public resources: semua bisa akses
- Member Only: hanya login member & above
- Admin Only: hanya admin & pustakawan

**Validation**:
- Member harus login untuk download
- Track download untuk statistik
- DRM protection (optional, via watermark)

**Acceptance Criteria**:
- [ ] Search < 2 detik
- [ ] File download reliable
- [ ] Permission check working
- [ ] Download tracking accurate

---

### 3.8 Modul Dashboard & Laporan

#### UC-017: Dashboard Admin
**Widgets/KPI**:

1. **Statistik Koleksi**:
   - Total buku di sistem
   - Total kategori
   - Buku terpopuler (top 5 most borrowed)
   - Buku dengan stok rendah (< 3)
   - Perbandingan stok vs peminjaman

2. **Statistik Keanggotaan**:
   - Total member aktif
   - Member baru bulan ini
   - Member dengan tunggakan denda (count & amount)
   - Member suspend count

3. **Statistik Sirkulasi** (real-time):
   - Total peminjaman bulan ini
   - Total pengembalian tepat waktu vs terlambat (%)
   - Rata-rata keterlambatan (hari)
   - Total denda tertagih vs tertunggak

4. **Chart/Grafik** (interactive):
   - Bar chart: Top 5 buku paling sering dipinjam
   - Pie chart: Distribusi koleksi per kategori
   - Line chart: Trend peminjaman per bulan (6 bulan)
   - Line chart: Trend denda per bulan

5. **Quick Actions**:
   - Recent loans (last 5)
   - Overdue loans (today)
   - Outstanding fines (top 5)

**Performance Target**:
- Dashboard load < 3 detik
- Chart render < 2 detik

#### UC-018: Dashboard Pustakawan
**Widgets** (limited vs Admin):
- Transaksi hari ini (pinjam/kembali)
- Outstanding fines today
- Member dengan tunggakan
- Recent returns
- Stok barang yang mulai habis

#### UC-019: Dashboard Member
**Features**:
- My active loans (current borrowed books)
- Loan history (past 20 loans)
- My fines (paid & unpaid)
- Due dates countdown
- Fine payment history

#### UC-020: Laporan (Admin & Pustakawan)
**Tipe Laporan**:

1. **Laporan Sirkulasi**:
   - Filter: Periode (date range)
   - Output: List transaksi pinjam/kembali, total transaksi, top borrowers
   - Export: PDF, Excel, CSV
   - Pagination support

2. **Laporan Denda**:
   - Filter: Status (Paid/Unpaid/Partial), member, periode
   - Output: Detail denda, total tertagih, total terbayar, outstanding balance
   - Export: PDF, Excel
   - Summary: denda tertinggi, total tunggakan

3. **Laporan Koleksi**:
   - Filter: Kategori, status stok, kondisi
   - Output: List buku dengan metadata lengkap, stok tersedia
   - Export: PDF, Excel
   - Summary: total koleksi per kategori, stok analysis

4. **Laporan Keanggotaan**:
   - Filter: Status (aktif/non-aktif/suspend), prodi, periode daftar
   - Output: Data member, riwayat peminjaman, outstanding fines
   - Export: PDF, Excel

5. **Custom Report** (untuk admin advanced):
   - Report builder UI
   - Select table, columns, filters
   - Schedule report (daily/weekly/monthly)
   - Email delivery

**Features**:
- Scheduled report (auto-generate & email laporan bulanan)
- Custom report builder
- Report template (standard & custom)
- Multi-format export (PDF, Excel, CSV, JSON)

**Acceptance Criteria**:
- [ ] Report generate < 10 detik
- [ ] Export format correct
- [ ] Filter logic akurat
- [ ] Schedule working

---

## 4. KEBUTUHAN NON-FUNGSIONAL

### 4.1 Keamanan (Security)

| Aspek | Requirement | Implementasi |
|-------|-------------|--------------|
| **Authentication** | Login dengan email & password + MFA (optional) | bcrypt hashing (salt rounds 12), session timeout 30 menit, JWT tokens |
| **Authorization** | Role-based access control (RBAC) | 3 role: Admin, Pustakawan, Member + permissions matrix |
| **Data Protection** | Enkripsi data sensitif | TLS 1.3 untuk transmisi, bcrypt untuk password, AES-256 untuk sensitive fields |
| **Input Validation** | Validasi semua input user | Server-side & client-side validation, whitelist approach |
| **SQL Injection Prevention** | Prepared statement / ORM | Gunakan Parameterized Query atau Doctrine/Eloquent |
| **XSS Prevention** | Sanitasi output | HTML entity encoding, CSP header |
| **CSRF Protection** | Token CSRF | Setiap form include CSRF token, SameSite cookie |
| **Backup** | Backup database berkala | Daily backup, versioning 7 hari terakhir, off-site backup |
| **Password Policy** | Strong password requirement | Min 8 char, mixed case, numbers, special chars, history (can't reuse 3 last) |
| **Account Lockout** | Prevent brute force | Lock 15 menit setelah 3 failed attempts |
| **Audit Trail** | Log semua aktivitas penting | audit_log table, immutable logging |
| **API Security** | Secure API communication | Rate limiting, API key validation, request signing |

### 4.2 Kinerja (Performance)

| Metric | Target | Cara Pencapaian |
|--------|--------|-----------------|
| **Response Time Pencarian** | < 2 detik | Database indexing (judul, penulis, ISBN), query optimization |
| **Response Time Laporan** | < 5 detik | Materialized views, caching, query optimization |
| **Pagination List** | 10-50 items/halaman | Server-side pagination, cursor-based pagination |
| **Concurrent Users** | ≥ 50 user | Load balancing, connection pooling, Redis caching |
| **Uptime** | 99% | Monitoring, disaster recovery, redundancy |
| **Data Size Limit** | Max 500MB transaction/hari | Log cleanup, archive old data, data partitioning |
| **Cache Layer** | Redis for session & frequently accessed data | Cache TTL optimization |
| **Database Query** | < 200ms per query | Indexing, query analysis (EXPLAIN), denormalization |
| **API Response** | < 500ms | Response caching, async processing for heavy operations |
| **Front-end Load** | < 3 detik | Minification, compression, CDN, lazy loading |

**Optimization Techniques**:
- Database indexing (composite indexes)
- Query optimization (avoid N+1, use joins efficiently)
- Caching strategy (Redis, HTTP caching, app-level caching)
- Async processing (queue jobs, background workers)
- Content delivery (minification, compression, CDN)
- Load balancing (horizontal scaling)

### 4.3 Ketersediaan & Reliabilitas (Availability & Reliability)

| Requirement | Detail |
|-------------|--------|
| **Availability** | 24/7 akses web (uptime 99% = max 3.6 jam downtime/bulan) |
| **Disaster Recovery** | RPO: 1 jam (data loss tolerance), RTO: 30 menit (recovery time) |
| **Data Integrity** | ACID compliance, transaction rollback support, referential integrity |
| **Audit Trail** | Log semua transaksi penting (user, waktu, aksi, IP, changes) |
| **Error Handling** | Graceful error page, error logging, alerting mechanism |
| **Failover** | Automatic failover untuk database & app server (if applicable) |
| **Health Check** | Monitoring critical services (DB, API, file storage) |
| **Alerting** | Alert notification untuk admin (email/SMS/Slack) |
| **Recovery Procedure** | Documented & tested recovery procedures |

### 4.4 Usability (User Experience)

| Aspek | Requirement |
|------|-------------|
| **UI/UX Design** | Simple, clean, intuitive navigation (Material Design or Bootstrap) |
| **Mobile Responsiveness** | Support mobile (iOS/Android) via responsive design, min viewport 320px |
| **Language** | Bahasa Indonesia (with English as fallback) |
| **Accessibility** | WCAG 2.1 AA compliance (font size adjustable, color contrast ≥ 4.5:1) |
| **Documentation** | User manual, admin guide (PDF & online), API docs (Swagger/OpenAPI) |
| **Training** | Training session untuk staff perpustakaan (2x 2 jam session) |
| **Feedback** | Contact form, FAQ, help desk integration (optional) |
| **Performance Feedback** | Loading indicator, progress bar untuk long operations |

### 4.5 Maintainability (System Maintenance)

| Aspek | Requirement |
|-------|-------------|
| **Code Quality** | Clean code (SOLID principles), follows PSR-12 (PHP) or similar |
| **Documentation** | Code comments (PHPDoc), README, architecture docs |
| **Version Control** | Git with branching strategy (Git Flow: main, develop, feature branches) |
| **Deployment** | CI/CD pipeline dengan automated test & deployment (GitHub Actions / Jenkins) |
| **Monitoring** | ELK stack atau Sentry untuk error tracking, CloudWatch/Prometheus untuk metrics |
| **Logging** | Structured logging (JSON format), log rotation, centralized logging |
| **Testing** | Unit test (≥80%), Integration test, E2E test (Selenium/Cypress) |
| **Documentation** | API documentation (OpenAPI/Swagger), deployment guide, troubleshooting guide |

### 4.6 Scalability (Skalabilitas)

| Aspek | Strategy |
|-------|----------|
| **Horizontal Scaling** | Stateless application design, shared session storage (Redis) |
| **Database Scaling** | Read replicas for reporting, connection pooling |
| **Caching** | Distributed caching (Redis), cache invalidation strategy |
| **Microservices Ready** | Modular architecture, API-first design (if future scaling needed) |
| **Cloud Infrastructure** | Container support (Docker), orchestration ready (Kubernetes-ready) |

---

## 5. USE CASE DIAGRAM

```
System: SIPERPUS

┌─────────────────────────────────────────────────────────────┐
│                      ADMIN (Full Access)                     │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  • Manage Users (Create, Update, Delete, Assign Role)       │
│  • Manage Books (CRUD, Import, Categories)                  │
│  • Manage Members (CRUD, Suspend, Export)                   │
│  • Manage E-Resources (Upload, Delete, Permissions)         │
│  • View Dashboard (All widgets & analytics)                 │
│  • Generate Reports (All types, scheduling)                 │
│  • Manage System (Settings, Backup, Logs)                   │
│  • User Access History (Audit log)                          │
│                                                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                  PUSTAKAWAN (Operational)                    │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  • Borrow Books (Create transactions)                        │
│  • Return Books (Create return, calculate fines)            │
│  • Manage Fine Payment (Record payments)                     │
│  • View Dashboard (Limited: today's transactions)            │
│  • Generate Reports (Limited: circulation, fines)            │
│  • Search Catalog (OPAC access)                              │
│  • View Member Info (For operational purpose)               │
│                                                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                 MEMBER (Self-Service)                        │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  • Login / Logout                                            │
│  • Search Catalog (OPAC)                                     │
│  • View Book Details                                         │
│  • View My Loans (Current & history)                         │
│  • View My Fines (Unpaid, paid history)                      │
│  • Download E-Resources (If permission allowed)              │
│  • Manage Profile (Change password, contact info)            │
│  • Request Perpanjangan (Optional)                           │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## 6. FLOW DIAGRAM PROSES BISNIS (To-Be)

### 6.1 Flow Peminjaman Buku

```
START
  │
  ├─→ Pustakawan Login
  │
  ├─→ Input NIM Member
  │
  ├─→ SYSTEM: Validasi member
  │    ├─ Status aktif? 
  │    ├─ Denda tunggakan?
  │    ├─ Limit pinjaman?
  │    └─→ If VALID, proceed; If INVALID, show error & exit
  │
  ├─→ Pustakawan Pilih Buku (manual atau scan)
  │
  ├─→ SYSTEM: Validasi buku
  │    ├─ Stok > 0?
  │    ├─ Member belum pinjam sama?
  │    └─→ If VALID, proceed; If INVALID, show error
  │
  ├─→ SYSTEM: Hitung due_date (loan_date + duration)
  │
  ├─→ SYSTEM: Create LOANS & LOAN_ITEMS record
  │
  ├─→ TRIGGER: Update BOOKS.stok_tersedia -= 1
  │
  ├─→ SYSTEM: Generate bukti peminjaman
  │
  ├─→ Printer: Cetak struk + QR code
  │
  ├─→ Member terima struk
  │
  └─→ END (Success)
```

### 6.2 Flow Pengembalian & Perhitungan Denda

```
START
  │
  ├─→ Member datang dengan buku
  │
  ├─→ Pustakawan input/scan transaksi peminjaman (loan_id)
  │
  ├─→ SYSTEM: Tampilkan loan details
  │
  ├─→ Pustakawan input kondisi buku
  │    └─ Normal / Rusak ringan / Rusak berat / Hilang
  │
  ├─→ SYSTEM: Validasi return_date vs due_date
  │    │
  │    ├─→ IF return_date ≤ due_date
  │    │    ├─ Status: ON-TIME
  │    │    ├─ late_days: 0
  │    │    └─ fine_amount: 0
  │    │
  │    └─→ IF return_date > due_date
  │         ├─ Status: LATE RETURN
  │         ├─ late_days = DATEDIFF(return_date, due_date)
  │         ├─ daily_rate = 5000 (Rp)
  │         ├─ fine_amount = late_days × daily_rate
  │         └─ IF fine_amount > 500000 THEN fine_amount = 500000
  │
  ├─→ SYSTEM: Create RETURNS record
  │
  ├─→ TRIGGER: IF late_days > 0 THEN create FINES record
  │
  ├─→ TRIGGER: Update BOOKS.stok_tersedia += 1
  │
  ├─→ SYSTEM: Update LOANS.status = "returned"
  │
  ├─→ SYSTEM: Generate bukti pengembalian
  │
  ├─→ Printer: Cetak struk pengembalian
  │
  ├─→ IF fine_amount > 0
  │    └─ Display: "Denda Rp X, jatuh tempo DD/MM/YY"
  │
  ├─→ Member terima struk
  │
  └─→ END (Success)
```

---

## 7. DATA REQUIREMENT

### 7.1 Master Data
- **Master Kategori Buku**: 50+ kategori standar
- **Master Rak Lokasi**: Format A-XX-XX (area-row-col), ~500 lokasi
- **Master Denda Rate**: Rp 5.000 per hari (configurable per kategori)
- **Master Durasi Peminjaman**: Default 14 hari (customizable per kategori)
- **Master Member Status**: aktif, non-aktif, suspend
- **Master Book Condition**: baik, rusak_ringan, rusak_berat

### 7.2 Volume Data (Proyeksi 1 Tahun)
| Data | Volume | Growth/Bulan | Total Storage |
|------|--------|--------------|---------------|
| Total Buku | 10.000 | 100-500 | ~10 MB (metadata) |
| Total Member | 5.000 | 100-200 | ~5 MB |
| Peminjaman/Tahun | ~180.000 | ~15.000/bulan | ~50 MB |
| E-Resources | 500 files | 10-20 | ~50-100 GB (files) |
| Audit Log | ~500.000 records | ~40.000/bulan | ~200 MB |
| **Total** | | | **~100-150 GB** |

### 7.3 Retention Policy
| Data | Retensi | Alasan |
|------|---------|--------|
| Transaksi peminjaman | 7 tahun | Audit trail, historical analysis, legal requirement |
| Fine & Payment | 3 tahun | Legal requirement, tax |
| Audit log | 1 tahun | Security, troubleshooting |
| Temp files | 7 hari | Cleanup, storage optimization |
| E-resource download log | 6 bulan | Usage analytics |
| System logs | 3 bulan | Troubleshooting |

---

## 8. ACCEPTANCE CRITERIA

### 8.1 Functional Acceptance
- [ ] Semua 20 UC berjalan sesuai spesifikasi
- [ ] Tidak ada critical/blocker bug pada final testing
- [ ] Data integrity terjaga (no data loss atau corruption)
- [ ] All validations working correctly
- [ ] Error handling graceful
- [ ] Database triggers functioning properly

### 8.2 Non-Functional Acceptance
- [ ] Response time pencarian < 2 detik (95 percentile)
- [ ] Response time laporan < 5 detik
- [ ] Uptime 99% dalam 1 bulan production testing
- [ ] Backup berjalan otomatis (daily) & restore tested
- [ ] Security audit passed (OWASP Top 10)
- [ ] Performance test dengan 50 concurrent users passed
- [ ] API response < 500ms
- [ ] Frontend load < 3 detik

### 8.3 User Acceptance
- [ ] Kepala Perpustakaan setuju fitur memenuhi kebutuhan ✓ (UAT passed)
- [ ] Staf perpustakaan terlatih & dapat operate independently
- [ ] User documentation complete, clear, & mudah dipahami
- [ ] Training session(s) completed dengan Q&A
- [ ] UAT passed dengan max 5 minor issues (resolved)
- [ ] Go-live checklist signed off

---

## 9. TESTING PLAN

### 9.1 Unit Testing
- **Coverage**: ≥80% untuk business logic
- **Scope**: Function/method level testing
- **Tools**: PHPUnit (PHP), Jest (JavaScript)
- **Framework**: Test-Driven Development (TDD) approach

### 9.2 Integration Testing
- **Scope**: Module-to-module (Loan + Fine, OPAC + Loan)
- **Database**: Test dengan replica database
- **API**: Test API endpoints dengan real database
- **Queue**: Test async processing (if applicable)

### 9.3 System Testing
- **Scope**: End-to-end testing untuk setiap use case
- **Data**: Realistic data volume (5.000 member, 10.000 books)
- **Scenarios**: Happy path + error scenarios
- **Regression**: Check existing features after changes

### 9.4 User Acceptance Testing (UAT)
- **Duration**: 2-3 minggu
- **Sessions**: 2-3 sesi testing
- **Participants**: Kepala Perpustakaan, Staf Perpustakaan, Project Team
- **Data**: Real data from perpustakaan (masked sensitive info)
- **Sign-off**: UAT report & approval from stakeholders

### 9.5 Load Testing
- **Tool**: Apache JMeter, Locust, atau k6
- **Scenario**: 50 concurrent users, various operations mix
- **Duration**: 30 menit minimum
- **Metrics**: Response time, throughput, error rate, resource usage

### 9.6 Security Testing
- **Scope**: OWASP Top 10 vulnerabilities
- **Tools**: Burp Suite, OWASP ZAP
- **Focus**: SQL Injection, XSS, CSRF, Authentication, Authorization
- **Penetration**: Optional professional pentest

### 9.7 Performance Testing
- **Tool**: Lighthouse, GTmetrix
- **Frontend**: Page load < 3 detik, Lighthouse score ≥ 80
- **Database**: Query response < 200ms, indexing verified

---

## 10. IMPLEMENTATION TIMELINE

### 10.1 Project Phases

| Phase | Duration | Activities | Deliverables |
|-------|----------|-----------|--------------|
| **Analysis & Design** | 3 minggu | Req gathering, SRS writing, ERD, UI mockup | SRS, ERD, UI prototype |
| **Development** | 5 minggu | Backend dev, Frontend dev, API development | Source code, API docs |
| **Testing** | 2 minggu | Unit test, integration, system test, UAT | Test report, bug list |
| **Deployment & Training** | 1 minggu | Production deployment, staff training, go-live | Live system, trained staff |
| **TOTAL** | **11 minggu** | | |

### 10.2 Detailed Schedule (Recommended)

```
Week 1-3: Analysis & Design
  ├─ Week 1: Requirement gathering, stakeholder meeting
  ├─ Week 2: SRS writing, ERD design, database schema
  └─ Week 3: UI/UX mockup, API specification

Week 4-8: Development
  ├─ Week 4: Backend setup, database, API scaffolding
  ├─ Week 5-6: Core features (Auth, CRUD, OPAC)
  ├─ Week 7: Sirkulasi, Denda, E-Resources
  └─ Week 8: Dashboard, Reporting, Integration

Week 9-10: Testing
  ├─ Week 9: Unit + Integration testing, bug fixing
  └─ Week 10: UAT with stakeholders, final fixes

Week 11: Deployment & Training
  ├─ Day 1-2: Production deployment
  ├─ Day 3-4: Staff training session (2x 2 jam)
  └─ Day 5: Go-live, monitoring, support

```

### 10.3 Technology Stack Recommendation

| Layer | Technology | Reason |
|-------|-----------|--------|
| **Backend** | PHP 8.1+ Laravel 10 | Mature framework, excellent documentation, built-in security |
| | atau Node.js Express 4.x | Fast, event-driven, good for async operations |
| **Frontend** | HTML5, CSS3, Bootstrap 5 | Responsive, accessible, wide browser support |
| | Vue.js 3 atau React 18 | Interactive UI, component reusability |
| **Database** | MySQL 8.0 | Reliable, good for relational data, standard RDBMS |
| | atau PostgreSQL 14 | Advanced features, JSON support, strong ACID compliance |
| **Server** | Nginx + Ubuntu 22.04 | High performance, lightweight, stable |
| **Version Control** | Git (GitHub/GitLab) | Standard, collaborative features, CI/CD integration |
| **CI/CD** | GitHub Actions atau Jenkins | Automated testing & deployment |
| **Caching** | Redis 7.x | Session storage, cache layer, pub/sub |
| **File Storage** | AWS S3 atau local disk | E-resource file storage |
| **Monitoring** | ELK Stack atau Sentry | Error tracking, log analysis |
| **API Documentation** | OpenAPI 3.0 (Swagger) | Standard API documentation |

---

## 11. GLOSSARY

| Term | Definisi | Keterangan |
|------|----------|-----------|
| **OPAC** | Online Public Access Catalog | Layanan pencarian katalog perpustakaan online |
| **Member** | Anggota perpustakaan | Mahasiswa/Dosen yang terdaftar |
| **Loan** | Transaksi peminjaman buku | Record peminjaman dengan tanggal jatuh tempo |
| **Due Date** | Tanggal jatuh tempo pengembalian | Deadline pengembalian buku (default 14 hari) |
| **Fine** | Denda keterlambatan | Biaya per hari keterlambatan (Rp 5.000) |
| **RBAC** | Role-Based Access Control | Sistem otorisasi berbasis peran pengguna |
| **UC** | Use Case | Skenario interaksi antara user dan sistem |
| **UAT** | User Acceptance Testing | Pengujian penerimaan oleh stakeholder |
| **ERD** | Entity Relationship Diagram | Diagram hubungan antar tabel database |
| **SDD** | System Design Document | Dokumen desain sistem (ERD, UI design) |
| **API** | Application Programming Interface | Interface untuk integrasi sistem |
| **TLS** | Transport Layer Security | Protocol enkripsi komunikasi data |
| **ACID** | Atomicity, Consistency, Isolation, Durability | Property database untuk data integrity |
| **Trigger** | Database trigger | Event handler untuk perubahan database otomatis |
| **Transaction** | Database transaction | Sekumpulan operasi database yang atomic |

---

## 12. PROJECT TEAM

| Role | Nama | Tugas |
|------|------|-------|
| Project Manager | Muhammad Akmal Palqah | Koordinasi, scheduling, reporting |
| System Analyst | Rahayu Padilah | Requirement, design, documentation |
| Frontend Developer | Ilham Al Munawar | UI/UX, responsive design, frontend logic |
| Backend Developer | Muhammad Fajar Nurjaman | API, database, business logic, security |
| QA & Tester | Riphan Romadlon | Test planning, execution, bug reporting |

---

## 13. APPROVAL & SIGN-OFF

| Role | Nama | Tanda Tangan | Tanggal |
|------|------|-------------|---------|
| Kepala Perpustakaan | Syahid Rohidin | ____________ | ________ |
| Project Manager | Muhammad Akmal Palqah | ____________ | ________ |
| System Analyst | Rahayu Padilah | ____________ | ________ |
| Client Representative | - | ____________ | ________ |

---

**Dokumen SRS ini dibuat sebagai pedoman pengembangan Sistem Informasi Perpustakaan Universitas Kebangsaan Republik Indonesia dan dapat diperbarui sesuai perubahan kebutuhan dari stakeholder.**

**Versi: 2.0 | Status: Final | Tanggal: 10 Juni 2026**
