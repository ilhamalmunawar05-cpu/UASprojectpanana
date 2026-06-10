# STRUKTUR DATABASE LENGKAP
## Sistem Informasi Perpustakaan Berbasis Web

---

## Tabel: USERS
**Deskripsi**: Menyimpan informasi akun pengguna sistem

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Email user (login) |
| password_hash | VARCHAR(255) | NOT NULL | Hashed password (bcrypt) |
| name | VARCHAR(100) | NOT NULL | Nama lengkap |
| role | ENUM('admin', 'pustakawan', 'member') | NOT NULL | Peran user |
| status | ENUM('aktif', 'non_aktif', 'suspend') | NOT NULL | Status user |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan |
| updated_at | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes**: 
- PRIMARY KEY (id)
- UNIQUE KEY (email)
- INDEX (role)
- INDEX (status)

**SQL CREATE**:
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'pustakawan', 'member') NOT NULL,
    status ENUM('aktif', 'non_aktif', 'suspend') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_role (role),
    INDEX idx_status (status)
);
```

---

## Tabel: MEMBERS
**Deskripsi**: Menyimpan informasi anggota perpustakaan

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| user_id | INT | FK → users(id) | Reference ke users |
| nim_nidn | VARCHAR(20) | UNIQUE, NOT NULL | Nomor identitas |
| prodi | VARCHAR(100) | NOT NULL | Program studi |
| no_hp | VARCHAR(15) | NOT NULL | Nomor HP |
| alamat | TEXT | NOT NULL | Alamat lengkap |
| status | ENUM('aktif', 'non_aktif', 'suspend') | NOT NULL | Status membership |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu daftar |
| updated_at | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Update terakhir |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- UNIQUE KEY (nim_nidn)
- INDEX (status)
- INDEX (prodi)

**SQL CREATE**:
```sql
CREATE TABLE members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    nim_nidn VARCHAR(20) UNIQUE NOT NULL,
    prodi VARCHAR(100) NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    alamat TEXT NOT NULL,
    status ENUM('aktif', 'non_aktif', 'suspend') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_prodi (prodi)
);
```

---

## Tabel: CATEGORIES
**Deskripsi**: Master data kategori/klasifikasi buku

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| nama | VARCHAR(100) | UNIQUE, NOT NULL | Nama kategori |
| deskripsi | TEXT | | Deskripsi kategori |
| default_duration | INT | NOT NULL, DEFAULT 14 | Default durasi peminjaman (hari) |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan |

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE KEY (nama)

**SQL CREATE**:
```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) UNIQUE NOT NULL,
    deskripsi TEXT,
    default_duration INT NOT NULL DEFAULT 14,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_nama (nama)
);
```

---

## Tabel: BOOKS
**Deskripsi**: Menyimpan data koleksi buku perpustakaan

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| isbn | VARCHAR(20) | UNIQUE, NOT NULL | ISBN buku (10 atau 13 digit) |
| judul | VARCHAR(255) | NOT NULL | Judul buku |
| penulis | VARCHAR(255) | NOT NULL | Nama penulis |
| penerbit | VARCHAR(100) | NOT NULL | Nama penerbit |
| tahun_publikasi | INT | NOT NULL | Tahun terbit |
| kategori_id | INT | FK → categories(id) | Referensi kategori |
| lokasi_rak | VARCHAR(20) | | Format: A-01-03 |
| stok_total | INT | NOT NULL, DEFAULT 1 | Total stok |
| stok_tersedia | INT | NOT NULL, DEFAULT 1 | Stok tersedia |
| kondisi | ENUM('baik', 'rusak_ringan', 'rusak_berat') | NOT NULL | Kondisi fisik |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu input |
| updated_at | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Update terakhir |

**Indexes**:
- PRIMARY KEY (id)
- UNIQUE KEY (isbn)
- FOREIGN KEY (kategori_id) REFERENCES categories(id)
- INDEX (judul)
- INDEX (penulis)
- INDEX (stok_tersedia)
- INDEX (tahun_publikasi)

**SQL CREATE**:
```sql
CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    isbn VARCHAR(20) UNIQUE NOT NULL,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(255) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_publikasi INT NOT NULL,
    kategori_id INT NOT NULL,
    lokasi_rak VARCHAR(20),
    stok_total INT NOT NULL DEFAULT 1,
    stok_tersedia INT NOT NULL DEFAULT 1,
    kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat') NOT NULL DEFAULT 'baik',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES categories(id) ON DELETE RESTRICT,
    INDEX idx_judul (judul),
    INDEX idx_penulis (penulis),
    INDEX idx_stok_tersedia (stok_tersedia),
    INDEX idx_tahun_publikasi (tahun_publikasi)
);
```

---

## Tabel: LOANS
**Deskripsi**: Menyimpan transaksi peminjaman buku

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| member_id | INT | FK → members(id) | Reference ke member |
| loan_date | TIMESTAMP | NOT NULL | Tanggal peminjaman |
| due_date | TIMESTAMP | NOT NULL | Tanggal jatuh tempo |
| return_date | TIMESTAMP | NULLABLE | Tanggal pengembalian |
| status | ENUM('active', 'returned', 'overdue') | NOT NULL | Status pinjaman |
| catatan | TEXT | | Catatan tambahan |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu record |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE RESTRICT
- INDEX (member_id)
- INDEX (status)
- INDEX (due_date)

**SQL CREATE**:
```sql
CREATE TABLE loans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    member_id INT NOT NULL,
    loan_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    due_date TIMESTAMP NOT NULL,
    return_date TIMESTAMP NULL,
    status ENUM('active', 'returned', 'overdue') NOT NULL DEFAULT 'active',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE RESTRICT,
    INDEX idx_member_id (member_id),
    INDEX idx_status (status),
    INDEX idx_due_date (due_date)
);
```

---

## Tabel: LOAN_ITEMS
**Deskripsi**: Detail buku yang dipinjam dalam satu transaksi

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| loan_id | INT | FK → loans(id) | Reference ke loans |
| book_id | INT | FK → books(id) | Reference ke books |
| qty | INT | NOT NULL, DEFAULT 1 | Jumlah buku |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE CASCADE
- FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT
- UNIQUE KEY (loan_id, book_id)

**SQL CREATE**:
```sql
CREATE TABLE loan_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    loan_id INT NOT NULL,
    book_id INT NOT NULL,
    qty INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE RESTRICT,
    UNIQUE KEY uq_loan_book (loan_id, book_id)
);
```

---

## Tabel: RETURNS
**Deskripsi**: Menyimpan data pengembalian buku dan perhitungan denda

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| loan_id | INT | FK → loans(id) | Reference ke loans |
| return_date | TIMESTAMP | NOT NULL | Tanggal pengembalian |
| late_days | INT | NOT NULL, DEFAULT 0 | Jumlah hari terlambat |
| fine_amount | DECIMAL(10,2) | NOT NULL, DEFAULT 0 | Nominal denda (Rp) |
| kondisi_buku | ENUM('baik', 'rusak_ringan', 'rusak_berat', 'hilang') | NOT NULL | Kondisi saat dikembalikan |
| catatan_kondisi | TEXT | | Catatan detail kondisi |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu record |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE RESTRICT
- INDEX (loan_id)

**SQL CREATE**:
```sql
CREATE TABLE returns (
    id INT PRIMARY KEY AUTO_INCREMENT,
    loan_id INT NOT NULL UNIQUE,
    return_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    late_days INT NOT NULL DEFAULT 0,
    fine_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
    kondisi_buku ENUM('baik', 'rusak_ringan', 'rusak_berat', 'hilang') NOT NULL,
    catatan_kondisi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE RESTRICT,
    INDEX idx_loan_id (loan_id)
);
```

---

## Tabel: FINES
**Deskripsi**: Menyimpan data denda dari keterlambatan

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| return_id | INT | FK → returns(id) | Reference ke returns |
| nominal_denda | DECIMAL(10,2) | NOT NULL | Nominal total denda |
| status | ENUM('unpaid', 'partial', 'paid') | NOT NULL | Status pembayaran |
| due_payment | TIMESTAMP | | Deadline pembayaran |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu record |
| updated_at | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Update terakhir |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (return_id) REFERENCES returns(id) ON DELETE RESTRICT
- INDEX (status)
- INDEX (due_payment)

**SQL CREATE**:
```sql
CREATE TABLE fines (
    id INT PRIMARY KEY AUTO_INCREMENT,
    return_id INT NOT NULL,
    nominal_denda DECIMAL(10,2) NOT NULL,
    status ENUM('unpaid', 'partial', 'paid') NOT NULL DEFAULT 'unpaid',
    due_payment TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (return_id) REFERENCES returns(id) ON DELETE RESTRICT,
    INDEX idx_status (status),
    INDEX idx_due_payment (due_payment)
);
```

---

## Tabel: FINE_PAYMENTS
**Deskripsi**: Menyimpan rekam pembayaran denda

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| fine_id | INT | FK → fines(id) | Reference ke fines |
| nominal_bayar | DECIMAL(10,2) | NOT NULL | Jumlah uang dibayar |
| metode_pembayaran | ENUM('tunai', 'cheque', 'transfer') | NOT NULL | Metode pembayaran |
| tanggal_bayar | TIMESTAMP | NOT NULL | Waktu pembayaran |
| catatan | TEXT | | Keterangan tambahan |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu record |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (fine_id) REFERENCES fines(id) ON DELETE RESTRICT
- INDEX (fine_id)
- INDEX (tanggal_bayar)

**SQL CREATE**:
```sql
CREATE TABLE fine_payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fine_id INT NOT NULL,
    nominal_bayar DECIMAL(10,2) NOT NULL,
    metode_pembayaran ENUM('tunai', 'cheque', 'transfer') NOT NULL DEFAULT 'tunai',
    tanggal_bayar TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fine_id) REFERENCES fines(id) ON DELETE RESTRICT,
    INDEX idx_fine_id (fine_id),
    INDEX idx_tanggal_bayar (tanggal_bayar)
);
```

---

## Tabel: ERESOURCES
**Deskripsi**: Menyimpan e-book, jurnal, dan resource digital lainnya

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | INT | PK, AUTO_INCREMENT | Unique identifier |
| judul | VARCHAR(255) | NOT NULL | Judul e-resource |
| pengarang | VARCHAR(255) | | Nama pengarang |
| kategori | VARCHAR(100) | | Kategori (e-book, jurnal, dll) |
| tipe_file | ENUM('pdf', 'epub', 'mobi', 'doc', 'link') | NOT NULL | Tipe file/format |
| file_path | VARCHAR(255) | NULLABLE | Path file di server |
| url_akses | VARCHAR(255) | NULLABLE | URL akses external |
| uploaded_by | INT | FK → users(id) | User yang upload |
| permission_access | ENUM('public', 'member_only', 'admin_only') | NOT NULL | Akses permission |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu upload |
| updated_at | TIMESTAMP | ON UPDATE CURRENT_TIMESTAMP | Update terakhir |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
- INDEX (kategori)
- INDEX (permission_access)

**SQL CREATE**:
```sql
CREATE TABLE eresources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255),
    kategori VARCHAR(100),
    tipe_file ENUM('pdf', 'epub', 'mobi', 'doc', 'link') NOT NULL,
    file_path VARCHAR(255),
    url_akses VARCHAR(255),
    uploaded_by INT,
    permission_access ENUM('public', 'member_only', 'admin_only') NOT NULL DEFAULT 'member_only',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_kategori (kategori),
    INDEX idx_permission_access (permission_access)
);
```

---

## Tabel: AUDIT_LOG (Optional)
**Deskripsi**: Menyimpan log semua aktivitas penting untuk compliance

| Column | Type | Constraint | Deskripsi |
|--------|------|-----------|-----------|
| id | BIGINT | PK, AUTO_INCREMENT | Unique identifier |
| user_id | INT | FK → users(id) | User yang melakukan aksi |
| action | VARCHAR(100) | NOT NULL | Aksi (create, update, delete, login) |
| table_name | VARCHAR(50) | NOT NULL | Nama tabel |
| record_id | INT | | ID record yang diubah |
| old_value | JSON | NULLABLE | Nilai lama |
| new_value | JSON | | Nilai baru |
| ip_address | VARCHAR(45) | | IP address user |
| timestamp | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Waktu aksi |

**Indexes**:
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
- INDEX (timestamp)
- INDEX (action)
- INDEX (table_name)

**SQL CREATE**:
```sql
CREATE TABLE audit_log (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50) NOT NULL,
    record_id INT,
    old_value JSON,
    new_value JSON,
    ip_address VARCHAR(45),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_timestamp (timestamp),
    INDEX idx_action (action),
    INDEX idx_table_name (table_name)
);
```

---

## Database Summary

| Tabel | Jumlah Kolom | Tujuan |
|-------|--------------|--------|
| USERS | 8 | User account management |
| MEMBERS | 9 | Member information |
| CATEGORIES | 4 | Book classification |
| BOOKS | 13 | Book collection |
| LOANS | 8 | Loan transactions |
| LOAN_ITEMS | 5 | Loan details |
| RETURNS | 8 | Return & fine calculation |
| FINES | 7 | Fine management |
| FINE_PAYMENTS | 7 | Payment records |
| ERESOURCES | 11 | Digital resources |
| AUDIT_LOG | 10 | Activity logging |

**Total Kolom**: 90+

---

## Relational Integrity

### Referential Integrity Rules
1. **Cascade Delete**: 
   - MEMBERS → LOANS (jika member dihapus, semua loans juga dihapus)
   - LOANS → LOAN_ITEMS (jika loan dihapus, semua item dihapus)

2. **Restrict Delete**:
   - BOOKS → LOAN_ITEMS (buku tidak bisa dihapus jika masih ada peminjaman)
   - CATEGORIES → BOOKS (kategori tidak bisa dihapus jika ada buku)
   - LOANS → RETURNS (transaksi tidak bisa dihapus jika ada return)
   - RETURNS → FINES (return tidak bisa dihapus jika ada denda)

3. **Set Null**:
   - USERS (uploaded_by pada ERESOURCES) → null jika user dihapus

---

## Performance Optimization

### Query Optimization Tips
1. **Always use pagination**: `LIMIT 10 OFFSET 0`
2. **Index frequently searched columns**: judul, penulis, isbn, status
3. **Use EXPLAIN to analyze queries**: `EXPLAIN SELECT ...`
4. **Archive old logs**: Move audit_log older than 1 year to archive table
5. **Denormalize for reporting**: Create summary tables for dashboard

### Connection Pooling
- Min connections: 5
- Max connections: 100
- Connection timeout: 30 seconds

---

## Backup & Recovery

### Backup Strategy
- **Full Backup**: Daily at 02:00 AM (10 versions retained)
- **Incremental Backup**: Every 4 hours
- **Backup Location**: Local + Cloud (AWS S3 / Google Cloud)
- **Retention**: Full backups for 30 days, incremental for 7 days

### Recovery Procedure
1. Stop application
2. Restore database from latest backup
3. Run recovery scripts
4. Verify data integrity
5. Start application

---

## Monitoring & Maintenance

### Key Metrics to Monitor
- Table size (check for bloat)
- Query performance (slow query log)
- Lock wait times
- Replication lag (if applicable)
- Disk space usage

### Maintenance Tasks
- Weekly: ANALYZE TABLE (update statistics)
- Monthly: OPTIMIZE TABLE (defragmentation)
- Quarterly: REPAIR TABLE (consistency check)
- Yearly: Full database review & archival

---

## Security Considerations

### Password Storage
- Use bcrypt with salt
- Never store plain text passwords
- Minimum 8 characters, mixed case + numbers

### Data Encryption
- Encrypt data in transit (TLS 1.3)
- Encrypt sensitive data at rest (member email, phone)
- Use MySQL encryption: `CREATE TABLE ... ENCRYPTION='Y'`

### Access Control
- User-based roles (admin, pustakawan, member)
- Row-level security (members dapat akses data mereka sendiri)
- Column-level encryption for sensitive data
