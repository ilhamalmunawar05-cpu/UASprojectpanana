@extends('layouts.app')
@section('page-title', 'Edit Artikel')
@section('content')
<div class="card">
    <div class="card-header"><h4>Form Edit Artikel</h4></div>
    <div class="card-body">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label>Judul Artikel <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $article->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kategori <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="kritik" {{ old('category', $article->category) == 'kritik' ? 'selected' : '' }}>Kritik</option>
                        <option value="ulasan" {{ old('category', $article->category) == 'ulasan' ? 'selected' : '' }}>Ulasan</option>
                        <option value="berita" {{ old('category', $article->category) == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="tutorial" {{ old('category', $article->category) == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label>Konten Artikel <span class="text-danger">*</span></label>
                    <textarea name="content" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($article->image)
                <div class="col-md-12 mb-3">
                    <label>Gambar Saat Ini</label><br>
                    <img src="{{ asset('storage/' . $article->image) }}" style="max-width:300px;" class="img-thumbnail">
                </div>
                @endif

                <div class="col-md-6 mb-3">
                    <label>Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Karya Terkait</label>
                    <select name="artwork_id" class="form-select">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($artworks as $artwork)
                            <option value="{{ $artwork->id }}" {{ old('artwork_id', $article->artwork_id) == $artwork->id ? 'selected' : '' }}>
                                {{ $artwork->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="published" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="published">Publikasikan</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update Artikel</button>
            </div>
        </form>
    </div>
</div>
@endsection
