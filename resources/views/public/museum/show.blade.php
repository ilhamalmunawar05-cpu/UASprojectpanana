@extends('layouts.public')
@section('title', $collection->title)
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="<function_calls>
<invoke name="artifacts">
<parameter name="command">update</parameter>
<parameter name="id">public_views_modules_c_to_g</parameter>
<parameter name="old_str">    <nav aria-label="breadcrumb">
<ol class="</parameter>
<parameter name="new_str">    <nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{ route('museum.public') }}">Museum</a></li>
<li class="breadcrumb-item active">{{ Str::limit($collection->title, 40) }}</li>
</ol>
</nav>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-lg">
            <img src="{{ asset('storage/' . $collection->image) }}" 
                 class="card-img-top rounded" 
                 alt="{{ $collection->title }}"
                 style="width: 100%; height: auto; max-height: 600px; object-fit: contain;">
        </div>
    </div>

    <div class="col-md-6">
        <span class="badge bg-info fs-6 mb-3">{{ ucfirst($collection->category) }}</span>
        <h1 class="mb-4">{{ $collection->title }}</h1>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Koleksi</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    @if($collection->collection_number)
                        <tr>
                            <td width="40%"><strong>No. Koleksi</strong></td>
                            <td>{{ $collection->collection_number }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td>{{ ucfirst($collection->category) }}</td>
                    </tr>
                    @if($collection->year)
                        <tr>
                            <td><strong>Tahun</strong></td>
                            <td>{{ $collection->year }}</td>
                        </tr>
                    @endif
                    @if($collection->origin)
                        <tr>
                            <td><strong>Asal/Periode</strong></td>
                            <td>{{ $collection->origin }}</td>
                        </tr>
                    @endif
                    @if($collection->material)
                        <tr>
                            <td><strong>Material</strong></td>
                            <td>{{ $collection->material }}</td>
                        </tr>
                    @endif
                    @if($collection->dimensions)
                        <tr>
                            <td><strong>Dimensi</strong></td>
                            <td>{{ $collection->dimensions }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($collection->description)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-align-left"></i> Deskripsi</h5>
                </div>
                <div class="card-body">
                    <p style="white-space: pre-line; text-align: justify;">{{ $collection->description }}</p>
                </div>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('museum.public') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Museum
            </a>
        </div>
    </div>
</div>
</div>
@endsection</parameter>