@extends('layouts.public')
@section('title', $exhibition->title)
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exhibitions.public') }}">Pameran</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($exhibition->title, 50) }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            @if($exhibition->image)
                <img src="{{ asset('storage/' . $exhibition->image) }}" class="img-fluid rounded shadow mb-4" alt="{{ $exhibition->title }}">
            @endif

            <h1 class="mb-3">{{ $exhibition->title }}</h1>
            
            <div class="mb-4">
                <span class="badge bg-{{ $exhibition->status == 'ongoing' ? 'success' : ($exhibition->status == 'upcoming' ? 'info' : 'secondary') }} fs-6">
                    {{ ucfirst($exhibition->status) }}
                </span>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5><i class="fas fa-info-circle"></i> Informasi Pameran</h5>
                    <hr>
                    <p><strong>Lokasi:</strong> {{ $exhibition->location ?? 'TBA' }}</p>
                    <p><strong>Periode:</strong> {{ $exhibition->start_date->format('d F Y') }} - {{ $exhibition->end_date->format('d F Y') }}</p>
                    <p><strong>Durasi:</strong> {{ $exhibition->start_date->diffInDays($exhibition->end_date) }} hari</p>
                </div>
            </div>

            @if($exhibition->description)
                <div class="card">
                    <div class="card-body">
                        <h5><i class="fas fa-align-left"></i> Deskripsi</h5>
                        <hr>
                        <p style="white-space: pre-line;">{{ $exhibition->description }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Karya yang Dipamerkan ({{ $exhibition->artworks->count() }})</h6>
                </div>
                <div class="card-body">
                    @forelse($exhibition->artworks as $artwork)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <img src="{{ asset('storage/' . $artwork->image) }}" class="rounded me-2" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <strong class="d-block">{{ Str::limit($artwork->title, 25) }}</strong>
                                <small class="text-muted">{{ $artwork->artist->name }}</small><br>
                                <a href="{{ route('gallery.show', $artwork) }}" class="btn btn-sm btn-outline-primary mt-1">Lihat</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">Belum ada karya</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection