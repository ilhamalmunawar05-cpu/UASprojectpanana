@extends('layouts.bookmaster')

@section('title', 'Lengkapi Profil Anggota - SIPERPUS')

@section('content')
<section class="section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="mb-4">Lengkapi Profil Anggota</h3>
                        <p class="text-muted mb-4">Silakan melengkapi data diri Anda untuk mengakses fitur peminjaman buku.</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fa fa-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.member.update') . (request()->query('book') ? '?book=' . request()->query('book') : '') }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap *</label>
                                <input type="text" id="full_name" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $member?->full_name ?? $user->name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nim_nidn" class="form-label">NIM/NIDN *</label>
                                <input type="text" id="nim_nidn" name="nim_nidn" class="form-control @error('nim_nidn') is-invalid @enderror" value="{{ old('nim_nidn', $member?->nim_nidn ?? '') }}" required placeholder="Nomor Identitas Mahasiswa/Dosen">
                                @error('nim_nidn')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Nomor Telepon *</label>
                                <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $member?->phone ?? '') }}" required placeholder="Contoh: 0812345678">
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="address" class="form-label">Alamat *</label>
                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $member?->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="department" class="form-label">Departemen/Program Studi</label>
                                <input type="text" id="department" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department', $member?->department ?? '') }}" placeholder="Opsional">
                                @error('department')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100">Simpan Profil</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('opac.index') }}" class="text-muted">Kembali ke Pencarian Buku</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
