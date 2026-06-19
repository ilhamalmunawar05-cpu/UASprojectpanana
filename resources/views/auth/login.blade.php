@extends('layouts.bookmaster')

@section('title', 'Login - SIPERPUS')

@section('content')
<section class="section-gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="text-center mb-3">Login</h3>
                        <p class="text-center text-muted mb-4">Masuk untuk mengakses fitur perpustakaan dan akun Anda.</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-circle"></i>
                                Email atau password salah. Silakan coba lagi.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            @if(old('redirect', request()->query('redirect')))
                                <input type="hidden" name="redirect" value="{{ old('redirect', request()->query('redirect')) }}">
                            @endif

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="ms-2">Ingat saya</label>
                                </div>
                                @if(Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Lupa password?</a>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>

                            @if(Route::has('register'))
                                <div class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
