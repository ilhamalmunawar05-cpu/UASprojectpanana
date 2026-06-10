@extends('layouts.app')
@section('page-title', 'Manajemen Artikel')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4><i class="fas fa-newspaper"></i> Daftar Artikel</h4>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>
                        @if($article->image)
                            <img src="{{ asset('storage/' . $article->image) }}" style="width:60px;height:60px;object-fit:cover;" class="rounded">
                        @else
                            <div class="bg-secondary" style="width:60px;height:60px;"></div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ Str::limit($article->title, 40) }}</strong><br>
                        <small class="text-muted">{{ $article->created_at->format('d M Y') }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ ucfirst($article->category) }}</span></td>
                    <td>{{ $article->author->name }}</td>
                    <td>
                        @if($article->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4">Belum ada artikel</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $articles->links() }}
    </div>
</div>
@endsection