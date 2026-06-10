@extends('layouts.app')

@section('title', 'Manajemen Karya Seni')

@section('page-title', 'Manajemen Karya Seni')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-image"></i> Daftar Karya Seni</h5>
        <a href="{{ route('admin.artworks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Karya Seni
        </a>
    </div>
    <div class="card-body">
        {{-- Search Form --}}
        <form action="{{ route('admin.artworks.index') }}" method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari judul..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="artist_id" class="form-select">
                        <option value="">Semua Seniman</option>
                        @foreach(\App\Models\Artist::all() as $artist)
                            <option value="{{ $artist->id }}" {{ request('artist_id') == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="on_display" {{ request('status') == 'on_display' ? 'selected' : '' }}>On Display</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.artworks.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Gambar</th>
                        <th width="20%">Judul</th>
                        <th width="15%">Seniman</th>
                        <th width="10%">Tahun</th>
                        <th width="10%">Medium</th>
                        <th width="10%">Harga</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $artwork)
                    <tr>
                        <td>{{ $artwork->id }}</td>
                        <td>
                            @if($artwork->image)
                                <img src="{{ asset('storage/' . $artwork->image) }}" 
                                     alt="{{ $artwork->title }}" 
                                     class="img-thumbnail"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div style="width: 80px; height: 80px; background: #ddd;" class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $artwork->title }}</strong>
                            @if($artwork->dimensions ?? false)
                                <br><small class="text-muted">{{ $artwork->dimensions }}</small>
                            @endif
                        </td>
                        <td>{{ $artwork->artist->name ?? '-' }}</td>
                        <td>{{ $artwork->year ?? '-' }}</td>
                        <td>{{ $artwork->medium ?? '-' }}</td>
                        <td>
                            @if($artwork->price)
                                <strong>Rp {{ number_format($artwork->price, 0, ',', '.') }}</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($artwork->status == 'available')
                                <span class="badge bg-success">Available</span>
                            @elseif($artwork->status == 'sold')
                                <span class="badge bg-danger">Sold</span>
                            @elseif($artwork->status == 'on_display')
                                <span class="badge bg-warning text-dark">On Display</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($artwork->status ?? 'draft') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.artworks.show', $artwork->id) }}" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.artworks.edit', $artwork->id) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.artworks.destroy', $artwork->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus karya ini?')"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data karya seni</p>
                            <a href="{{ route('admin.artworks.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Karya Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $items->appends(request()->query())->links() }}
        </div>

        {{-- Info Total --}}
        <div class="text-muted small mt-2">
            Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} 
            dari {{ $items->total() }} total karya seni
        </div>
    </div>
</div>
@endsection