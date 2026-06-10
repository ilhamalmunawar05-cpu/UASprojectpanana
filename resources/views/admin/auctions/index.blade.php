@extends('layouts.app')
@section('page-title', 'Manajemen Lelang')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4><i class="fas fa-gavel"></i> Daftar Lelang</h4>
        <a href="{{ route('admin.auctions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Lelang
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Karya Seni</th>
                    <th>Periode</th>
                    <th>Bid Awal</th>
                    <th>Bid Tertinggi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctions as $auction)
                <tr>
                    <td>{{ $auction->id }}</td>
                    <td>
                        <strong>{{ $auction->artwork->title }}</strong><br>
                        <small class="text-muted">{{ $auction->artwork->artist->name }}</small>
                    </td>
                    <td>
                        <small>
                            {{ $auction->start_date->format('d M Y') }}<br>
                            s/d {{ $auction->end_date->format('d M Y') }}
                        </small>
                    </td>
                    <td>Rp {{ number_format($auction->starting_bid, 0, ',', '.') }}</td>
                    <td>
                        @if($auction->current_bid)
                            <strong class="text-success">Rp {{ number_format($auction->current_bid, 0, ',', '.') }}</strong>
                        @else
                            <span class="text-muted">Belum ada bid</span>
                        @endif
                    </td>
                    <td>
                        @if($auction->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @elseif($auction->status == 'ended')
                            <span class="badge bg-secondary">Ended</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.auctions.show', $auction) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.auctions.edit', $auction) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.auctions.destroy', $auction) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">Belum ada data lelang</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $auctions->links() }}
    </div>
</div>
@endsection