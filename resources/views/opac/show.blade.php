@extends('layouts.bookmaster')

@section('title', $book->title)

@section('content')
<section class="section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $book->image_url }}" class="img-fluid mb-3" alt="cover">
                            </div>
                            <div class="col-md-8">
                                <h3 class="mb-2">{{ $book->title }}</h3>
                                <p class="text-muted mb-1">Penulis: {{ $book->author }}</p>
                                <p class="text-muted mb-1">Penerbit: {{ $book->publisher ?? '-' }} · {{ $book->year ?? '-' }}</p>
                                <p class="text-muted mb-1">ISBN: {{ $book->isbn ?? '-' }}</p>
                                <p class="text-muted mb-1">Kategori: {{ $book->category->name ?? '-' }}</p>
                                <p class="mb-2"><strong>Status:</strong>
                                    @if($book->stock > 0)
                                        <span class="text-success">Tersedia ({{ $book->stock }})</span>
                                    @else
                                        <span class="text-danger">Tidak tersedia</span>
                                    @endif
                                </p>
                                <hr>
                                <p>{{ $book->description ?? 'Deskripsi belum tersedia.' }}</p>

                                <div class="mt-3 d-flex gap-2">
                                    @auth
                                        @if(auth()->user()->member)
                                            @if($book->stock > 0)
                                                <a href="{{ route('user.loans') }}?book={{ $book->id }}" class="btn btn-primary">Pinjam</a>
                                            @else
                                                <button class="btn btn-primary" disabled>Tidak tersedia</button>
                                            @endif
                                        @else
                                            <a href="{{ route('user.member.edit') }}" class="btn btn-warning">Lengkapi Profil</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login', ['redirect' => route('user.loans') . '?book=' . $book->id]) }}" class="btn btn-outline-primary">Login untuk meminjam</a>
                                    @endauth

                                    <a href="{{ route('opac.index') }}" class="btn btn-outline-secondary">Kembali ke hasil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
