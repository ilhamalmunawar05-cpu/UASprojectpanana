@extends('layouts.app')

@section('page-title', 'Edit Anggota Perpustakaan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-edit"></i> Edit Data Anggota</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.members.update', $member) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">User Account</label>
                    <input type="text" class="form-control" value="{{ $member->user->name }} ({{ $member->user->email }})" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">NIM/NIDN</label>
                    <input type="text" name="nim_nidn" value="{{ old('nim_nidn', $member->nim_nidn) }}" class="form-control @error('nim_nidn') is-invalid @enderror" required>
                    @error('nim_nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $member->full_name) }}" class="form-control @error('full_name') is-invalid @enderror" required>
                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prodi/Departemen</label>
                    <input type="text" name="department" value="{{ old('department', $member->department) }}" class="form-control @error('department') is-invalid @enderror">
                    @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $member->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="suspended" {{ old('status', $member->status) == 'suspended' ? 'selected' : '' }}>Dicegah</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Perbarui Anggota</button>
            </div>
        </form>
    </div>
</div>
@endsection
