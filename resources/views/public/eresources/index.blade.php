<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Resources - SIPERPUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.back-button')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">SIPERPUS</a>
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="nav-link text-white">Halo, {{ optional(auth()->user())->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1>E-Resources</h1>
                <p class="lead">Akses e-book, jurnal, makalah, dan materi digital lainnya.</p>
            </div>
        </div>

        <div class="row">
            @forelse($resources as $resource)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $resource->title }}</h5>
                            <p class="card-text text-muted">{{ ucfirst($resource->type) }} · {{ $resource->category ?? 'Umum' }}</p>
                            <p class="card-text">{{ Str::limit($resource->description, 120, '...') }}</p>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            @if($resource->url)
                                <a href="{{ $resource->url }}" target="_blank" class="btn btn-primary">Buka Link</a>
                            @elseif($resource->file_path)
                                <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="btn btn-primary">Unduh File</a>
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-info">Belum ada E-Resources tersedia saat ini.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $resources->links() }}
        </div>
    </div>
</body>
</html>
