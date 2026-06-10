@extends('layouts.app')

@section('page-title', 'Detail Karya Seni')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-image"></i> {{ $artwork->title }}</h4>
                <div>
                    <a href="{{ route('admin.artworks.edit', $artwork) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.artworks.destroy', $artwork) }}" 
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
                {{-- Gambar Utama --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $artwork->image) }}" 
                         alt="{{ $artwork->title }}" 
                         class="img-fluid rounded shadow"
                         style="max-height: 500px;">
                </div>

                {{-- Informasi Detail --}}
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $artwork->id }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $artwork->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Seniman</th>
                        <td>
                            <a href="{{ route('admin.artists.show', $artwork->artist) }}">
                                {{ $artwork->artist->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $artwork->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td>{{ $artwork->year ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Medium/Teknik</th>
                        <td>{{ $artwork->medium ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dimensi</th>
                        <td>{{ $artwork->dimensions ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>
                            @if($artwork->price)
                                <strong>Rp {{ number_format($artwork->price, 0, ',', '.') }}</strong>
                            @else
                                <span class="text-muted">Tidak dijual</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($artwork->status == 'available')
                                <span class="badge bg-success">Available</span>
                            @elseif($artwork->status == 'sold')
                                <span class="badge bg-danger">Sold</span>
                            @else
                                <span class="badge bg-warning text-dark">On Display</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat</th>
                        <td>{{ $artwork->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diupdate</th>
                        <td>{{ $artwork->updated_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.artworks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('gallery.show', $artwork) }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-external-link-alt"></i> Lihat di Halaman Public
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Info Tambahan --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informasi Tambahan</h6>
            </div>
            <div class="card-body">
                <h6>Total Komentar</h6>
                <p class="mb-3">{{ $artwork->comments()->count() }} komentar</p>

                <h6>Dipamerkan Di</h6>
                <ul class="list-unstyled">
                    @forelse($artwork->exhibitions as $exhibition)
                        <li>• {{ $exhibition->title }}</li>
                    @empty
                        <li class="text-muted">Belum dipamerkan</li>
                    @endforelse
                </ul>

                <h6 class="mt-3">Artikel Terkait</h6>
                <ul class="list-unstyled">
                    @forelse($artwork->articles as $article)
                        <li>• <a href="{{ route('admin.articles.show', $article) }}">{{ $article->title }}</a></li>
                    @empty
                        <li class="text-muted">Belum ada artikel</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection