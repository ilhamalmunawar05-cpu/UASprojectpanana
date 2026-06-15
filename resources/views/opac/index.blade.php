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
                                <div class="row g-0">
                                    <div class="col-4">
                                        <img src="{{ $book->image_url }}" class="img-fluid rounded-start" alt="cover">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $book->title }}</h6>
                                            <p class="card-text text-muted small mb-1">{{ $book->author }}</p>
                                            <p class="small text-muted mb-2">ISBN: {{ $book->isbn ?? '-' }}</p>
                                            <p class="mb-2"><small class="text-" style="color:#6c757d">Kategori: {{ $book->category->name ?? '-' }}</small></p>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('opac.show', $book->id) }}" class="btn btn-outline-primary btn-sm">Lihat Detail</a>
                                                @if(Route::has('user.loans'))
                                                    <a href="{{ route('user.loans') }}?book={{ $book->id }}" class="btn btn-sm btn-success">Pinjam</a>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>{{ $book->stock > 0 ? 'Tersedia' : 'Kosong' }}</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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
