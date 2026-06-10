@extends('layouts.app')

@section('page-title', 'Manajemen Buku')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0"><i class="fas fa-book"></i> Daftar Buku</h4>
            <small class="text-muted">Kelola data buku perpustakaan dan stok koleksi.</small>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Rak</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ Str::limit($book->title, 40) }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ optional($book->category)->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $book->stock > 5 ? 'success' : ($book->stock > 0 ? 'warning' : 'danger') }}">
                                {{ $book->stock }} pcs
                            </span>
                        </td>
                        <td>{{ $book->rack ?? '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada buku. Silakan tambahkan koleksi buku baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $books->links() }}
    </div>
</div>
@endsection
