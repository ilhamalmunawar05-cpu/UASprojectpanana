@extends('layouts.app')
@section('page-title', 'Manajemen Komentar')
@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-comments"></i> Daftar Komentar & Buku Tamu</h4>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Pesan</th>
                    <th>Karya Terkait</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>
                        @if($comment->user)
                            {{ $comment->user->name }}
                        @else
                            {{ $comment->name }}<br>
                            <small class="text-muted">{{ $comment->email }}</small>
                        @endif
                    </td>
                    <td>{{ Str::limit($comment->message, 50) }}</td>
                    <td>
                        @if($comment->artwork)
                            <a href="{{ route('admin.artworks.show', $comment->artwork) }}">
                                {{ $comment->artwork->title }}
                            </a>
                        @else
                            <span class="text-muted">Buku Tamu</span>
                        @endif
                    </td>
                    <td>
                        @if($comment->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($comment->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td><small>{{ $comment->created_at->format('d M Y H:i') }}</small></td>
                    <td>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Yakin?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4">Belum ada komentar</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $comments->links() }}
    </div>
</div>
@endsection
