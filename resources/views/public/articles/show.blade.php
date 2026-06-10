@extends('layouts.public')
@section('title', $article->title)
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('articles.public') }}">Artikel</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($article->title, 40) }}</li>
                </ol>
            </nav>

            <span class="badge bg-secondary mb-3">{{ ucfirst($article->category) }}</span>
            <h1 class="mb-3">{{ $article->title }}</h1>
            
            <div class="d-flex align-items-center mb-4 text-muted">
                <i class="fas fa-user me-2"></i> {{ $article->author->name ?? 'Penulis' }}
                <span class="mx-2">|</span>
                <i class="fas fa-calendar me-2"></i> {{ $article->created_at->format('d F Y') }}
            </div>

            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" class="img-fluid rounded shadow mb-4" alt="{{ $article->title }}">
            @endif

            <div class="article-content" style="font-size: 1.1rem; line-height: 1.8; text-align: justify;">
                {!! nl2br(e($article->content)) !!}
            </div>

            @if($article->artwork)
                <div class="alert alert-info mt-4">
                    <strong>Karya Terkait:</strong>
                    <a href="{{ route('gallery.show', $article->artwork) }}">{{ $article->artwork->title }}</a>
                </div>
            @endif

            <hr class="my-4">
            <div class="text-center">
                <a href="{{ route('articles.public') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Artikel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection