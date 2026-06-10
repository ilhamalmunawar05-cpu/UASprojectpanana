@extends('layouts.app')

@section('page-title', 'Edit Seniman')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-edit"></i> Form Edit Seniman & Kurator</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.artists.update', $artist) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Nama --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $artist->name) }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Spesialisasi --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Spesialisasi</label>
                    <select name="specialization" class="form-select @error('specialization') is-invalid @enderror">
                        <option value="">-- Pilih Spesialisasi --</option>
                        <option value="Seniman" {{ old('specialization', $artist->specialization) == 'Seniman' ? 'selected' : '' }}>Seniman</option>
                        <option value="Kurator" {{ old('specialization', $artist->specialization) == 'Kurator' ? 'selected' : '' }}>Kurator</option>
                        <option value="Pelukis" {{ old('specialization', $artist->specialization) == 'Pelukis' ? 'selected' : '' }}>Pelukis</option>
                        <option value="Pematung" {{ old('specialization', $artist->specialization) == 'Pematung' ? 'selected' : '' }}>Pematung</option>
                        <option value="Digital Artist" {{ old('specialization', $artist->specialization) == 'Digital Artist' ? 'selected' : '' }}>Digital Artist</option>
                    </select>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Bio --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Biografi</label>
                    <textarea name="bio" 
                              rows="5" 
                              class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $artist->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto Saat Ini --}}
                @if($artist->image)
                <div class="col-md-12 mb-3">
                    <label class="form-label">Foto Profil Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $artist->image) }}" 
                             alt="{{ $artist->name }}" 
                             class="img-thumbnail rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>
                @endif

                {{-- Upload Foto Baru --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Ganti Foto Profil (Opsional)</label>
                    <input type="file" 
                           name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                    
                    <div class="mt-2">
                        <img id="preview" src="" alt="Preview" style="max-width: 150px; display: none;" class="img-thumbnail rounded-circle">
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $artist->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" 
                           name="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $artist->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="{{ route('admin.artists.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="{{ route('admin.artists.show', $artist) }}" class="btn btn-outline-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Seniman
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