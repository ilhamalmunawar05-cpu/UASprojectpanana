<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPERPUS - Sistem Informasi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Selamat Datang di SIPERPUS</h1>
                <p class="lead">Sistem Informasi Perpustakaan Modern untuk Mahasiswa dan Dosen</p>

                @auth
                    <p>Anda login sebagai: <strong>{{ optional(auth()->user())->name }}</strong></p>
                    <p>Role: <strong>{{ auth()->user()->getRoleNames()->first() ?? 'user' }}</strong></p>
                @endauth

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5><i class="fas fa-search"></i> OPAC</h5>
                                <p>Cari dan temukan buku yang Anda butuhkan</p>
                                <a href="{{ route('opac.index') }}" class="btn btn-primary">Cari Buku</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5><i class="fas fa-book-open"></i> E-Resources</h5>
                                <p>Akses e-book, jurnal, dan materi digital</p>
                                <a href="{{ route('eresources.public') }}" class="btn btn-success">Lihat E-Resources</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5><i class="fas fa-user-circle"></i> Keanggotaan</h5>
                                <p>Daftar sebagai anggota perpustakaan</p>
                                @auth
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-info">Dashboard</a>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-info">Daftar</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
