@extends('layouts.bookmaster')

@section('title', 'Generic Page - SIPERPUS')
@section('meta_description', 'Generic Page - SIPERPUS Information')

@section('content')
<!-- Banner Area -->
<section class="generic-banner relative">	
    <div class="container">
        <div class="row height align-items-center justify-content-center">
            <div class="col-lg-10">
                <div class="generic-banner-content">
                    <h2 class="text-white">Halaman Informasi SIPERPUS</h2>
                    <p class="text-white">Pelajari lebih lanjut tentang fitur dan cara penggunaan sistem <br> manajemen perpustakaan dan museum kami.</p>
                </div>							
            </div>
        </div>
    </div>
</section>		
<!-- End banner Area -->

<!-- Main Content -->
<div class="main-wrapper">
    
    <!-- Testimonial Section -->
    <section class="testomial-area pt-100">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-60 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Apa Kata Pengguna SIPERPUS</h1>
                        <p>Pengalaman dan testimonial dari para pengguna sistem kami</p>
                    </div>
                </div>
            </div>						
            <div class="row">
                <div class="active-tstimonial-carusel">
                    <div class="single-testimonial item">
                        <img class="mx-auto" src="{{ asset('bookmaster/img/t1.png') }}" alt="">
                        <p class="desc">
                            SIPERPUS telah meningkatkan efisiensi operasional museum kami. Fitur pencarian yang canggih membuat pengunjung mudah menemukan koleksi yang dicari.
                        </p>
                        <h4>Kepala Museum</h4>
                        <p>Museum Seni Nasional</p>
                    </div>
                    <div class="single-testimonial item">
                        <img class="mx-auto" src="{{ asset('bookmaster/img/t2.png') }}" alt="">
                        <p class="desc">
                            Manajemen pameran menjadi sangat mudah dengan SIPERPUS. Saya dapat mengorganisir event dengan lebih terstruktur dan profesional.
                        </p>
                        <h4>Event Manager</h4>
                        <p>Galeri Kontemporer</p>
                    </div>
                    <div class="single-testimonial item">
                        <img class="mx-auto" src="{{ asset('bookmaster/img/t3.png') }}" alt="">
                        <p class="desc">
                            Sebagai peneliti, saya sangat menghargai akses digital ke koleksi perpustakaan melalui SIPERPUS. Sangat memudahkan penelitian saya.
                        </p>
                        <h4>Peneliti</h4>
                        <p>Institusi Penelitian</p>
                    </div>	
                    <div class="single-testimonial item">
                        <img class="mx-auto" src="{{ asset('bookmaster/img/t1.png') }}" alt="">
                        <p class="desc">
                            Interface yang intuitif membuat semua orang di tim dapat menggunakan SIPERPUS tanpa memerlukan pelatihan ekstensif.
                        </p>
                        <h4>Admin IT</h4>
                        <p>Perpustakaan Daerah</p>
                    </div>
                    <div class="single-testimonial item">
                        <img class="mx-auto" src="{{ asset('bookmaster/img/t2.png') }}" alt="">
                        <p class="desc">
                            Laporan dan analytics yang disediakan SIPERPUS membantu kami membuat keputusan manajemen yang lebih baik dan berdasarkan data.
                        </p>
                        <h4>Manager Operasional</h4>
                        <p>Museum Regional</p>
                    </div>
                    <div class="single-testimonial item">
                        <img class="mx-auto" src="{{ asset('bookmaster/img/t3.png') }}" alt="">
                        <p class="desc">
                            Support team SIPERPUS sangat responsif dan membantu dalam menyelesaikan setiap masalah teknis yang kami hadapi.
                        </p>
                        <h4>Administrator Sistem</h4>
                        <p>Perpustakaan Universitas</p>
                    </div>														
                </div>
            </div>
        </div>	
    </section>
    <!-- End Testimonial Area -->

    <!-- About/Generic Content Area -->
    <section class="about-generic-area section-gap">
        <div class="container border-top-generic">
            <h3 class="about-title mb-30">Tentang SIPERPUS</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="img-text">
                        <img src="{{ asset('bookmaster/img/a.jpg') }}" alt="SIPERPUS" class="img-fluid float-left mr-20 mb-20">
                        <p>
                            SIPERPUS (Sistem Informasi Perpustakaan dan Museum) adalah solusi terintegrasi yang dikembangkan untuk memenuhi kebutuhan manajemen modern dalam institusi perpustakaan dan museum. Sistem ini dirancang dengan teknologi terkini untuk memberikan kemudahan dalam pengelolaan koleksi, pameran, dan akses informasi publik.
                        </p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <p>
                        Dengan fitur-fitur komprehensif, SIPERPUS memungkinkan administrator untuk mengelola seluruh aspek operasional mulai dari inventaris koleksi, manajemen peminjaman, pengelolaan pameran, hingga pelaporan statistik pengunjung. Platform ini juga menyediakan portal publik yang memudahkan pengunjung untuk mengakses informasi koleksi dan jadwal pameran secara online.
                    </p>
                </div>
                <div class="col-lg-12">
                    <p>
                        Keamanan data adalah prioritas utama dalam pengembangan SIPERPUS. Sistem ini dilengkapi dengan enkripsi tingkat enterprise, kontrol akses berbasis role, dan backup otomatis untuk memastikan integritas dan keamanan semua data yang tersimpan.
                    </p>
                </div>
                <div class="col-md-12">
                    <div class="img-text">
                        <img src="{{ asset('bookmaster/img/a2.jpg') }}" alt="Features" class="img-fluid float-left mr-20 mb-20">
                        <p>
                            Dukungan penuh terhadap berbagai format dokumen digital, media audio-visual, dan konten multimedia menjadikan SIPERPUS sebagai solusi yang fleksibel dan scalable. Tim support kami siap membantu 24/7 untuk memastikan sistem berjalan optimal dan memberikan pengalaman terbaik bagi semua pengguna.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Generic Content Area -->		
</div>
@endsection
