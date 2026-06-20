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

        <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
            <a href="{{ route('opac.index') }}" class="btn btn-light btn-lg rounded-pill px-4">OPAC</a>
            <a href="{{ route('museum.public') }}" class="btn btn-light btn-lg rounded-pill px-4">Koleksi</a>
            <a href="{{ route('eresources.public') }}" class="btn btn-light btn-lg rounded-pill px-4">E-Resources</a>
            <a href="{{ route('help.faq') }}" class="btn btn-light btn-lg rounded-pill px-4">FAQ</a>
        </div>

        <div class="row justify-content-center gx-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card p-4 text-white h-100">
                    <small>Status Anda</small>
                    <h3 class="mt-3">{{ auth()->user()->getRoleNames()->first() ?? 'public' }}</h3>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card p-4 text-white h-100">
                    <small>Akun</small>
                    <h3 class="mt-3"><i class="fas fa-check-circle"></i> Aktif</h3>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card p-4 text-white h-100">
                    <small>Member Sejak</small>
                    <h3 class="mt-3">{{ auth()->user()->created_at->format('Y') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Action Widgets --}}
<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="widget-card p-4 text-center h-100 shadow-sm rounded-4">
                <div class="widget-icon mb-3 bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-book"></i>
                </div>
                <h5 class="mb-1">Buku Dipinjam</h5>
                <p class="text-muted mb-3">Saat ini</p>
                <span class="display-6">{{ auth()->user()->member ? auth()->user()->member->loans->where('status', 'active')->count() : 0 }}</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-card p-4 text-center h-100 shadow-sm rounded-4">
                <div class="widget-icon mb-3 bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="mb-1">Akun Aktif</h5>
                <p class="text-muted mb-3">Status proses</p>
                <span class="display-6">Terhubung</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-card p-4 text-center h-100 shadow-sm rounded-4">
                <div class="widget-icon mb-3 bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5 class="mb-1">Member Sejak</h5>
                <p class="text-muted mb-3">Tahun gabung</p>
                <span class="display-6">{{ auth()->user()->created_at->format('Y') }}</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-card p-4 text-center h-100 shadow-sm rounded-4">
                <div class="widget-icon mb-3 bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="mb-1">Total Kunjungan</h5>
                <p class="text-muted mb-3">Ringkasan aktivitas</p>
                <span class="display-6">{{ auth()->user()->member ? auth()->user()->member->loans->count() : 0 }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="container my-5">
    <h2 class="section-title text-center mb-4"><i class="fas fa-bolt text-warning"></i> Akses Cepat</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body text-center px-4 py-5">
                    <div class="rounded-circle bg-primary bg-opacity-15 mx-auto mb-3" style="width: 80px; height:80px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-search fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title">OPAC - Cari Buku</h5>
                    <p class="card-text text-muted">Jelajahi katalog dan filtering buku lebih cepat.</p>
                    <a href="{{ route('opac.index') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                        <i class="fas fa-arrow-right"></i> Telusuri OPAC
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body text-center px-4 py-5">
                    <div class="rounded-circle bg-success bg-opacity-15 mx-auto mb-3" style="width: 80px; height:80px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-book-open fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title">Peminjaman Saya</h5>
                    <p class="card-text text-muted">Pantau status pinjaman dan pengembalian buku.</p>
                    <a href="{{ route('user.loans') }}" class="btn btn-success rounded-pill px-4 mt-3">
                        <i class="fas fa-arrow-right"></i> Lihat Peminjaman
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body text-center px-4 py-5">
                    <div class="rounded-circle bg-info bg-opacity-15 mx-auto mb-3" style="width: 80px; height:80px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-user-circle fa-2x text-info"></i>
                    </div>
                    <h5 class="card-title">Profil & Akun</h5>
                    <p class="card-text text-muted">Perbarui data anggota dan konfigurasi akun Anda.</p>
                    <a href="{{ route('user.member.edit') }}" class="btn btn-info text-white rounded-pill px-4 mt-3">
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
        <h2 class="section-title text-center mb-4"><i class="fas fa-chart-line text-primary"></i> Status Keanggotaan</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-5">
                        <div class="mb-3 text-primary"><i class="fas fa-id-card fa-2x"></i></div>
                        <h4 class="mb-1">{{ auth()->user()->member->nim_nidn }}</h4>
                        <small class="text-muted">NIM/NIDN</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-5">
                        <div class="mb-3 text-success"><i class="fas fa-book-reader fa-2x"></i></div>
                        <h4 class="mb-1">{{ auth()->user()->member->loans->where('status', 'active')->count() }}</h4>
                        <small class="text-muted">Buku Dipinjam</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-5">
                        <div class="mb-3 text-warning"><i class="fas fa-clock fa-2x"></i></div>
                        <h4 class="mb-1">{{ auth()->user()->member->loans->where('status', 'overdue')->count() }}</h4>
                        <small class="text-muted">Terlambat</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-5">
                        <div class="mb-3 text-danger"><i class="fas fa-money-bill-wave fa-2x"></i></div>
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
    <h2 class="section-title text-center mb-4"><i class="fas fa-star text-warning"></i> Layanan Perpustakaan</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body px-4 py-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="me-3">
                            <h5>E-Resources</h5>
                            <p class="text-muted mb-0">Akses koleksi digital dan materi ilmiah.</p>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                    </div>
                    <a href="{{ route('eresources.public') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3">Lihat E-Resources</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body px-4 py-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="me-3">
                            <h5>Jadwal Layanan</h5>
                            <p class="text-muted mb-0">Informasi jam operasional perpustakaan.</p>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <a href="{{ route('exhibitions.public') }}" class="btn btn-outline-success rounded-pill px-4 mt-3">Lihat Jadwal</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body px-4 py-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="me-3">
                            <h5>Bantuan & FAQ</h5>
                            <p class="text-muted mb-0">Dapatkan jawaban cepat atas pertanyaan umum.</p>
                        </div>
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-question-circle"></i>
                        </div>
                    </div>
                    <a href="{{ route('help.faq') }}" class="btn btn-outline-info rounded-pill px-4 mt-3">Lihat FAQ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

