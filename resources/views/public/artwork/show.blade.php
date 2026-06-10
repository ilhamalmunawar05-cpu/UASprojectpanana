@extends('layouts.public')

@section('title', $artwork->title)

@section('content')
<div class="container my-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Galeri</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($artwork->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Image Section --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-lg">
                <img src="{{ asset('storage/' . $artwork->image) }}" 
                     class="card-img-top rounded" 
                     alt="{{ $artwork->title }}"
                     style="width: 100%; height: auto; max-height: 600px; object-fit: contain;">
            </div>

            {{-- Image Info --}}
            <div class="text-center mt-3 text-muted">
                <small>
                    <i class="fas fa-info-circle"></i> 
                    Klik untuk memperbesar gambar
                </small>
            </div>
        </div>

        {{-- Details Section --}}
        <div class="col-md-5">
            {{-- Title & Artist --}}
            <h1 class="mb-3">{{ $artwork->title }}</h1>
            
            <div class="mb-4">
                <a href="{{ route('artists.show', $artwork->artist) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        @if($artwork->artist->image)
                            <img src="{{ asset('storage/' . $artwork->artist->image) }}" 
                                 class="rounded-circle me-3"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                        <div>
                            <h5 class="mb-0">{{ $artwork->artist->name }}</h5>
                            <small class="text-muted">{{ $artwork->artist->specialization ?? 'Seniman' }}</small>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Status Badge --}}
            <div class="mb-3">
                @if($artwork->status == 'available')
                    <span class="badge bg-success fs-6"><i class="fas fa-check-circle"></i> Tersedia</span>
                @elseif($artwork->status == 'on_display')
                    <span class="badge bg-warning text-dark fs-6"><i class="fas fa-eye"></i> Sedang Dipamerkan</span>
                @else
                    <span class="badge bg-danger fs-6"><i class="fas fa-times-circle"></i> Terjual</span>
                @endif
            </div>

            {{-- Price --}}
            @if($artwork->price && $artwork->status != 'sold')
                <div class="alert alert-primary">
                    <h3 class="mb-0">
                        <i class="fas fa-tag"></i> 
                        Rp {{ number_format($artwork->price, 0, ',', '.') }}
                    </h3>
                </div>
            @endif

            {{-- Specifications --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Spesifikasi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        @if($artwork->year)
                            <tr>
                                <td width="40%"><strong>Tahun</strong></td>
                                <td>{{ $artwork->year }}</td>
                            </tr>
                        @endif
                        @if($artwork->medium)
                            <tr>
                                <td><strong>Medium</strong></td>
                                <td>{{ $artwork->medium }}</td>
                            </tr>
                        @endif
                        @if($artwork->dimensions)
                            <tr>
                                <td><strong>Dimensi</strong></td>
                                <td>{{ $artwork->dimensions }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>{{ ucfirst($artwork->status) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Description --}}
            @if($artwork->description)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-align-left"></i> Deskripsi</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="white-space: pre-line;">{{ $artwork->description }}</p>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="d-grid gap-2 mb-4">
                @if($auction)
                    <a href="{{ route('auctions.show', $auction) }}" class="btn btn-danger btn-lg">
                        <i class="fas fa-gavel"></i> Sedang Dilelang - Lihat Lelang
                    </a>
                @endif
                
                <button class="btn btn-outline-primary" onclick="shareArtwork()">
                    <i class="fas fa-share-alt"></i> Bagikan Karya Ini
                </button>
                
                <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Galeri
                </a>
            </div>

            {{-- Social Share --}}
            <div class="text-center">
                <p class="text-muted mb-2">Bagikan:</p>
                <div class="btn-group" role="group">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($artwork->title) }}" 
                       target="_blank" class="btn btn-sm btn-outline-info">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($artwork->title . ' - ' . url()->current()) }}" 
                       target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Artworks --}}
    @if($relatedArtworks->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4">Karya Lain dari {{ $artwork->artist->name }}</h3>
        <div class="row g-3">
            @foreach($relatedArtworks as $related)
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $related->image) }}" 
                         class="card-img-top" 
                         alt="{{ $related->title }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($related->title, 30) }}</h6>
                        @if($related->year)
                            <p class="text-muted small mb-2">{{ $related->year }}</p>
                        @endif
                        @if($related->price)
                            <p class="text-primary fw-bold small">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        @endif
                        <a href="{{ route('gallery.show', $related) }}" class="btn btn-sm btn-outline-primary w-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Comments Section --}}
    <div class="mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments"></i> 
                    Komentar ({{ $artwork->comments()->where('status', 'approved')->count() }})
                </h5>
            </div>
            <div class="card-body">
                {{-- Comment Form --}}
                @auth
                    <form action="{{ route('guestbook.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                        <div class="mb-3">
                            <label class="form-label">Tulis Komentar Anda</label>
                            <textarea name="message" rows="3" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim Komentar
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <a href="{{ route('login') }}">Login</a> untuk memberikan komentar
                    </div>
                @endauth

                {{-- Display Comments --}}
                @forelse($artwork->comments()->where('status', 'approved')->latest()->get() as $comment)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 40px; height: 40px;">
                                <strong>{{ substr($comment->commenter_name, 0, 1) }}</strong>
                            </div>
                            <div>
                                <strong>{{ $comment->commenter_name }}</strong>
                                <br>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="mb-0 ms-5">{{ $comment->message }}</p>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">Belum ada komentar</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function shareArtwork() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $artwork->title }}',
                text: 'Lihat karya seni: {{ $artwork->title }} oleh {{ $artwork->artist->name }}',
                url: window.location.href
            });
        } else {
            alert('Link disalin ke clipboard!');
            navigator.clipboard.writeText(window.location.href);
        }
    }
</script>
@endpush
@endsection