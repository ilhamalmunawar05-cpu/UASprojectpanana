@extends('layouts.app')

@section('page-title', 'Manajemen Pameran')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-calendar-alt"></i> Daftar Pameran</h4>
        <a href="{{ route('admin.exhibitions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pameran
        </a>
    </div>
    <div class="card-body">
        {{-- Search & Filter --}}
        <form action="{{ route('admin.exhibitions.index') }}" method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari judul pameran..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-outline-secondary">Reset</a>
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
                        <th width="25%">Judul</th>
                        <th width="15%">Lokasi</th>
                        <th width="20%">Periode</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exhibitions as $exhibition)
                    <tr>
                        <td>{{ $exhibition->id }}</td>
                        <td>
                            @if($exhibition->image)
                                <img src="{{ asset('storage/' . $exhibition->image) }}" 
                                     alt="{{ $exhibition->title }}" 
                                     class="img-thumbnail"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-calendar-alt fa-2x text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $exhibition->title }}</strong>
                            @if($exhibition->description)
                                <br><small class="text-muted">{{ Str::limit($exhibition->description, 60) }}</small>
                            @endif
                        </td>
                        <td>{{ $exhibition->location ?? '-' }}</td>
                        <td>
                            <small>
                                <i class="fas fa-calendar"></i> {{ $exhibition->start_date->format('d M Y') }}<br>
                                <i class="fas fa-arrow-right"></i> {{ $exhibition->end_date->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            @if($exhibition->status == 'upcoming')
                                <span class="badge bg-info">Upcoming</span>
                            @elseif($exhibition->status == 'ongoing')
                                <span class="badge bg-success">Ongoing</span>
                            @else
                                <span class="badge bg-secondary">Completed</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.exhibitions.show', $exhibition) }}" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.exhibitions.destroy', $exhibition) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus pameran ini?')"
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
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data pameran</p>
                            <a href="{{ route('admin.exhibitions.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Pameran Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $exhibitions->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection