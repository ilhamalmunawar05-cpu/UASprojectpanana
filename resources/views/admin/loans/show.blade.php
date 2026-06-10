@extends('layouts.app')

@section('page-title', 'Detail Peminjaman')

@section('content')
<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-info-circle"></i> Detail Peminjaman</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4"><strong>ID Peminjaman:</strong></div>
                    <div class="col-md-8">#{{ $loan->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Anggota:</strong></div>
                    <div class="col-md-8">{{ $loan->member->full_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Judul Buku:</strong></div>
                    <div class="col-md-8">{{ $loan->book->title }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Tanggal Peminjaman:</strong></div>
                    <div class="col-md-8">{{ $loan->loan_date->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Jatuh Tempo:</strong></div>
                    <div class="col-md-8">{{ $loan->due_date->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status:</strong></div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $loan->status === 'active' ? 'info' : 'success' }}">{{ ucfirst($loan->status) }}</span>
                    </div>
                </div>
                @if($loan->return)
                <hr>
                <h5>Catatan Pengembalian</h5>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Tanggal Pengembalian:</strong></div>
                    <div class="col-md-8">{{ $loan->return->return_date->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Terlambat:</strong></div>
                    <div class="col-md-8">{{ $loan->return->late_days }} hari</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Denda:</strong></div>
                    <div class="col-md-8">Rp {{ number_format($loan->return->fine_amount, 0, ',', '.') }}</div>
                </div>
                @if($loan->return->notes)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Catatan:</strong></div>
                    <div class="col-md-8">{{ $loan->return->notes }}</div>
                </div>
                @endif
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-money-bill"></i> Status Denda</h5>
            </div>
            <div class="card-body">
                @if($loan->return)
                    @if($loan->return->fine_amount > 0)
                        <div class="alert alert-warning">
                            <strong>Denda Tertayang:</strong><br>
                            Rp {{ number_format($loan->return->fine_amount, 0, ',', '.') }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            <strong>Tidak Ada Denda</strong><br>
                            Pengembalian tepat waktu.
                        </div>
                    @endif
                @else
                    <p class="text-muted">Belum ada pengembalian.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
