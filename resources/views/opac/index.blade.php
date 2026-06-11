@extends('layouts.bookmaster')

@section('title', 'OPAC - Pencarian Koleksi')

@section('content')
<section class="section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('opac.index') }}" class="d-flex gap-2">
                            <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Cari judul, penulis, atau ISBN...">
                            <button class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    @forelse($books as $book)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $book->title }}</h5>
                                    <p class="card-text text-muted">{{ $book->author }}</p>
                                    <p class="small text-muted">ISBN: {{ $book->isbn ?? '-' }}</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Tidak ada hasil pencarian.</div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-3">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
