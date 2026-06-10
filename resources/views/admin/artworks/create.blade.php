@extends('layouts.app')

@section('page-title', 'Tambah Karya Seni')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Form Tambah Karya Seni</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.artworks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Judul --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Judul Karya <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" 
                           placeholder="Masukkan judul karya seni"
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
                            <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('artist_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Belum ada? <a href="{{ route('admin.artists.create') }}" target="_blank">Tambah Seniman Baru</a>
                    </small>
                </div>

                {{-- Deskripsi --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" 
                              rows="4" 
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Deskripsi tentang karya seni ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Gambar Karya Seni <span class="text-danger">*</span></label>
                    <input type="file" 
                           name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*"
                           onchange="previewImage(event)"
                           required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    
                    {{-- Preview Image --}}
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
                           value="{{ old('year') }}" 
                           min="1800" 
                           max="{{ date('Y') }}"
                           placeholder="{{ date('Y') }}">
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
                           value="{{ old('medium') }}" 
                           placeholder="Oil, Acrylic, Digital">
                    @error('medium')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Contoh: Oil Painting, Watercolor, Digital Art</small>
                </div>

                {{-- Dimensi --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Dimensi</label>
                    <input type="text" 
                           name="dimensions" 
                           class="form-control @error('dimensions') is-invalid @enderror" 
                           value="{{ old('dimensions') }}" 
                           placeholder="100 x 150 cm">
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
                           value="{{ old('price') }}" 
                           min="0"
                           placeholder="0">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Kosongkan jika tidak dijual</small>
                </div>

                {{-- Status --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="available" 
                               value="available" {{ old('status', 'available') == 'available' ? 'checked' : '' }}>
                        <label class="form-check-label" for="available">
                            <strong>Available</strong> - Tersedia untuk dijual/dipamerkan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="on_display" 
                               value="on_display" {{ old('status') == 'on_display' ? 'checked' : '' }}>
                        <label class="form-check-label" for="on_display">
                            <strong>On Display</strong> - Sedang dipamerkan
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="sold" 
                               value="sold" {{ old('status') == 'sold' ? 'checked' : '' }}>
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
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Karya Seni
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
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
@endsection
