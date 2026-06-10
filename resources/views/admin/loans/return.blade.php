@extends('layouts.app')

@section('page-title', 'Proses Pengembalian Buku')

@section('content')
<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-undo"></i> Catat Pengembalian Buku</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <strong>Data Peminjaman:</strong><br>
            Anggota: <strong>{{ $loan->member->full_name }}</strong><br>
            Buku: <strong>{{ $loan->book->title }}</strong><br>
            Tanggal Pinjam: <strong>{{ $loan->loan_date->format('d F Y') }}</strong><br>
            Jatuh Tempo: <strong>{{ $loan->due_date->format('d F Y') }}</strong>
        </div>

        <form action="{{ route('admin.loans.processReturn', $loan) }}" method="POST" novalidate>
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" value="{{ old('return_date', date('Y-m-d')) }}" class="form-control @error('return_date') is-invalid @enderror" required>
                    @error('return_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status Denda</label>
                    <input type="text" class="form-control" id="fineStatus" readonly>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Catatan Pengembalian</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Kondisi buku, kerusakan, dll">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Proses Pengembalian</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('input[name="return_date"]').addEventListener('change', function() {
    const dueDate = new Date('{{ $loan->due_date }}');
    const returnDate = new Date(this.value);
    const lateDays = Math.max(0, Math.floor((returnDate - dueDate) / (1000 * 60 * 60 * 24)));
    const fineAmount = lateDays * 5000;
    
    if (lateDays > 0) {
        document.getElementById('fineStatus').value = `Terlambat ${lateDays} hari - Denda: Rp ${fineAmount.toLocaleString('id-ID')}`;
    } else {
        document.getElementById('fineStatus').value = 'Tepat Waktu - Tidak ada denda';
    }
});
</script>
@endsection
