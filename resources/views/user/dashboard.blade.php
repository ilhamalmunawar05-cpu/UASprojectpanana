@extends('layouts.public')

@section('title', 'Dashboard Anggota Perpustakaan')

@section('content')
{{-- Hero Section --}}
<div class="hero text-center">
    <div class="container">
        <h1 class="display-4 mb-3">
            <i class="fas fa-book-reader"></i> Selamat Datang, {{ auth()->user()->name }}!
        </h1>
        <p class="lead mb-4">Akses perpustakaan digital Anda. Kelola peminjaman, jelajahi koleksi buku, dan nikmati layanan perpustakaan modern.</p>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-3 mb-3">
                <div class="bg-white bg-opacity-25 rounded p-3">
                    <h3 class="mb-0">{{ auth()->user()->getRoleNames()->first() ?? 'user' }}</h3>
                    <small>Status Anda</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="bg-white bg-opacity-25 rounded p-3">
                    <h3 class="mb-0"><i class="fas fa-check-circle"></i></h3>
                    <small>Akun Aktif</small>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="bg-white bg-opacity-25 rounded p-3">
                    <h3 class="mb-0">{{ auth()->user()->created_at->format('Y') }}</h3>
                    <small>Member Sejak</small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="container my-5">
    <h2 class="text-center mb-4"><i class="fas fa-bolt text-warning"></i> Akses Cepat</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-search fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title">OPAC - Cari Buku</h5>
                    <p class="card-text text-muted">Cari dan temukan buku yang Anda butuhkan dari koleksi perpustakaan.</p>
                    <a href="{{ Route::has('opac.index') ? route('opac.index') : '#' }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> Cari Buku
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-book-open fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title">Peminjaman Saya</h5>
                    <p class="card-text text-muted">Lihat buku yang sedang Anda pinjam dan riwayat peminjaman.</p>
                    <a href="{{ Route::has('user.loans') ? route('user.loans') : '#' }}" class="btn btn-success">
                        <i class="fas fa-arrow-right"></i> Lihat Peminjaman
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-circle fa-2x text-info"></i>
                    </div>
                    <h5 class="card-title">Profil Saya</h5>
                    <p class="card-text text-muted">Kelola informasi pribadi dan data keanggotaan perpustakaan.</p>
                    <a href="{{ route('user.member.edit') }}" class="btn btn-info text-white">
                        <i class="fas fa-arrow-right"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Member Status & Stats --}}
@if(auth()->user()->member)
<div class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4"><i class="fas fa-chart-line text-primary"></i> Status Keanggotaan</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-id-card fa-2x"></i>
                        </div>
                        <h4 class="mb-1">{{ auth()->user()->member->nim_nidn }}</h4>
                        <small class="text-muted">NIM/NIDN</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-book-reader fa-2x"></i>
                        </div>
                        <h4 class="mb-1">{{ auth()->user()->member->loans->where('status', 'active')->count() }}</h4>
                        <small class="text-muted">Buku Dipinjam</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <h4 class="mb-1">{{ auth()->user()->member->loans->where('status', 'overdue')->count() }}</h4>
                        <small class="text-muted">Terlambat</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-money-bill fa-2x"></i>
                        </div>
                        <h4 class="mb-1">Rp {{ number_format(auth()->user()->member->loans->where('status', 'returned')->sum(function($loan) { return $loan->return ? $loan->return->fine_amount : 0; }), 0, ',', '.') }}</h4>
                        <small class="text-muted">Total Denda</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Features Section --}}
<div class="container my-5">
    <h2 class="text-center mb-4"><i class="fas fa-star text-warning"></i> Layanan Perpustakaan</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 rounded p-3 d-inline-block mb-3">
                        <i class="fas fa-file-pdf fa-2x text-primary"></i>
                    </div>
                    <h5>E-Resources</h5>
                    <p class="text-muted">Akses koleksi e-book, jurnal, dan materi digital lainnya secara gratis.</p>
                    <a href="{{ Route::has('eresources.public') ? route('eresources.public') : (Route::has('admin.eresources.index') ? route('admin.eresources.index') : '#') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-right"></i> Lihat E-Resources
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 rounded p-3 d-inline-block mb-3">
                        <i class="fas fa-calendar-check fa-2x text-success"></i>
                    </div>
                    <h5>Jadwal Layanan</h5>
                    <p class="text-muted">Informasi jadwal operasional perpustakaan dan layanan yang tersedia.</p>
                    <a href="{{ route('exhibitions.public') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-right"></i> Lihat Jadwal
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="bg-info bg-opacity-10 rounded p-3 d-inline-block mb-3">
                        <i class="fas fa-question-circle fa-2x text-info"></i>
                    </div>
                    <h5>Bantuan & FAQ</h5>
                    <p class="text-muted">Temukan jawaban atas pertanyaan umum tentang layanan perpustakaan.</p>
                    <a href="{{ route('help.faq') }}" class="btn btn-outline-info">
                        <i class="fas fa-arrow-right"></i> Lihat FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
