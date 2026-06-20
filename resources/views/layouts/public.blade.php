<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'SIPERPUS')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: .03em;
        }
        .navbar-nav {
            align-items: center;
        }
        .navbar-nav .nav-item + .nav-item {
            margin-left: .75rem;
        }
        .navbar-nav .nav-link {
            padding: .5rem .85rem;
            border-radius: .375rem;
            transition: color .15s ease, background-color .15s ease;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #f45622;
        }
        .navbar-nav .dropdown-menu {
            min-width: 12rem;
        }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .hero .stats-card {
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.18);
            min-height: 170px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
            border-radius: 20px;
        }
        .hero .stats-card small {
            text-transform: uppercase;
            letter-spacing: .08em;
            opacity: .8;
        }
        .hero .stats-card h3 {
            font-size: 2rem;
            margin-top: .75rem;
            font-weight: 700;
        }
        .widget-card {
            background: white;
            border: 1px solid rgba(0,0,0,.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .widget-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,.08);
        }
        .widget-icon {
            width: 70px;
            height: 70px;
            font-size: 1.5rem;
        }
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: .02em;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,.1);
        }
        footer {
            background: #343a40;
            color: white;
            padding: 40px 0 20px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-book text-primary"></i> <strong>SIPERPUS</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('opac.index') ? 'active' : '' }}" href="{{ route('opac.index') }}">OPAC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('museum.public') ? 'active' : '' }}" href="{{ route('museum.public') }}">Koleksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('eresources.public') ? 'active' : '' }}" href="{{ route('eresources.public') }}">E-Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('help.faq') ? 'active' : '' }}" href="{{ route('help.faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guestbook.public') ? 'active' : '' }}" href="{{ route('guestbook.public') }}">Buku Tamu</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ optional(auth()->user())->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('staff-admin'))
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog"></i> Admin Panel</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @include('partials.back-button')
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><i class="fas fa-book"></i> SIPERPUS</h5>
                    <p class="text-muted">Platform informasi perpustakaan dan koleksi digital terpadu untuk anggota, staf, dan masyarakat umum.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Link Cepat</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('gallery.index') }}" class="text-muted text-decoration-none">Katalog</a></li>
                        <li><a href="{{ route('artists.public') }}" class="text-muted text-decoration-none">Seniman</a></li>
                        <li><a href="{{ route('exhibitions.public') }}" class="text-muted text-decoration-none">Pameran</a></li>
                        <li><a href="{{ route('auctions.public') }}" class="text-muted text-decoration-none">Lelang</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h6>Kontak</h6>
                    <p class="text-muted mb-1"><i class="fas fa-envelope"></i> info@siperpus.id</p>
                    <p class="text-muted mb-1"><i class="fas fa-phone"></i> +62 811 0000 000</p>
                    <div class="mt-2">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="bg-secondary">
            <p class="text-center text-muted mb-0">&copy; {{ date('Y') }} SIPERPUS - Sistem Informasi Perpustakaan. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>