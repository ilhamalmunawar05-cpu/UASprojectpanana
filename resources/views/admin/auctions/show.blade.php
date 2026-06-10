@extends('layouts.app')

@section('page-title', 'Detail Lelang')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-gavel"></i> Lelang: {{ $auction->artwork->title ?? 'N/A' }}</h4>
                <div>
                    <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.auctions.destroy', $auction) }}" 
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
                {{-- Gambar Artwork --}}
                @if($auction->artwork && $auction->artwork->image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $auction->artwork->image) }}" 
                             alt="{{ $auction->artwork->title }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 400px;">
                    </div>
                @endif

                {{-- Informasi Detail --}}
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID Lelang</th>
                        <td>{{ $auction->id }}</td>
                    </tr>
                    <tr>
                        <th>Karya Seni</th>
                        <td>
                            @if($auction->artwork)
                                <a href="{{ route('admin.artworks.show', $auction->artwork) }}">
                                    {{ $auction->artwork->title }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Seniman</th>
                        <td>
                            @if($auction->artwork && $auction->artwork->artist)
                                <a href="{{ route('admin.artists.show', $auction->artwork->artist) }}">
                                    {{ $auction->artwork->artist->name }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Harga Awal</th>
                        <td><strong>Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <th>Bid Tertinggi</th>
                        <td>
                            @if($auction->current_bid)
                                <strong class="text-success">Rp {{ number_format($auction->current_bid, 0, ',', '.') }}</strong>
                            @else
                                <span class="text-muted">Belum ada bid</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>{{ $auction->start_date ? $auction->start_date->format('d F Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $auction->end_date ? $auction->end_date->format('d F Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($auction->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($auction->status == 'ended')
                                <span class="badge bg-secondary">Ended</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $auction->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.auctions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('auctions.show', $auction) }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-external-link-alt"></i> Lihat di Halaman Public
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Riwayat Bid ({{ $auction->bids->count() }})</h6>
            </div>
            <div class="card-body">
                @if($auction->bids->count() > 0)
                    <div class="list-group">
                        @foreach($auction->bids->sortByDesc('created_at') as $bid)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $bid->user->name ?? 'Anonymous' }}</strong>
                                    <span class="text-success">Rp {{ number_format($bid->amount, 0, ',', '.') }}</span>
                                </div>
                                <small class="text-muted">{{ $bid->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada bid</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
