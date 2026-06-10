@extends('layouts.public')
@section('title', 'Lelang: ' . ($auction->artwork->title ?? 'Lelang'))
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('auctions.public') }}">Lelang</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($auction->artwork->title ?? 'Lelang', 40) }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Artwork Image --}}
        <div class="col-md-6 mb-4">
            @if($auction->artwork && $auction->artwork->image)
                <div class="card border-0 shadow-lg">
                    <img src="{{ asset('storage/' . $auction->artwork->image) }}" 
                         class="card-img-top rounded" 
                         alt="{{ $auction->artwork->title }}"
                         style="width: 100%; height: auto; max-height: 500px; object-fit: contain;">
                </div>
            @else
                <div class="card border-0 shadow-lg bg-secondary d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-image fa-5x text-white"></i>
                </div>
            @endif
        </div>

        {{-- Auction Details --}}
        <div class="col-md-6">
            <h1 class="mb-3">{{ $auction->artwork->title ?? 'Lelang #' . $auction->id }}</h1>
            
            @if($auction->artwork && $auction->artwork->artist)
                <p class="text-muted mb-3">
                    <i class="fas fa-palette"></i> Karya oleh 
                    <a href="{{ route('artists.show', $auction->artwork->artist) }}">{{ $auction->artwork->artist->name }}</a>
                </p>
            @endif

            {{-- Status Badge --}}
            <div class="mb-3">
                @if($auction->status == 'active')
                    <span class="badge bg-success fs-6"><i class="fas fa-gavel"></i> Lelang Aktif</span>
                @elseif($auction->status == 'upcoming')
                    <span class="badge bg-info fs-6"><i class="fas fa-clock"></i> Akan Datang</span>
                @elseif($auction->status == 'completed')
                    <span class="badge bg-secondary fs-6"><i class="fas fa-check-circle"></i> Selesai</span>
                @else
                    <span class="badge bg-danger fs-6"><i class="fas fa-times-circle"></i> Dibatalkan</span>
                @endif
            </div>

            {{-- Current Bid --}}
            <div class="alert alert-warning mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-gavel"></i> 
                    Bid Saat Ini: Rp {{ number_format($auction->current_bid ?? $auction->starting_bid ?? 0, 0, ',', '.') }}
                </h4>
                @if($auction->starting_bid)
                    <small class="text-muted">Harga Awal: Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</small>
                @endif
            </div>

            {{-- Auction Period --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar"></i> Periode Lelang</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Mulai:</strong> {{ $auction->start_date ? $auction->start_date->format('d F Y H:i') : '-' }}</p>
                    <p class="mb-0"><strong>Berakhir:</strong> {{ $auction->end_date ? $auction->end_date->format('d F Y H:i') : '-' }}</p>
                </div>
            </div>

            {{-- Bid Form --}}
            @auth
                @if($auction->status == 'active')
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-hand-holding-usd"></i> Pasang Bid</h5>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <form action="{{ route('public.auctions.bid', $auction) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Bid (Rp)</label>
                                    <input type="number" name="bid_amount" class="form-control form-control-lg" 
                                           placeholder="Masukkan jumlah bid" min="{{ ($auction->current_bid ?? $auction->starting_bid ?? 0) + 1 }}" required>
                                    <small class="text-muted">Minimal: Rp {{ number_format(($auction->current_bid ?? $auction->starting_bid ?? 0) + 1, 0, ',', '.') }}</small>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-gavel"></i> Pasang Bid
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <a href="{{ route('login') }}">Login</a> untuk mengikuti lelang ini.
                </div>
            @endauth

            {{-- Bid History --}}
            @if($auction->bids && $auction->bids->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Bid ({{ $auction->bids->count() }})</h5>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        @foreach($auction->bids->sortByDesc('created_at') as $bid)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <strong>{{ $bid->user->name ?? 'Anonim' }}</strong>
                                    <small class="text-muted d-block">{{ $bid->created_at->diffForHumans() }}</small>
                                </div>
                                <span class="badge bg-primary fs-6">Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection