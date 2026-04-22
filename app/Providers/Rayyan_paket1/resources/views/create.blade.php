@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Pinjam Buku Baru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('borrowings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Alat</label>
                    <select name="tool_id" class="form-select">
                        @foreach($tools as $tool)
                            <option value="{{ $tool->id }}">{{ $tool->name }} (Stok: {{ $tool->quantity }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Pinjam</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan Peminjaman</button>
                <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
