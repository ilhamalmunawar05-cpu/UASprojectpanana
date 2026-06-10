@extends('layouts.app')
@section('page-title', 'Tambah Lelang')
@section('content')
<div class="card">
    <div class="card-header"><h4>Form Tambah Lelang</h4></div>
    <div class="card-body">
        <form action="{{ route('admin.auctions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Karya Seni <span class="text-danger">*</span></label>
                    <select name="artwork_id" class="form-select @error('artwork_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Karya Seni --</option>
                        @foreach($artworks as $artwork)
                            <option value="{{ $artwork->id }}" {{ old('artwork_id') == $artwork->id ? 'selected' : '' }}>
                                {{ $artwork->title }} - {{ $artwork->artist->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('artwork_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                           value="{{ old('start_date') }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal Selesai <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                           value="{{ old('end_date') }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Bid Awal (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="starting_bid" class="form-control @error('starting_bid') is-invalid @enderror" 
                           value="{{ old('starting_bid') }}" min="0" required>
                    @error('starting_bid')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="ended" {{ old('status') == 'ended' ? 'selected' : '' }}>Ended</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                <a href="{{ route('admin.auctions.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Lelang</button>
            </div>
        </form>
    </div>
</div>
@endsection