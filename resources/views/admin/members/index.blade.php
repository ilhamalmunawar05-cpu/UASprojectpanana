@extends('layouts.app')

@section('page-title', 'Manajemen Anggota Perpustakaan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0"><i class="fas fa-users"></i> Daftar Anggota Perpustakaan</h4>
            <small class="text-muted">Kelola data anggota (mahasiswa, dosen) perpustakaan.</small>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>NIM/NIDN</th>
                        <th>Nama Lengkap</th>
                        <th>Prodi/Dept</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td><strong>{{ $member->nim_nidn }}</strong></td>
                        <td>{{ $member->full_name }}</td>
                        <td>{{ $member->department ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $member->status === 'active' ? 'success' : ($member->status === 'inactive' ? 'warning' : 'danger') }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                        <td>{{ $member->joined_date->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-info me-1" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada anggota. Silakan tambahkan anggota baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $members->links() }}
    </div>
</div>
@endsection
