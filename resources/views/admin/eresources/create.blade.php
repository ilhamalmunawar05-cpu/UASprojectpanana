@extends('layouts.app')

@section('page-title', 'Tambah E-Resource')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-file-plus"></i> Tambah E-Resource Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.eresources.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Judul E-Resource</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Judul buku, jurnal, atau konten digital" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipe</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="ebook" {{ old('type') == 'ebook' ? 'selected' : '' }}>E-Book</option>
                        <option value="journal" {{ old('type') == 'journal' ? 'selected' : '' }}>Jurnal</option>
                        <option value="research_paper" {{ old('type') == 'research_paper' ? 'selected' : '' }}>Makalah Penelitian</option>
                        <option value="multimedia" {{ old('type') == 'multimedia' ? 'selected' : '' }}>Multimedia</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" value="{{ old('category') }}" class="form-control @error('category') is-invalid @enderror" placeholder="Contoh: Pemrograman, Sains, Teknologi">
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Deskripsi singkat tentang e-resource ini">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <div class="alert alert-info">
                        <strong>Pilih Salah Satu:</strong> Anda dapat mengupload file (PDF, EPUB, DOC, DOCX, ZIP max 100MB) ATAU masukkan URL eksternal.
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="file" accept=".pdf,.epub,.doc,.docx,.zip" class="form-control @error('file') is-invalid @enderror">
                    <small class="text-muted">Format: PDF, EPUB, DOC, DOCX, ZIP. Maksimal 100MB.</small>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">ATAU URL Eksternal</label>
                    <input type="url" name="url" value="{{ old('url') }}" class="form-control @error('url') is-invalid @enderror" placeholder="https://example.com/resource">
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.eresources.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan E-Resource</button>
            </div>
        </form>
    </div>
</div>
@endsection
