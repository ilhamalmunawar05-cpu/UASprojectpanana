@extends('layouts.app')

@section('page-title', 'Detail Anggota Perpustakaan')

@section('content')
<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-user-circle"></i> Profil Anggota</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4"><strong>NIM/NIDN:</strong></div>
                    <div class="col-md-8">{{ $member->nim_nidn }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nama Lengkap:</strong></div>
                    <div class="col-md-8">{{ $member->full_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8">{{ $member->user->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Telepon:</strong></div>
                    <div class="col-md-8">{{ $member->phone ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Prodi/Departemen:</strong></div>
                    <div class="col-md-8">{{ $member->department ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Alamat:</strong></div>
                    <div class="col-md-8">{{ $member->address ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Status:</strong></div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $member->status === 'active' ? 'success' : ($member->status === 'inactive' ? 'warning' : 'danger') }}">
                            {{ ucfirst($member->status) }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Bergabung:</strong></div>
                    <div class="col-md-8">{{ $member->joined_date->format('d F Y') }}</div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                @if($member->loans->count() > 0)
                    <p><strong>Total Peminjaman:</strong> {{ $member->loans->count() }}</p>
                    <p><strong>Aktif Saat Ini:</strong> {{ $member->loans->where('status', 'active')->count() }}</p>
                @else
                    <p class="text-muted">Belum ada riwayat peminjaman.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
