<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Karya Seni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .card { border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .card:hover { transform: translateY(-5px); transition: all 0.3s; }
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
                <h1 class="display-4"><i class="fas fa-images text-primary"></i> Galeri Karya Seni</h1>
                <p class="lead text-muted">Jelajahi koleksi karya seni terbaik</p>
            </div>
        </div>

        @if(isset($items) && count($items) > 0)
            <div class="row">
                @foreach($items as $item)
                    @php
                        $imageUrl = $item->image
                            ? asset('storage/' . $item->image)
                            : 'https://via.placeholder.com/600x400?text=Artwork';
                    @endphp
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $imageUrl }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $item->title ?? 'Karya seni' }}">
                            <div class="card-body">
                                <h5>{{ $item->title ?? 'Karya ' . ($loop->index + 1) }}</h5>
                                <p class="text-muted"><i class="fas fa-user"></i> {{ $item->artist->name ?? 'Seniman' }}</p>
                                <a href="{{ route('gallery.show', $item->id ?? 1) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-info-circle fa-4x text-primary mb-3"></i>
                    <h3>Belum Ada Karya Seni</h3>
                    <p class="text-muted">Galeri masih kosong.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Home</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>