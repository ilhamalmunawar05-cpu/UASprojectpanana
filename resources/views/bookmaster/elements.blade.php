@extends('layouts.bookmaster')

@section('title', 'Elements - SIPERPUS')
@section('meta_description', 'UI Elements and Components - SIPERPUS')

@section('content')
<!-- Start banner Area -->
<section class="generic-banner">				
    <div class="container">
        <div class="row height align-items-center justify-content-center">
            <div class="col-lg-10">
                <div class="generic-banner-content">
                    <h2 class="text-white">UI Elements & Components</h2>
                    <p class="text-white">Koleksi elemen dan komponen UI yang tersedia di SIPERPUS <br> untuk membantu pengembangan dan customization</p>
                </div>
            </div>
        </div>
    </div>
</section>		
<!-- End banner Area -->

<!-- Start Sample Area -->
<section class="sample-text-area">
    <div class="container">
        <h3 class="text-heading">Text Formatting Sample</h3>
        <p class="sample-text">
            SIPERPUS menyediakan berbagai elemen dasar untuk formatting teks. Anda dapat menggunakan <b>Bold</b> untuk penekanan, <i>Italic</i> untuk kemiringan, <sup>Superscript</sup> untuk karakter atas, <sub>Subscript</sub> untuk karakter bawah. Untuk menghapus teks gunakan <del>Strike through</del> dan untuk garis bawah gunakan <u>"Underline"</u>. Semua elemen ini dirancang untuk memberikan fleksibilitas maksimal dalam presentasi konten.
        </p>
    </div>
</section>
<!-- End Sample Area -->

<!-- Start Button -->
<section class="button-area">
    <div class="container border-top-generic">
        <h3 class="text-heading">Sample Buttons</h3>
        
        <div class="button-group-area">
            <h5 class="mb-3">Solid Buttons</h5>
            <a href="#" class="genric-btn default">Default</a>
            <a href="#" class="genric-btn primary">Primary</a>
            <a href="#" class="genric-btn success">Success</a>
            <a href="#" class="genric-btn info">Info</a>
            <a href="#" class="genric-btn warning">Warning</a>
            <a href="#" class="genric-btn danger">Danger</a>
        </div>

        <div class="button-group-area mt-40">
            <h5 class="mb-3">Border Buttons</h5>
            <a href="#" class="genric-btn default-border">Default</a>
            <a href="#" class="genric-btn primary-border">Primary</a>
            <a href="#" class="genric-btn success-border">Success</a>
            <a href="#" class="genric-btn info-border">Info</a>
            <a href="#" class="genric-btn warning-border">Warning</a>
            <a href="#" class="genric-btn danger-border">Danger</a>
        </div>

        <div class="button-group-area mt-40">
            <h5 class="mb-3">Rounded Buttons</h5>
            <a href="#" class="genric-btn primary radius">Primary</a>
            <a href="#" class="genric-btn success radius">Success</a>
            <a href="#" class="genric-btn info radius">Info</a>
            <a href="#" class="genric-btn warning radius">Warning</a>
        </div>

        <div class="button-group-area mt-40">
            <h5 class="mb-3">Circle Buttons with Arrow</h5>
            <a href="#" class="genric-btn primary circle arrow">Primary<span class="lnr lnr-arrow-right"></span></a>
            <a href="#" class="genric-btn success circle arrow">Success<span class="lnr lnr-arrow-right"></span></a>
            <a href="#" class="genric-btn info circle arrow">Info<span class="lnr lnr-arrow-right"></span></a>
        </div>

        <div class="button-group-area mt-40">
            <h5 class="mb-3">Button Sizes</h5>
            <a href="#" class="genric-btn primary e-large">Extra Large</a>
            <a href="#" class="genric-btn success large">Large</a>
            <a href="#" class="genric-btn primary">Default</a>
            <a href="#" class="genric-btn success medium">Medium</a>
            <a href="#" class="genric-btn primary small">Small</a>
        </div>
    </div>
</section>
<!-- End Button -->

<!-- Start Content Align Area -->
<div class="whole-wrap">
    <div class="container">
        <div class="section-top-border">
            <h3 class="mb-30">Aligned Content</h3>
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('bookmaster/img/elements/d.jpg') }}" alt="" class="img-fluid">
                </div>
                <div class="col-md-9 mt-sm-20">
                    <p>SIPERPUS menggunakan layout grid yang fleksibel untuk memastikan konten ditampilkan dengan optimal di berbagai ukuran layar. Sistem ini mendukung alignment berbeda seperti left-aligned, center-aligned, dan right-aligned content sesuai dengan kebutuhan desain Anda. Dengan menggunakan Bootstrap grid system, semua elemen dapat disesuaikan dengan mudah.</p>
                </div>
            </div>
        </div>

        <div class="section-top-border text-right">
            <h3 class="mb-30">Right Aligned Content</h3>
            <div class="row">
                <div class="col-md-9">
                    <p class="text-right">Konten yang rata kanan memerlukan perhatian khusus terhadap readability dan user experience. SIPERPUS memastikan bahwa semua konten tetap mudah dibaca dan accessible pada semua perangkat. Dukungan terhadap responsive design membuat website Anda dapat diakses dengan sempurna dari desktop, tablet, maupun smartphone.</p>
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('bookmaster/img/elements/d.jpg') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="section-top-border">
            <h3 class="mb-30">Definisi & Deskripsi</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="single-defination">
                        <h4 class="mb-20">Modul Perpustakaan</h4>
                        <p>Manajemen lengkap untuk koleksi buku, e-book, dan materi referensi perpustakaan. Fitur katalog digital, pencarian advanced, dan sistem peminjaman terintegrasi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-defination">
                        <h4 class="mb-20">Modul Museum</h4>
                        <p>Sistem manajemen untuk koleksi museum, artefak, dan display. Termasuk perencanaan pameran, inventory management, dan dokumentasi karya seni.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-defination">
                        <h4 class="mb-20">Portal Publik</h4>
                        <p>Interface user-friendly untuk pengunjung dan peneliti mengakses katalog online, mengikuti pameran virtual, dan berinteraksi dengan konten digital.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-top-border">
            <h3 class="mb-30">Block Quotes</h3>
            <div class="row">
                <div class="col-lg-12">
                    <blockquote class="generic-blockquote">
                        "SIPERPUS adalah solusi terintegrasi yang menggabungkan kekuatan perpustakaan digital dengan manajemen museum modern. Dengan teknologi terkini dan interface yang user-friendly, kami membantu institusi budaya memberikan pengalaman terbaik kepada pengunjung dan peneliti."
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="section-top-border">
            <h3 class="mb-30">Fitur Data Table</h3>
            <div class="progress-table-wrap">
                <div class="progress-table">
                    <div class="table-head">
                        <div class="serial">#</div>
                        <div class="country">Modul</div>
                        <div class="visit">Status</div>
                        <div class="percentage">Progress</div>
                    </div>
                    <div class="table-row">
                        <div class="serial">01</div>
                        <div class="country">Perpustakaan</div>
                        <div class="visit">Active</div>
                        <div class="percentage">
                            <div class="progress">
                                <div class="progress-bar color-1" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-row">
                        <div class="serial">02</div>
                        <div class="country">Museum</div>
                        <div class="visit">Active</div>
                        <div class="percentage">
                            <div class="progress">
                                <div class="progress-bar color-2" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-row">
                        <div class="serial">03</div>
                        <div class="country">Pameran</div>
                        <div class="visit">Active</div>
                        <div class="percentage">
                            <div class="progress">
                                <div class="progress-bar color-3" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-row">
                        <div class="serial">04</div>
                        <div class="country">E-Resource</div>
                        <div class="visit">In Progress</div>
                        <div class="percentage">
                            <div class="progress">
                                <div class="progress-bar color-4" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-row">
                        <div class="serial">05</div>
                        <div class="country">Analytics</div>
                        <div class="visit">In Progress</div>
                        <div class="percentage">
                            <div class="progress">
                                <div class="progress-bar color-5" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-top-border">
            <h3>Galeri Gambar</h3>
            <div class="row gallery-item">
                <div class="col-md-4">
                    <a href="{{ asset('bookmaster/img/elements/g1.jpg') }}" class="img-pop-up">
                        <div class="single-gallery-image" style="background: url({{ asset('bookmaster/img/elements/g1.jpg') }});"></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ asset('bookmaster/img/elements/g2.jpg') }}" class="img-pop-up">
                        <div class="single-gallery-image" style="background: url({{ asset('bookmaster/img/elements/g2.jpg') }});"></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ asset('bookmaster/img/elements/g3.jpg') }}" class="img-pop-up">
                        <div class="single-gallery-image" style="background: url({{ asset('bookmaster/img/elements/g3.jpg') }});"></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="section-top-border">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="mb-20">Typography</h3>
                    <div class="typography">
                        <h1>Header 1</h1>
                        <h2>Header 2</h2>
                        <h3>Header 3</h3>
                        <h4>Header 4</h4>
                        <h5>Header 5</h5>
                        <h6>Header 6</h6>
                    </div>
                </div>
                <div class="col-md-4 mt-sm-30">
                    <h3 class="mb-20">Unordered List</h3>
                    <div class="">
                        <ul class="unordered-list">
                            <li>Fitur Perpustakaan</li>
                            <li>Manajemen Koleksi
                                <ul>
                                    <li>Katalog Digital
                                        <ul>
                                            <li>Pencarian Lanjutan</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>Sistem Peminjaman</li>
                            <li>E-Resource</li>
                            <li>Reporting & Analytics</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 mt-sm-30">
                    <h3 class="mb-20">Ordered List</h3>
                    <div class="">
                        <ol class="ordered-list">
                            <li><span>Registrasi Pengguna</span></li>
                            <li><span>Login ke Sistem</span></li>
                            <li><span>Akses Katalog</span>
                                <ol class="ordered-list-alpha">
                                    <li><span>Cari Koleksi</span>
                                        <ol class="ordered-list-roman">
                                            <li><span>Filter Hasil</span></li>
                                        </ol>
                                    </li>
                                </ol>
                            </li>
                            <li><span>Pinjam Item</span></li>
                            <li><span>Kembalikan Item</span></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content Area -->

@endsection

@section('extra_js')
<script src="{{ asset('bookmaster/js/jquery.magnific-popup.min.js') }}"></script>
<script>
    // Initialize magnific popup for gallery
    $('.img-pop-up').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });
</script>
@endsection
