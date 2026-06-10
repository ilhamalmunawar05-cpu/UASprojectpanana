@extends('layouts.app')

@section('page-title', 'Tambah Pameran')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Form Tambah Pameran</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.exhibitions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Judul --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Judul Pameran <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" 
                           placeholder="Masukkan judul pameran"
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming (Akan Datang)</option>
                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing (Sedang Berlangsung)</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi Pameran</label>
                    <textarea name="description" 
                              rows="4" 
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Deskripsi lengkap tentang pameran ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Lokasi Pameran</label>
                    <input type="text" 
                           name="location" 
                           class="form-control @error('location') is-invalid @enderror" 
                           value="{{ old('location') }}" 
                           placeholder="Galeri Nasional Indonesia, Jakarta">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" 
                           name="start_date" 
                           class="form-control @error('start_date') is-invalid @enderror" 
                           value="{{ old('start_date') }}"
                           required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="date" 
                           name="end_date" 
                           class="form-control @error('end_date') is-invalid @enderror" 
                           value="{{ old('end_date') }}"
                           required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Gambar Pameran</label>
                    <input type="file" 
                           name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Opsional.</small>
                    
                    <div class="mt-2">
                        <img id="preview" src="" alt="Preview" style="max-width: 300px; display: none;" class="img-thumbnail">
                    </div>
                </div>

                {{-- Pilih Karya Seni yang Dipamerkan --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Karya Seni yang Dipamerkan (Opsional)</label>
                    <select name="artworks[]" class="form-select @error('artworks') is-invalid @enderror" multiple size="8">
                        @foreach($artworks as $artwork)
                            <option value="{{ $artwork->id }}" 
                                {{ (is_array(old('artworks')) && in_array($artwork->id, old('artworks'))) ? 'selected' : '' }}>
                                {{ $artwork->title }} - {{ $artwork->artist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('artworks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Tekan CTRL (Windows) atau CMD (Mac) untuk memilih lebih dari satu karya
                    </small>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pameran
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
@endsection
