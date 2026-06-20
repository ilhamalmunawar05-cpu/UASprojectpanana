<!DOCTYPE html>
<html lang="id">
<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPERPUS - Sistem Informasi Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f4f7fb;
            font-family: 'Open Sans', sans-serif;
            color: #233847;
        }
        .navbar {
            background: #2C3E50;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }
        .navbar-brand {
            font-weight: 700;
            color: #ffffff !important;
        }
        .navbar .btn {
            border-radius: 50px;
        }
        .hero {
            background: linear-gradient(135deg, #2C3E50 0%, #5D6D7E 100%);
            color: white;
            padding: 60px 0;
            border-radius: 28px;
            box-shadow: 0 25px 50px rgba(44, 62, 80, 0.18);
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .hero p {
            font-size: 1.05rem;
            max-width: 620px;
        }
        .feature-card {
            background: white;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 18px 40px rgba(44, 62, 80, 0.08);
            transition: all 0.25s ease;
            min-height: 310px;
        }
        .feature-card:hover {
            transform: translateY(-6px);
        }
        .feature-icon {
            width: 58px;
            height: 58px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            background: #27AE60;
            color: white;
            margin-bottom: 18px;
            font-size: 1.3rem;
        }
        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .feature-desc {
            color: #5f6f85;
            margin-bottom: 18px;
        }
        .btn-feature {
            background: #2C3E50;
            border: none;
            color: white;
            border-radius: 50px;
            padding: 10px 26px;
            font-weight: 600;
        }
        .stats-card {
            border-radius: 20px;
            background: #ffffff;
            padding: 24px;
            box-shadow: 0 18px 40px rgba(44, 62, 80, 0.08);
            min-height: 140px;
        }
        .stats-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #2C3E50;
        }
        .stats-label {
            color: #7b8a9e;
        }
        .quick-link {
            display: block;
            border-left: 4px solid #2C3E50;
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 16px;
            color: #2C3E50;
            text-decoration: none;
            margin-bottom: 12px;
            transition: all 0.2s ease;
            box-shadow: 0 18px 40px rgba(44, 62, 80, 0.06);
        }
        .quick-link:hover {
            transform: translateX(4px);
            background: #f4f7fb;
        }
        .footer-home {
            background: #2C3E50;
            color: rgba(255,255,255,0.8);
        }
    </style>
    <div class="container my-5">
        <div class="hero px-4 py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="mb-4"><i class="fas fa-book-open me-2"></i>SIPERPUS - Sistem Informasi Perpustakaan</h1>
                    <p class="lead mb-4">Mewujudkan layanan perpustakaan akademik yang profesional, responsif, dan mudah digunakan untuk mahasiswa, dosen, dan staf perpustakaan.</p>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="stats-card">
                                <div class="stats-number">{{ optional(auth()->user())->name ? 'Halo' : 'Selamat Datang' }}</div>
                                <div class="stats-label">Pengguna Aktif</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="stats-card">
                                <div class="stats-number">{{ date('Y') }}</div>
                                <div class="stats-label">Tahun Akademik</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <i class="fas fa-university" style="font-size: 10rem; opacity: 0.24;"></i>
                </div>
            </div>
        </div>

        <h2 class="section-title">Modul Utama</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-primary"><i class="fas fa-tachometer-alt"></i></div>
                    <h3 class="feature-title">Dashboard</h3>
                    <p class="feature-desc">Pantau ringkasan statistik buku, kategori, dan pengguna secara cepat.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-feature">Buka Dashboard</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-info"><i class="fas fa-search"></i></div>
                    <h3 class="feature-title">OPAC</h3>
                    <p class="feature-desc">Jelajah katalog buku dengan filter dan pencarian yang mudah.</p>
                    <a href="#" class="btn btn-feature">Telusuri OPAC</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-success"><i class="fas fa-book"></i></div>
                    <h3 class="feature-title">Manajemen Buku</h3>
                    <p class="feature-desc">Kelola data buku lengkap dengan ISBN, stok, dan lokasi rak.</p>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-feature">Kelola Buku</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-warning"><i class="fas fa-layer-group"></i></div>
                    <h3 class="feature-title">Kategori Buku</h3>
                    <p class="feature-desc">Buat dan atur kategori untuk membuat katalog buku lebih rapi.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-feature">Kelola Kategori</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon bg-dark"><i class="fas fa-user-shield"></i></div>
                    <h3 class="feature-title">Hak Akses</h3>
                    <p class="feature-desc">Amankan akses sistem dengan role admin dan staf perpustakaan.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-feature">Kelola Akses</a>
                </div>
            </div>
        </div>

        <div class="quick-access mt-5">
            <h4 class="mb-4"><i class="fas fa-bolt me-2"></i>Akses Cepat</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <a href="#" class="quick-link"><i class="fas fa-book-reader me-2"></i>OPAC - Cari Koleksi Buku</a>
                    <a href="#" class="quick-link"><i class="fas fa-file-alt me-2"></i>Laporan Bulanan</a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('admin.categories.index') }}" class="quick-link"><i class="fas fa-layer-group me-2"></i>Kelola Kategori Buku</a>
                    <a href="{{ route('admin.books.index') }}" class="quick-link"><i class="fas fa-book me-2"></i>Kelola Buku & Stok</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 footer-home">
        <div class="container">
            <p class="mb-0"><i class="fas fa-university me-2"></i>SIPERPUS &copy; {{ date('Y') }} | Universitas Kebangsaan Republik Indonesia</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
