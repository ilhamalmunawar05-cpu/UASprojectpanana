@extends('layouts.app')

@section('page-title', 'Edit Karya Seni')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Form Edit Karya Seni</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Judul --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Judul Karya <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $artwork->title) }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Seniman --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Seniman <span class="text-danger">*</span></label>
                    <select name="artist_id" class="form-select @error('artist_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Seniman --</option>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" 
                                {{ old('artist_id', $artwork->artist_id) == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('artist_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" 
                              rows="4" 
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $artwork->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gambar Saat Ini --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $artwork->image) }}" 
                             alt="{{ $artwork->title }}" 
                             class="img-thumbnail"
                             style="max-width: 300px;">
                    </div>
                </div>

                {{-- Upload Gambar Baru --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Ganti Gambar (Opsional)</label>
                    <input type="file" 
                           name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                    
                    {{-- Preview Image Baru --}}
                    <div class="mt-2">
                        <img id="preview" src="" alt="Preview" style="max-width: 300px; display: none;" class="img-thumbnail">
                    </div>
                </div>

                {{-- Tahun --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tahun Pembuatan</label>
                    <input type="number" 
                           name="year" 
                           class="form-control @error('year') is-invalid @enderror" 
                           value="{{ old('year', $artwork->year) }}" 
                           min="1800" 
                           max="{{ date('Y') }}">
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Medium --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Medium/Teknik</label>
                    <input type="text" 
                           name="medium" 
                           class="form-control @error('medium') is-invalid @enderror" 
                           value="{{ old('medium', $artwork->medium) }}">
                    @error('medium')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dimensi --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Dimensi</label>
                    <input type="text" 
                           name="dimensions" 
                           class="form-control @error('dimensions') is-invalid @enderror" 
                           value="{{ old('dimensions', $artwork->dimensions) }}">
                    @error('dimensions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" 
                           name="price" 
                           class="form-control @error('price') is-invalid @enderror" 
                           value="{{ old('price', $artwork->price) }}" 
                           min="0">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="available" 
                               value="available" {{ old('status', $artwork->status) == 'available' ? 'checked' : '' }}>
                        <label class="form-check-label" for="available">
                            <strong>Available</strong> - Tersedia untuk dijual/dipamerkan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="on_display" 
                               value="on_display" {{ old('status', $artwork->status) == 'on_display' ? 'checked' : '' }}>
                        <label class="form-check-label" for="on_display">
                            <strong>On Display</strong> - Sedang dipamerkan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="sold" 
                               value="sold" {{ old('status', $artwork->status) == 'sold' ? 'checked' : '' }}>
                        <label class="form-check-label" for="sold">
                            <strong>Sold</strong> - Sudah terjual
                        </label>
                    </div>
                    @error('status')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        {{-- Action Buttons --}}
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.artworks.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div>
                <a href="{{ route('admin.artworks.show', $artwork) }}" class="btn btn-outline-info">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Karya Seni
                </button>
            </div>
        </div>
    </form>
</div>
</div>
@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection</parameter>