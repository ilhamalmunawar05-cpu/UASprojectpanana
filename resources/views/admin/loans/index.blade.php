@extends('layouts.app')

@section('page-title', 'Manajemen Sirkulasi (Peminjaman & Pengembalian)')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0"><i class="fas fa-book-reader"></i> Daftar Peminjaman</h4>
            <small class="text-muted">Kelola transaksi peminjaman dan pengembalian buku.</small>
        </div>
        <a href="{{ route('admin.loans.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Catat Peminjaman
        </a>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#active" data-bs-toggle="tab">Aktif</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#returned" data-bs-toggle="tab">Dikembalikan</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="active" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans->where('status', 'active') as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td><strong>{{ $loan->member->full_name }}</strong></td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->loan_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ now()->parse($loan->due_date)->isPast() ? 'danger' : 'warning' }}">
                                        {{ $loan->due_date->format('d M Y') }}
                                    </span>
                                </td>
                                <td><span class="badge bg-info">{{ ucfirst($loan->status) }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.loans.return', $loan) }}" class="btn btn-sm btn-success me-1"><i class="fas fa-undo"></i> Kembalikan</a>
                                    <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus peminjaman?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Tidak ada peminjaman aktif.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="returned" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Pengembalian</th>
                                <th>Denda</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans->where('status', 'returned') as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td><strong>{{ $loan->member->full_name }}</strong></td>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->return?->return_date->format('d M Y') ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $loan->return?->late_days > 0 ? 'danger' : 'success' }}">
                                        Rp {{ number_format($loan->return?->fine_amount ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada pengembalian.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
