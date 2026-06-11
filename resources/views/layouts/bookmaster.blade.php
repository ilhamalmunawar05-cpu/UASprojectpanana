<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('bookmaster/img/fav.png') }}">
    <!-- Author Meta -->
    <meta name="author" content="SIPERPUS">
    <!-- Meta Description -->
    <meta name="description" content="@yield('meta_description', 'SIPERPUS - Museum Information System')">
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
                        <li class="menu-active"><a href="{{ route('home') }}#home">Home</a></li>
                        <li><a href="{{ route('home') }}#about">About</a></li>
                        <li><a href="{{ route('home') }}#fact">Features</a></li>
                        @auth
                            <li class="menu-has-children">
                                <a href="">Account</a>
                                <ul>
                                    <li><a href="{{ route('profile.show') }}">Profile</a></li>
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
                                <a href="">Account</a>
                                <ul>
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Register</a></li>
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
                    <p>SIPERPUS adalah sistem informasi terintegrasi untuk mengelola museum dan perpustakaan digital.</p>
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
