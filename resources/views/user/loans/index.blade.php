@extends('layouts.bookmaster')

@section('title', 'Peminjaman Saya')

@section('content')
<section class="section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">Peminjaman Saya</h4>
                        <p class="text-muted">Daftar pinjaman aktif dan riwayat peminjaman Anda.</p>
                    </div>
                </div>

                @if($selectedBook)
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">Konfirmasi Peminjaman</div>
                        <div class="card-body">
                            @if($selectedBook->stock <= 0)
                                <div class="alert alert-warning">Buku ini saat ini tidak tersedia.</div>
                            @else
                                <h5>{{ $selectedBook->title }}</h5>
                                <p class="mb-1">Penulis: {{ $selectedBook->author }}</p>
                                <p class="mb-2">ISBN: {{ $selectedBook->isbn ?? '-' }}</p>
                                <form method="POST" action="{{ route('user.loans.store') }}">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $selectedBook->id }}">
                                    <button type="submit" class="btn btn-primary">Pinjam Buku Ini</button>
                                    <a href="{{ route('user.loans') }}" class="btn btn-outline-secondary">Batal</a>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Daftar Peminjaman</h5>
                        @forelse($loans as $loan)
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $loan->book->title }}</h6>
                                        <p class="mb-1 text-muted">{{ $loan->book->author }}</p>
                                        <p class="mb-1 small">Tanggal pinjam: {{ $loan->loan_date->translatedFormat('d F Y') }}</p>
                                        <p class="mb-1 small">Tanggal kembali: {{ $loan->due_date->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <span class="badge bg-{{ $loan->status === 'active' ? 'success' : ($loan->status === 'overdue' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">Belum ada peminjaman.</div>
                        @endforelse

                        <div class="mt-3">
                            {{ $loans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
