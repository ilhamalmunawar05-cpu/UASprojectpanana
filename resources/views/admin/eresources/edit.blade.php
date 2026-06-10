@extends('layouts.app')

@section('page-title', 'Edit E-Resource')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-edit"></i> Edit E-Resource</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.eresources.update', $eresource) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Judul E-Resource</label>
                    <input type="text" name="title" value="{{ old('title', $eresource->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipe</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="ebook" {{ old('type', $eresource->type) == 'ebook' ? 'selected' : '' }}>E-Book</option>
                        <option value="journal" {{ old('type', $eresource->type) == 'journal' ? 'selected' : '' }}>Jurnal</option>
                        <option value="research_paper" {{ old('type', $eresource->type) == 'research_paper' ? 'selected' : '' }}>Makalah Penelitian</option>
                        <option value="multimedia" {{ old('type', $eresource->type) == 'multimedia' ? 'selected' : '' }}>Multimedia</option>
                        <option value="other" {{ old('type', $eresource->type) == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $eresource->category) }}" class="form-control @error('category') is-invalid @enderror">
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $eresource->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if($eresource->file_path)
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <strong>File Terkini:</strong> {{ basename($eresource->file_path) }}
                        <br><small>Upload file baru untuk mengganti file yang ada.</small>
                    </div>
                </div>
                @endif

                <div class="col-md-12">
                    <label class="form-label">Ganti File (Opsional)</label>
                    <input type="file" name="file" accept=".pdf,.epub,.doc,.docx,.zip" class="form-control @error('file') is-invalid @enderror">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah file.</small>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">URL Eksternal</label>
                    <input type="url" name="url" value="{{ old('url', $eresource->url) }}" class="form-control @error('url') is-invalid @enderror">
                    @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.eresources.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui E-Resource</button>
            </div>
        </form>
    </div>
</div>
@endsection
