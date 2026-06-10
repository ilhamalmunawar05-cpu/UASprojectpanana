@extends('layouts.app')

@section('page-title', 'Edit Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-edit"></i> Edit Buku</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.books.update', $book) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" class="form-control @error('title') is-invalid @enderror">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', $book->author) }}" class="form-control @error('author') is-invalid @enderror">
                    @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="form-control @error('publisher') is-invalid @enderror">
                    @error('publisher')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="year" value="{{ old('year', $book->year) }}" class="form-control @error('year') is-invalid @enderror" min="1900" max="{{ date('Y') }}">
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $book->stock) }}" class="form-control @error('stock') is-invalid @enderror" min="0">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="form-control @error('isbn') is-invalid @enderror">
                    @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Rak</label>
                    <input type="text" name="rack" value="{{ old('rack', $book->rack) }}" class="form-control @error('rack') is-invalid @enderror">
                    @error('rack')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Perbarui Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection
