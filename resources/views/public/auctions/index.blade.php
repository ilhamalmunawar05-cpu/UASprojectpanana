<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lelang Karya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); min-height: 100vh; padding: 20px; }
        .card { border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
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
                        <button class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mb-4">
            <div class="card-body text-center py-5">
                <h1><i class="fas fa-gavel text-warning"></i> Lelang Karya Seni</h1>
                <p class="text-muted">Ikuti lelang eksklusif</p>
            </div>
        </div>

        @if(isset($items) && count($items) > 0)
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{ $item->artwork->title ?? 'Lelang ' . ($loop->index + 1) }}</h5>
                                <div class="bg-warning p-3 rounded text-center my-3">
                                    <strong>Rp {{ number_format($item->current_bid ?? 5000000, 0, ',', '.') }}</strong>
                                </div>
                                <a href="{{ route('auctions.show', $item->id ?? 1) }}" class="btn btn-warning btn-sm w-100">Bid Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-info-circle fa-4x text-warning mb-3"></i>
                    <h3>Belum Ada Lelang</h3>
                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Home</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>