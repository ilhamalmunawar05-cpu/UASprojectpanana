@extends('home')
@section('title', 'Buku Tamu')
@section('content')
<div class="hero">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Buku Tamu</h1>
        <p class="lead">Tulis kesan dan pesan Anda di sini</p>
    </div>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Form --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-pencil-alt"></i> Tulis Pesan Anda</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('guestbook.store') }}" method="POST">
                        @csrf
                        @guest
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                        @endguest

                        <div class="mb-3">
                            <label class="form-label">Pesan Anda <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control" 
                                      placeholder="Tulis kesan Anda tentang galeri seni kami..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Comments --}}
            <h4 class="mb-4">Pesan dari Pengunjung ({{ $comments->total() }})</h4>
            
            @forelse($comments as $comment)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px; flex-shrink: 0;">
                                <strong>{{ substr($comment->commenter_name, 0, 1) }}</strong>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $comment->commenter_name }}</h6>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                <p class="mt-2 mb-0">{{ $comment->message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada pesan. Jadilah yang pertama!</p>
                </div>
            @endforelse

            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection