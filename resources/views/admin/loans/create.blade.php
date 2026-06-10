@extends('layouts.app')

@section('page-title', 'Catat Peminjaman Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-book-reader"></i> Catat Peminjaman Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.loans.store') }}" method="POST" novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Anggota Perpustakaan</label>
                    <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->full_name }} ({{ $member->nim_nidn }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Buku</label>
                    <select name="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} (Stok: {{ $book->stock }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="loan_date" value="{{ old('loan_date', date('Y-m-d')) }}" class="form-control @error('loan_date') is-invalid @enderror" required>
                    @error('loan_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jatuh Tempo (Tanggal Pengembalian)</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}" class="form-control @error('due_date') is-invalid @enderror" required>
                    @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Catat Peminjaman</button>
            </div>
        </form>
    </div>
</div>
@endsection
