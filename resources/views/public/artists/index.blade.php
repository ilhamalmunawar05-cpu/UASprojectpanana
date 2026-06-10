<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Seniman & Kurator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); min-height: 100vh; padding: 20px; }
        .card { border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .card:hover { transform: translateY(-5px); transition: all 0.3s; }
        .artist-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
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
                <h1 class="display-4"><i class="fas fa-user-tie text-danger"></i> Profil Seniman & Kurator</h1>
                <p class="lead text-muted">Kenali para seniman berbakat dan kurator profesional</p>
            </div>
        </div>

        @if(isset($items) && count($items) > 0)
            <div class="row">
                @foreach($items as $item)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                @if(!empty($item->image))
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         class="artist-avatar me-4" alt="{{ $item->name }}">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->name ?? 'Artist') }}&size=200&background=f093fb&color=fff" 
                                         class="artist-avatar me-4" alt="Artist">
                                @endif
                                <div class="flex-grow-1">
                                    <h4 class="mb-2">{{ $item->name ?? 'Seniman ' . ($loop->index + 1) }}</h4>
                                    <p class="text-muted mb-2"><i class="fas fa-briefcase"></i> {{ $item->specialization ?? 'Seniman' }}</p>
                                    <p class="mb-3">{{ Str::limit($item->bio ?? 'Seniman berbakat dengan dedikasi tinggi.', 100) }}</p>
                                    <a href="{{ route('artists.show', $item->id ?? 1) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-info-circle fa-4x text-danger mb-3"></i>
                    <h3>Belum Ada Data Seniman</h3>
                    <p class="text-muted">Data seniman sedang dalam proses.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Home</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>