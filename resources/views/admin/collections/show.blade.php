@extends('layouts.app')
@section('page-title', 'Detail Koleksi')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4><i class="fas fa-info-circle"></i> Detail Koleksi Museum</h4>
        <div>
            <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $collection->image) }}" class="img-fluid rounded shadow" alt="{{ $collection->title }}">
                <div class="mt-3">
                    <span class="badge bg-{{ $collection->is_displayed ? 'success' : 'secondary' }}">
                        {{ $collection->is_displayed ? 'Ditampilkan di Website' : 'Tidak Ditampilkan' }}
                    </span>
                </div>
            </div>
            <div class="col-md-7">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Judul</th>
                        <td><strong>{{ $collection->title }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nomor Koleksi</th>
                        <td>{{ $collection->collection_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td><span class="badge bg-info">{{ ucfirst($collection->category) }}</span></td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td>{{ $collection->year ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>
                            @if($collection->condition)
                            <span class="badge bg-{{ $collection->condition == 'baik' ? 'success' : ($collection->condition == 'cukup' ? 'warning' : 'danger') }}">
                                {{ ucfirst($collection->condition) }}
                            </span>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Asal Daerah</th>
                        <td>{{ $collection->origin ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Bahan</th>
                        <td>{{ $collection->material ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dimensi</th>
                        <td>
                            @if($collection->length || $collection->width || $collection->height)
                                P: {{ $collection->length ?? '-' }} cm, 
                                L: {{ $collection->width ?? '-' }} cm, 
                                T: {{ $collection->height ?? '-' }} cm
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Lokasi Penyimpanan</th>
                        <td>{{ $collection->storage_location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $collection->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ditambahkan</th>
                        <td>{{ $collection->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $collection->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection