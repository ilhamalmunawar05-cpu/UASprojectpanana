@extends('layouts.app')

@section('page-title', 'Tambah Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-plus-circle"></i> Tambah Buku Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: Sistem Informasi Perpustakaan">
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="author" value="{{ old('author') }}" class="form-control @error('author') is-invalid @enderror" placeholder="Contoh: Budi Santoso">
                    @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" class="form-control @error('publisher') is-invalid @enderror" placeholder="Contoh: Penerbit Nasional">
                    @error('publisher')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="year" value="{{ old('year') }}" class="form-control @error('year') is-invalid @enderror" placeholder="2024" min="1900" max="{{ date('Y') }}">
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-control @error('stock') is-invalid @enderror" min="0">
                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control @error('isbn') is-invalid @enderror" placeholder="Contoh: 978-602-1234-56-7">
                    @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Rak</label>
                    <input type="text" name="rack" value="{{ old('rack') }}" class="form-control @error('rack') is-invalid @enderror" placeholder="Contoh: A1">
                    @error('rack')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gambar Sampul</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection
