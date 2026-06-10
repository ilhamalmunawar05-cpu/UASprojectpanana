@extends('layouts.app')
@section('page-title', 'Manajemen Koleksi Museum')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4><i class="fas fa-archive"></i> Daftar Koleksi Museum</h4>
        <a href="{{ route('admin.collections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Koleksi
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>No. Koleksi</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collections as $collection)
                <tr>
                    <td>{{ $collection->id }}</td>
                    <td><img src="{{ asset('storage/' . $collection->image) }}" style="width:60px;height:60px;object-fit:cover;" class="rounded"></td>
                    <td><strong>{{ $collection->title }}</strong></td>
                    <td>{{ $collection->collection_number ?? '-' }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($collection->category) }}</span></td>
                    <td>{{ $collection->year ?? '-' }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.collections.show', $collection) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.collections.destroy', $collection) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4">Belum ada koleksi</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $collections->links() }}
    </div>
</div>
@endsection
