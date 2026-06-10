@extends('layouts.app')

@section('page-title', 'Manajemen E-Resources')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0"><i class="fas fa-file-pdf"></i> Daftar E-Resources</h4>
            <small class="text-muted">Kelola koleksi e-books, jurnal, dan konten digital lainnya.</small>
        </div>
        <a href="{{ route('admin.eresources.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah E-Resource
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Kategori</th>
                        <th>Upload Oleh</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resources as $resource)
                    <tr>
                        <td>{{ $resource->id }}</td>
                        <td>
                            <strong>{{ $resource->title }}</strong>
                            @if($resource->file_path)
                                <br><small class="badge bg-info">File: PDF/DOC</small>
                            @elseif($resource->url)
                                <br><small class="badge bg-success">URL Link</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $resource->type === 'ebook' ? 'primary' : ($resource->type === 'journal' ? 'info' : ($resource->type === 'research_paper' ? 'warning' : 'secondary')) }}">
                                {{ ucfirst(str_replace('_', ' ', $resource->type)) }}
                            </span>
                        </td>
                        <td>{{ $resource->category ?? '-' }}</td>
                        <td>{{ $resource->uploadedBy->name ?? '-' }}</td>
                        <td class="text-end">
                            @if($resource->file_path)
                                <a href="{{ asset('storage/' . $resource->file_path) }}" class="btn btn-sm btn-outline-primary me-1" download title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                            @elseif($resource->url)
                                <a href="{{ $resource->url }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Buka URL">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                            <a href="{{ route('admin.eresources.edit', $resource) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.eresources.destroy', $resource) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus e-resource ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Belum ada e-resource. Silakan tambahkan konten baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $resources->links() }}
    </div>
</div>
@endsection
