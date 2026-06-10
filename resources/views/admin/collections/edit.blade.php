@extends('layouts.app')
@section('page-title', 'Edit Koleksi')
@section('content')
<div class="card">
    <div class="card-header"><h4>Form Edit Koleksi Museum</h4></div>
    <div class="card-body">
        <form action="{{ route('admin.collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Judul Koleksi <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $collection->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nomor Koleksi</label>
                        <input type="text" name="collection_number" class="form-control @error('collection_number') is-invalid @enderror" value="{{ old('collection_number', $collection->collection_number) }}">
                        @error('collection_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            <option value="arkeologi" {{ old('category', $collection->category) == 'arkeologi' ? 'selected' : '' }}>Arkeologi</option>
                            <option value="historika" {{ old('category', $collection->category) == 'historika' ? 'selected' : '' }}>Historika</option>
                            <option value="numismatika" {{ old('category', $collection->category) == 'numismatika' ? 'selected' : '' }}>Numismatika</option>
                            <option value="keramik" {{ old('category', $collection->category) == 'keramik' ? 'selected' : '' }}>Keramik</option>
                            <option value="etnografi" {{ old('category', $collection->category) == 'etnografi' ? 'selected' : '' }}>Etnografi</option>
                            <option value="seni_rupa" {{ old('category', $collection->category) == 'seni_rupa' ? 'selected' : '' }}>Seni Rupa</option>
                            <option value="lainnya" {{ old('category', $collection->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $collection->year) }}" placeholder="Contoh: 1945">
                        @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <select name="condition" class="form-select @error('condition') is-invalid @enderror">
                            <option value="">Pilih Kondisi</option>
                            <option value="baik" {{ old('condition', $collection->condition) == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="cukup" {{ old('condition', $collection->condition) == 'cukup' ? 'selected' : '' }}>Cukup</option>
                            <option value="rusak" {{ old('condition', $collection->condition) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                        @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $collection->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Asal Daerah</label>
                        <input type="text" name="origin" class="form-control @error('origin') is-invalid @enderror" value="{{ old('origin', $collection->origin) }}">
                        @error('origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Bahan</label>
                        <input type="text" name="material" class="form-control @error('material') is-invalid @enderror" value="{{ old('material', $collection->material) }}" placeholder="Contoh: Perunggu, Kayu, Kain">
                        @error('material')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Panjang (cm)</label>
                        <input type="number" step="0.01" name="length" class="form-control @error('length') is-invalid @enderror" value="{{ old('length', $collection->length) }}">
                        @error('length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Lebar (cm)</label>
                        <input type="number" step="0.01" name="width" class="form-control @error('width') is-invalid @enderror" value="{{ old('width', $collection->width) }}">
                        @error('width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tinggi (cm)</label>
                        <input type="number" step="0.01" name="height" class="form-control @error('height') is-invalid @enderror" value="{{ old('height', $collection->height) }}">
                        @error('height')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Koleksi</label>
                @if($collection->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $collection->image) }}" style="max-width:200px;max-height:200px;object-fit:cover;" class="rounded">
                </div>
                @endif
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar. Format: JPG, PNG, maksimal 2MB</small>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi Penyimpanan</label>
                <input type="text" name="storage_location" class="form-control @error('storage_location') is-invalid @enderror" value="{{ old('storage_location', $collection->storage_location) }}" placeholder="Contoh: Ruang Pamer 1, Gudang A">
                @error('storage_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_displayed" value="1" class="form-check-input" id="is_displayed" {{ old('is_displayed', $collection->is_displayed) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_displayed">Tampilkan di website publik</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Koleksi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection