@extends('layouts.app')

@section('page-title', 'Manajemen Seniman & Kurator')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-users"></i> Daftar Seniman & Kurator</h4>
        <a href="{{ route('admin.artists.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Seniman
        </a>
    </div>
    <div class="card-body">
        {{-- Search Form --}}
        <form action="{{ route('admin.artists.index') }}" method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama seniman..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="specialization" class="form-select">
                        <option value="">Semua Spesialisasi</option>
                        <option value="Seniman" {{ request('specialization') == 'Seniman' ? 'selected' : '' }}>Seniman</option>
                        <option value="Kurator" {{ request('specialization') == 'Kurator' ? 'selected' : '' }}>Kurator</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.artists.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="10%">Foto</th>
                        <th width="20%">Nama</th>
                        <th width="15%">Spesialisasi</th>
                        <th width="20%">Kontak</th>
                        <th width="15%">Total Karya</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artists as $artist)
                    <tr>
                        <td>{{ $artist->id }}</td>
                        <td>
                            @if($artist->image)
                                <img src="{{ asset('storage/' . $artist->image) }}" 
                                     alt="{{ $artist->name }}" 
                                     class="rounded-circle"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $artist->name }}</strong>
                            @if($artist->bio)
                                <br><small class="text-muted">{{ Str::limit($artist->bio, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($artist->specialization)
                                <span class="badge bg-info">{{ $artist->specialization }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($artist->email)
                                <i class="fas fa-envelope"></i> {{ $artist->email }}<br>
                            @endif
                            @if($artist->phone)
                                <i class="fas fa-phone"></i> {{ $artist->phone }}
                            @endif
                            @if(!$artist->email && !$artist->phone)
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $artist->artworks()->count() }} Karya</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.artists.show', $artist) }}" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.artists.edit', $artist) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.artists.destroy', $artist) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus seniman ini? Semua karya terkait akan terhapus!')"
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
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data seniman</p>
                            <a href="{{ route('admin.artists.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Seniman Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $artists->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection