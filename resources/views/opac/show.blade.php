@extends('layouts.bookmaster')

@section('title', $book->title)

@section('content')
<section class="section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="mb-2">{{ $book->title }}</h3>
                        <p class="text-muted mb-1">Penulis: {{ $book->author }}</p>
                        <p class="text-muted mb-1">Penerbit: {{ $book->publisher ?? '-' }}</p>
                        <p class="text-muted mb-1">ISBN: {{ $book->isbn ?? '-' }}</p>
                        <hr>
                        <p>{{ $book->description ?? 'Deskripsi belum tersedia.' }}</p>

                        <div class="mt-3">
                            <a href="{{ route('opac.index') }}" class="btn btn-outline-secondary">Kembali ke hasil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
