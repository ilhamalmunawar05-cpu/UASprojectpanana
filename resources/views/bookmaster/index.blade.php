@extends('layouts.bookmaster')

@section('title', 'Home - SIPERPUS')
@section('meta_description', 'SIPERPUS - Sistem Informasi Perpustakaan Portal')

@section('content')
<!-- start banner Area -->
<section class="banner-area" id="home">	
    <div class="container">
        <div class="row fullscreen d-flex align-items-center justify-content-start">
            <div class="banner-content col-lg-7">
                <h5 class="text-white text-uppercase">Welcome to</h5>
                <h1 class="text-uppercase">
                    SIPERPUS System			
                </h1>
                <p class="text-white pt-20 pb-20">
                    Sistem Informasi Perpustakaan dan Museum - Kelompok 6 <br> 
                    Manajemen data koleksi, pameran, dan akses digital yang terintegrasi.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}" class="primary-btn text-uppercase">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="primary-btn text-uppercase">Masuk Sekarang</a>
                @endauth
            </div>
            <div class="col-lg-5 banner-right">
                <img class="img-fluid" src="{{ asset('bookmaster/img/header-img.png') }}" alt="SIPERPUS">
            </div>												
        </div>
    </div>
</section>
<!-- End banner Area -->	

<!-- Start about Area -->
<section class="section-gap info-area" id="about">
    <div class="container">				
        <div class="single-info row mt-40 align-items-center">
            <div class="col-lg-6 col-md-12 text-center no-padding info-left">
                <div class="info-thumb">
                    <img src="{{ asset('bookmaster/img/about-img.jpg') }}" class="img-fluid info-img" alt="About">
                </div>
            </div>
            <div class="col-lg-6 col-md-12 no-padding info-right">
                <div class="info-content">
                    <h2 class="pb-30">Tentang SIPERPUS</h2>
                    <p>
                        SIPERPUS adalah solusi terintegrasi untuk mengelola perpustakaan digital, koleksi perpustakaan, dan informasi pameran seni dengan mudah dan efisien.
                    </p>
                    <br>
                    <p>
                        Sistem ini dirancang untuk memudahkan akses informasi koleksi, manajemen peminjaman, pengelolaan pameran, dan dokumentasi karya seni secara terpusat. Kelompok 6 mengembangkan platform ini sebagai bagian dari proyek UAS.
                    </p>
                    <br>
                    <img src="{{ asset('bookmaster/img/signature.png') }}" alt="Signature">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End about Area -->

<!-- Start fact Area -->
<section class="fact-area relative section-gap" id="fact">
    <div class="overlay overlay-bg"></div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-40 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Fitur Unggulan SIPERPUS</h1>
                    <p>Manajemen data koleksi, pameran, dan akses informasi dengan teknologi terkini</p>
                </div>
            </div>
        </div>						
    </div>	
</section>
<!-- End fact Area -->

<!-- Start counter Area -->
<section class="counter-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="single-counter">
                    <h1 class="counter">1000</h1>
                    <p>Koleksi Item</p>								
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-counter">
                    <h1 class="counter">50</h1>
                    <p>Pameran Aktif</p>								
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-counter">
                    <h1 class="counter">500</h1>
                    <p>Pengguna Terdaftar</p>								
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="single-counter">
                    <h1 class="counter">100</h1>
                    <p>Karya Seni</p>								
                </div>
            </div>												
        </div>
    </div>	
</section>
<!-- end counter Area -->

