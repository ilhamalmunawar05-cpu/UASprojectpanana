@extends('layouts.app')

@section('page-title', 'Tambah Seniman')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Form Tambah Seniman & Kurator</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Nama --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="Masukkan nama seniman/kurator"
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
                        <option value="Seniman" {{ old('specialization') == 'Seniman' ? 'selected' : '' }}>Seniman</option>
                        <option value="Kurator" {{ old('specialization') == 'Kurator' ? 'selected' : '' }}>Kurator</option>
                        <option value="Pelukis" {{ old('specialization') == 'Pelukis' ? 'selected' : '' }}>Pelukis</option>
                        <option value="Pematung" {{ old('specialization') == 'Pematung' ? 'selected' : '' }}>Pematung</option>
                        <option value="Digital Artist" {{ old('specialization') == 'Digital Artist' ? 'selected' : '' }}>Digital Artist</option>
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
                              class="form-control @error('bio') is-invalid @enderror"
                              placeholder="Ceritakan tentang latar belakang, pendidikan, pengalaman, dan pencapaian seniman...">{{ old('bio') }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload Foto --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" 
                           name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Opsional.</small>
                    
                    {{-- Preview Image --}}
                    <div class="mt-2">
                        <img id="preview" src="" alt="Preview" style="max-width: 200px; display: none;" class="img-thumbnail rounded-circle">
                    </div>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="email@example.com">
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
                           value="{{ old('phone') }}" 
                           placeholder="+62 812 3456 7890">
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
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Seniman
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
