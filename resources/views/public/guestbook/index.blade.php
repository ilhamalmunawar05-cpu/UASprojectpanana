<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); min-height: 100vh; padding: 20px; }
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
                <h1><i class="fas fa-book"></i> Buku Tamu</h1>
                <p class="text-muted">Tinggalkan kesan dan testimoni Anda</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h4><i class="fas fa-pen"></i> Tulis Pesan</h4>
                <form action="{{ route('guestbook.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Nama" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="message" rows="3" placeholder="Pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">Kirim</button>
                </form>
            </div>
        </div>

        @if(isset($items) && count($items) > 0)
            @foreach($items as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>{{ $item->name ?? 'Pengunjung' }}</h6>
                        <p>{{ $item->message ?? 'Pesan...' }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>