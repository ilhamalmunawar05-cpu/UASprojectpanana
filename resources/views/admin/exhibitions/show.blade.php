@extends('layouts.app')

@section('page-title', 'Detail Pameran')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-calendar-alt"></i> {{ $exhibition->title }}</h4>
                <div>
                    <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.exhibitions.destroy', $exhibition) }}" 
                          method="POST" 
                          style="display: inline;"
                          onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($exhibition->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $exhibition->image) }}" 
                             alt="{{ $exhibition->title }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 400px;">
                    </div>
                @endif

                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $exhibition->id }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $exhibition->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $exhibition->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $exhibition->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $exhibition->start_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $exhibition->end_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td>{{ $exhibition->start_date->diffInDays($exhibition->end_date) }} hari</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($exhibition->status == 'upcoming')
                                <span class="badge bg-info">Upcoming</span>
                            @elseif($exhibition->status == 'ongoing')
                                <span class="badge bg-success">Ongoing</span>
                            @else
                                <span class="badge bg-secondary">Completed</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $exhibition->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('exhibitions.show', $exhibition) }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-external-link-alt"></i> Lihat di Halaman Public
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Karya yang Dipamerkan ({{ $exhibition->artworks()->count() }})</h6>
            </div>
            <div class="card-body">
                @forelse($exhibition->artworks as $artwork)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <img src="{{ asset('storage/' . $artwork->image) }}" 
                             alt="{{ $artwork->title }}" 
                             class="rounded me-3"
                             style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <strong>{{ $artwork->title }}</strong><br>
                            <small class="text-muted">{{ $artwork->artist->name }}</small><br>
                            <a href="{{ route('admin.artworks.show', $artwork) }}" class="btn btn-sm btn-outline-primary mt-1">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-3">
                        <i class="fas fa-image fa-2x mb-2"></i><br>
                        Belum ada karya yang dipamerkan
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection