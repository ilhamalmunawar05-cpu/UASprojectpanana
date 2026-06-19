<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - SIPERPUS</title>
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
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>FAQ - Pertanyaan yang Sering Diajukan</h1>
                <p class="lead">Temukan jawaban atas pertanyaan umum seputar layanan perpustakaan dan penggunaan SIPERPUS.</p>

                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Bagaimana cara mendaftar sebagai anggota?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Klik tombol "Daftar" pada halaman utama, lalu lengkapi formulir pendaftaran.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Bagaimana cara meminjam buku?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Cari buku di OPAC, lalu klik tombol "Pinjam". Pastikan profil anggota Anda sudah lengkap.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Mengapa saya tidak bisa melihat E-Resources?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pastikan Anda login. Jika sudah login, cobalah refresh halaman atau hubungi admin untuk memastikan konten tersedia.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
