<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Museum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%); min-height: 100vh; padding: 20px; }
        .card { border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .card:hover { transform: translateY(-5px); transition: all 0.3s; }
        .museum-img { width: 100%; height: 220px; object-fit: cover; }
        .archive-badge { background: rgba(210, 153, 194, 0.9); color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; }
    </style>
</head>
<body>
    @include('partials.back-button')
    <nav class="navbar navbar-light bg-white rounded shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
                <i class="fas fa-palette"></i> Gallery Art Lelang
            </a>
            <div>
                @auth
                    <span class="me-3">{{ optional(auth()->user())->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mb-4">
            <div class="card-body text-center py-5">
                <h1 class="display-4"><i class="fas fa-landmark"></i> Koleksi Museum & Arsip</h1>
                <p class="lead text-muted">Jelajahi arsip bersejarah dan koleksi museum</p>
            </div>
        </div>

        @if(isset($items) && count($items) > 0)
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @php
                                $museumImage = !empty($item->image) ? asset('storage/' . $item->image) : 'https://via.placeholder.com/400x300?text=Koleksi';
                            @endphp
                            <img src="{{ $museumImage }}" class="museum-img card-img-top" alt="{{ $item->title ?? 'Koleksi' }}">
                            <div class="card-body">
                                <span class="archive-badge mb-3 d-inline-block">
                                    <i class="fas fa-archive"></i> Arsip
                                </span>
                                <h5 class="mb-2">{{ $item->title ?? 'Koleksi ' . ($loop->index + 1) }}</h5>
                                <p class="text-muted mb-2"><i class="fas fa-clock"></i> {{ $item->period ?? 'Abad ke-' . rand(15, 20) }}</p>
                                <p class="mb-3">{{ Str::limit($item->description ?? 'Koleksi bersejarah yang memiliki nilai seni tinggi.', 80) }}</p>
                                <div class="bg-light p-2 rounded mb-3 small">
                                    <div class="mb-1"><i class="fas fa-user"></i> <strong>Seniman:</strong> {{ $item->material ?? 'Anonim' }}</div>
                                    <div class="mb-1"><i class="fas fa-map-marker-alt"></i> <strong>Asal:</strong> {{ $item->origin ?? 'Nusantara' }}</div>
                                </div>
                                <a href="{{ route('museum.show', $item->id ?? 1) }}" class="btn btn-secondary btn-sm w-100">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-info-circle fa-4x mb-3" style="color: #d299c2;"></i>
                    <h3>Belum Ada Koleksi Museum</h3>
                    <p class="text-muted">Koleksi arsip sedang dalam proses digitalisasi.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Home</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>