@extends('layouts.app')

@section('page-title', 'Detail Seniman')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($artist->image)
                    <img src="{{ asset('storage/' . $artist->image) }}" 
                         alt="{{ $artist->name }}" 
                         class="rounded-circle img-thumbnail mb-3"
                         style="width: 200px; height: 200px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-3" 
                         style="width: 200px; height: 200px;">
                        <i class="fas fa-user fa-5x"></i>
                    </div>
                @endif
                
                <h4>{{ $artist->name }}</h4>
                
                @if($artist->specialization)
                    <span class="badge bg-info mb-3">{{ $artist->specialization }}</span>
                @endif

                <div class="text-start">
                    @if($artist->email)
                        <p class="mb-2">
                            <i class="fas fa-envelope text-muted"></i> 
                            <a href="mailto:{{ $artist->email }}">{{ $artist->email }}</a>
                        </p>
                    @endif
                    
                    @if($artist->phone)
                        <p class="mb-2">
                            <i class="fas fa-phone text-muted"></i> {{ $artist->phone }}
                        </p>
                    @endif
                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.artists.edit', $artist) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                    <form action="{{ route('admin.artists.destroy', $artist) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Statistik</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Karya:</span>
                    <strong>{{ $artist->artworks()->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Karya Tersedia:</span>
                    <strong>{{ $artist->artworks()->where('status', 'available')->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Karya Terjual:</span>
                    <strong>{{ $artist->artworks()->where('status', 'sold')->count() }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Biografi</h5>
            </div>
            <div class="card-body">
                <p>{{ $artist->bio ?? 'Belum ada biografi.' }}</p>
                
                <table class="table table-bordered mt-3">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $artist->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><strong>{{ $artist->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Spesialisasi</th>
                        <td>{{ $artist->specialization ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $artist->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $artist->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Terdaftar</th>
                        <td>{{ $artist->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <a href="{{ route('admin.artists.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('artists.show', $artist) }}" target="_blank" class="btn btn-info">
                    <i class="fas fa-external-link-alt"></i> Lihat di Halaman Public
                </a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Karya Seni ({{ $artist->artworks()->count() }})</h5>
                <a href="{{ route('admin.artworks.create') }}?artist_id={{ $artist->id }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Karya
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($artist->artworks as $artwork)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $artwork->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $artwork->title }}"
                                 style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($artwork->title, 30) }}</h6>
                                <p class="small mb-2">
                                    <span class="badge bg-{{ $artwork->status == 'available' ? 'success' : ($artwork->status == 'sold' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($artwork->status) }}
                                    </span>
                                </p>
                                <a href="{{ route('admin.artworks.show', $artwork) }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                        <p class="text-muted">Belum ada karya seni</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection