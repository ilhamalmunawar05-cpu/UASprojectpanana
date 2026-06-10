@extends('layouts.public')

@section('title', $artist->name)

@section('content')
<div class="container my-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('artists.public') }}">Seniman</a></li>
            <li class="breadcrumb-item active">{{ $artist->name }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Profile Sidebar --}}
        <div class="col-md-4">
            <div class="card shadow sticky-top" style="top: 20px;">
                <div class="card-body text-center">
                    {{-- Photo --}}
                    @if($artist->image)
                        <img src="{{ asset('storage/' . $artist->image) }}" 
                             class="rounded-circle shadow mb-3"
                             alt="{{ $artist->name }}"
                             style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white shadow mb-3"
                             style="width: 200px; height: 200px;">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                    @endif

                    {{-- Name --}}
                    <h3 class="mb-2">{{ $artist->name }}</h3>

                    {{-- Specialization --}}
                    @if($artist->specialization)
                        <span class="badge bg-info fs-6 mb-3">{{ $artist->specialization }}</span>
                    @endif

                    {{-- Stats --}}
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <h4 class="text-primary mb-0">{{ $artist->artworks->count() }}</h4>
                            <small class="text-muted">Karya</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success mb-0">{{ $artist->artworks()->where('status', 'available')->count() }}</h4>
                            <small class="text-muted">Tersedia</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-danger mb-0">{{ $artist->artworks()->where('status', 'sold')->count() }}</h4>
                            <small class="text-muted">Terjual</small>
                        </div>
                    </div>

                    <hr>

                    {{-- Contact Info --}}
                    <div class="text-start">
                        <h6 class="mb-3"><i class="fas fa-address-card"></i> Informasi Kontak</h6>
                        
                        @if($artist->email)
                            <p class="mb-2">
                                <i class="fas fa-envelope text-primary"></i> 
                                <a href="mailto:{{ $artist->email }}" class="text-decoration-none">
                                    {{ $artist->email }}
                                </a>
                            </p>
                        @endif

                        @if($artist->phone)
                            <p class="mb-2">
                                <i class="fas fa-phone text-success"></i> 
                                <a href="tel:{{ $artist->phone }}" class="text-decoration-none">
                                    {{ $artist->phone }}
                                </a>
                            </p>
                        @endif

                        @if(!$artist->email && !$artist->phone)
                            <p class="text-muted small">Informasi kontak tidak tersedia</p>
                        @endif
                    </div>

                    <hr>

                    {{-- Share Buttons --}}
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="shareProfile()">
                            <i class="fas fa-share-alt"></i> Bagikan Profil
                        </button>
                        <a href="{{ route('artists.public') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-md-8">
            {{-- Biography --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle"></i> Biografi</h5>
                </div>
                <div class="card-body">
                    @if($artist->bio)
                        <p style="white-space: pre-line; text-align: justify;">{{ $artist->bio }}</p>
                    @else
                        <p class="text-muted text-center py-3">Belum ada informasi biografi</p>
                    @endif
                </div>
            </div>

            {{-- Artworks Section --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-palette"></i> 
                            Karya Seni ({{ $artist->artworks->count() }})
                        </h5>
                        @if($artist->artworks->count() > 0)
                            <a href="{{ route('gallery.index', ['artist_id' => $artist->id]) }}" class="btn btn-sm btn-primary">
                                Lihat Semua <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($artist->artworks->count() > 0)
                        <div class="row g-3">
                            @foreach($artist->artworks->take(6) as $artwork)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $artwork->image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $artwork->title }}"
                                         style="height: 180px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h6 class="card-title mb-2">{{ Str::limit($artwork->title, 30) }}</h6>
                                        
                                        <p class="small text-muted mb-2">
                                            @if($artwork->year)
                                                <i class="fas fa-calendar"></i> {{ $artwork->year }}
                                            @endif
                                            @if($artwork->medium)
                                                | {{ $artwork->medium }}
                                            @endif
                                        </p>

                                        @if($artwork->price)
                                            <p class="text-primary fw-bold small mb-2">
                                                Rp {{ number_format($artwork->price, 0, ',', '.') }}
                                            </p>
                                        @endif

                                        {{-- Status Badge --}}
                                        @if($artwork->status == 'available')
                                            <span class="badge bg-success mb-2">Tersedia</span>
                                        @elseif($artwork->status == 'sold')
                                            <span class="badge bg-danger mb-2">Terjual</span>
                                        @else
                                            <span class="badge bg-warning text-dark mb-2">On Display</span>
                                        @endif

                                        <a href="{{ route('gallery.show', $artwork) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($artist->artworks->count() > 6)
                            <div class="text-center mt-4">
                                <a href="{{ route('gallery.index', ['artist_id' => $artist->id]) }}" class="btn btn-primary">
                                    Lihat {{ $artist->artworks->count() - 6 }} Karya Lainnya
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-palette fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada karya seni yang dipublikasikan</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Exhibitions Participated (Optional) --}}
            @php
                $exhibitions = \App\Models\Exhibition::whereHas('artworks', function($q) use ($artist) {
                    $q->where('artist_id', $artist->id);
                })->latest()->take(3)->get();
            @endphp

            @if($exhibitions->count() > 0)
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt"></i> 
                        Pameran yang Diikuti
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($exhibitions as $exhibition)
                            <a href="{{ route('exhibitions.show', $exhibition) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $exhibition->title }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> 
                                            {{ $exhibition->start_date->format('d M Y') }} - {{ $exhibition->end_date->format('d M Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $exhibition->status == 'ongoing' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($exhibition->status) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function shareProfile() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $artist->name }}',
                text: 'Lihat profil seniman: {{ $artist->name }}',
                url: window.location.href
            });
        } else {
            alert('Link profil disalin ke clipboard!');
            navigator.clipboard.writeText(window.location.href);
        }
    }
</script>
@endpush
@endsection