<!-- Start feature Area (dari sections sebelumnya) -->
<section class="price-area section-gap" id="features">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Modul Sistem</h1>
                    <p>Berbagai modul tersedia untuk mengelola perpustakaan dan koleksi</p>
                </div>
            </div>
        </div>						
        <div class="row">
            <div class="col-lg-4">
                <div class="single-price no-padding">
                    <div class="price-top">
                        <h4>Manajemen Koleksi</h4>
                    </div>
                    <p>
                        Kelola data koleksi buku, <br>
                        karya seni, dan artefak museum.
                    </p>
                    <div class="price-bottom">
                        <a href="#" class="primary-btn header-btn">Pelajari Lebih</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-price no-padding">
                    <div class="price-top">
                        <h4>Sistem Pameran</h4>
                    </div>
                    <p>
                        Atur pameran digital, <br>
                        jadwal, dan peserta.
                    </p>
                    <div class="price-bottom">
                        <a href="#" class="primary-btn header-btn">Pelajari Lebih</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-price no-padding">
                    <div class="price-top">
                        <h4>Portal Publik</h4>
                    </div>
                    <p>
                        Akses informasi koleksi <br>
                        dan pameran secara online.
                    </p>
                    <div class="price-bottom">
                        <a href="#" class="primary-btn">Jelajahi</a>
                    </div>
                </div>				
            </div>								
        </div>
    </div>	
</section>
<!-- End feature Area -->

<!-- Start testimonial Area -->
<section class="testomial-area section-gap">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Testimoni Pengguna</h1>
                    <p>Feedback dari pengguna SIPERPUS</p>
                </div>
            </div>
        </div>						
        <div class="row">
            <div class="active-tstimonial-carusel">
                <div class="single-testimonial item">
                    <img class="mx-auto" src="{{ asset('bookmaster/img/t1.png') }}" alt="">
                    <p class="desc">
                        Sistem SIPERPUS sangat membantu dalam mengelola koleksi perpustakaan kami. Interface yang user-friendly membuat pekerjaan semakin efisien.
                    </p>
                    <h4>Admin Perpustakaan</h4>
                    <p>Perpustakaan Nasional</p>
                </div>
                <div class="single-testimonial item">
                    <img class="mx-auto" src="{{ asset('bookmaster/img/t2.png') }}" alt="">
                    <p class="desc">
                        Fitur pencarian dan manajemen pameran membuat pekerjaan kurator menjadi lebih mudah. Rekomendasi implementasi SIPERPUS untuk semua perpustakaan.
                    </p>
                    <h4>Kurator Seni</h4>
                    <p>Galeri Seni Kontemporer</p>
                </div>
                <div class="single-testimonial item">
                    <img class="mx-auto" src="{{ asset('bookmaster/img/t3.png') }}" alt="">
                    <p class="desc">
                        Sebagai pengguna publik, saya sangat senang dengan kemudahan akses informasi koleksi dan pameran melalui portal online SIPERPUS.
                    </p>
                    <h4>Pengunjung Perpustakaan</h4>
                    <p>Pecinta Seni</p>
                </div>	
            </div>
        </div>
    </div>	
</section>
<!-- End testimonial Area -->

<!-- Start call-to-action Area -->
<section class="call-to-action-area section-gap">
    <div class="container">
        <div class="row justify-content-center top">
            <div class="col-lg-12">
                <h1 class="text-white text-center">Mulai Gunakan SIPERPUS Sekarang</h1>
                <p class="text-white text-center mt-30">
                    Kelola perpustakaan dan museum digital Anda dengan sistem yang terintegrasi dan mudah digunakan. Daftar sekarang dan dapatkan akses penuh ke semua fitur.
                </p>							
            </div>
        </div>
        <div class="row justify-content-center d-flex">	
            <div class="download-button d-flex flex-row justify-content-center mt-30">		
                <div class="buttons flex-row d-flex">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                    <div class="desc">
                        <a href="{{ route('register') }}">
                            <p>
                                <span>Daftar</span> <br>
                                Akun Baru
                            </p>
                        </a>
                    </div>
                </div>
                <div class="buttons flex-row d-flex">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    <div class="desc">
                        <a href="#">
                            <p>
                                <span>Hubungi</span> <br>
                                Support
                            </p>
                        </a>
                    </div>
                </div>
            </div>						
        </div>
    </div>	
</section>
<!-- End call-to-action Area -->
@endsection

@section('extra_js')
<script>
    // Initialize counter on scroll
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
</script>
@endsection
