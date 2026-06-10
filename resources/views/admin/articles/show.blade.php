@extends('layouts.app')

@section('page-title', 'Detail Artikel')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-newspaper"></i> {{ $article->title }}</h4>
                <div>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" 
                          method="POST" 
                          style="display: inline;"
                          onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                {{-- Gambar --}}
                @if($article->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $article->image) }}" 
                             alt="{{ $article->title }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 400px;">
                    </div>
                @endif

                {{-- Informasi Detail --}}
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $article->id }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $article->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $article->author->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($article->category ?? '-') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($article->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning">Draft</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Karya Terkait</th>
                        <td>
                            @if($article->artwork)
                                <a href="{{ route('admin.artworks.show', $article->artwork) }}">
                                    {{ $article->artwork->title }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $article->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui</th>
                        <td>{{ $article->updated_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">Konten Artikel</h6>
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('articles.show', $article->id) }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-external-link-alt"></i> Lihat di Halaman Public
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Statistik</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Status:</span>
                    <strong>{{ $article->is_published ? 'Published' : 'Draft' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Kategori:</span>
                    <strong>{{ ucfirst($article->category ?? '-') }}</strong>
                </div>
            </div>
        </div>

        @if($article->artwork)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Karya Terkait</h6>
            </div>
            <div class="card-body text-center">
                @if($article->artwork->image)
                    <img src="{{ asset('storage/' . $article->artwork->image) }}" 
                         alt="{{ $article->artwork->title }}" 
                         class="img-fluid rounded mb-2"
                         style="max-height: 150px;">
                @endif
                <h6>{{ $article->artwork->title }}</h6>
                <a href="{{ route('admin.artworks.show', $article->artwork) }}" class="btn btn-sm btn-outline-primary">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
