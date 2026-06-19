<!DOCTYPE html>
<html lang="en" class="no-js">
    <style>
    /* 1. PAKSA DROPDOWN TETAP MUNCUL (Menghancurkan bug JavaScript template) */
    .dropdown:hover .dropdown-menu,
    .nav-menu li:hover > ul,
    .nav-item:hover .dropdown-menu,
    .menu-has-children:hover > ul {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* 2. JEMBATAN TRANSPARAN (Menutup celah kosong agar kursor tidak lepas) */
    .dropdown-menu::before,
    .nav-menu ul::before,
    .nav-menu li ul::before,
    .menu-has-children ul::before {
        content: "" !important;
        position: absolute !important;
        top: -30px !important; /* Menjangkau ke atas sampai menempel ke teks ACCOUNT */
        left: 0 !important;
        width: 100% !important;
        height: 30px !important; /* Tebal celah kosong */
        background: transparent !important;
        display: block !important;
        z-index: 9999 !important;
    }
</style>
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('bookmaster/img/fav.png') }}">
    <!-- Author Meta -->
    <meta name="author" content="SIPERPUS">
    <!-- Meta Description -->
    <meta name="description" content="@yield('meta_description', 'SIPERPUS - Sistem Informasi Perpustakaan')">
    <!-- Meta Keyword -->
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <!-- Meta Character Set -->
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Site Title -->
    <title>@yield('title', 'SIPERPUS')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('bookmaster/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('bookmaster/css/main.css') }}">
    
    @yield('extra_css')
    <style>
    /* Bridge hover gap: transparent pseudo-element on submenu to keep hover active */
    .nav-menu > li.menu-has-children { position: relative; }
    .nav-menu > li.menu-has-children > ul::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: -12px;
        height: 12px;
        background: transparent;
        pointer-events: auto;
        z-index: 90;
    }
    </style>
</head>
<body>
    <!-- Navigation Header -->
    <header id="header" id="home">
        <div class="container">
            <div class="row align-items-center justify-content-between d-flex">
                <div id="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('bookmaster/img/logo.png') }}" alt="SIPERPUS Logo" title="SIPERPUS">
                    </a>
                </div>
                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                        <li class="menu-active"><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('opac.index') }}">OPAC</a></li>
                        <li><a href="{{ route('museum.public') }}">Koleksi</a></li>
                        <li><a href="{{ route('eresources.public') }}">E-Resources</a></li>
                        <li><a href="{{ route('help.faq') }}">FAQ</a></li>
                        <li><a href="{{ route('guestbook.public') }}">Buku Tamu</a></li>
                        @auth
                            <li class="menu-has-children">
                                <a href="">Akun</a>
                                <ul>
                                    <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                    @if(auth()->user()->member)
                                        <li><a href="{{ route('user.loans') }}">Peminjaman Saya</a></li>
                                        <li><a href="{{ route('user.member.edit') }}">Edit Profil Anggota</a></li>
                                    @else
                                        <li><a href="{{ route('user.member.edit') }}">Lengkapi Profil</a></li>
                                    @endif
                                    <li><a href="{{ route('profile.edit') }}">Pengaturan Akun</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else
                            <li class="menu-has-children">
                                <a href="">Akun</a>
                                <ul>
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Daftar</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer-area section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <h4>Follow Us</h4>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <h4>About SIPERPUS</h4>
                    <p>SIPERPUS adalah sistem informasi terintegrasi untuk mengelola perpustakaan dan koleksi digital.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <h4>Newsletter</h4>
                    <p>Subscribe untuk mendapatkan update terbaru dari kami.</p>
                </div>
            </div>
            <div class="row footer-bottom d-flex justify-content-between align-items-center">
                <p class="col-lg-8 col-sm-12 footer-text m-0 text-body">
                    Copyright &copy; <script>document.write(new Date().getFullYear());</script> SIPERPUS. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('bookmaster/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('bookmaster/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('bookmaster/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bookmaster/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('bookmaster/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('bookmaster/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('bookmaster/js/parallax.min.js') }}"></script>
    <script src="{{ asset('bookmaster/js/mail-script.js') }}"></script>
    <script src="{{ asset('bookmaster/js/main.js') }}"></script>
    
    @yield('extra_js')
</body>
</html>
