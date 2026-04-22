@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Peminjaman Buku</h2>
    
    <a href="{{ route('borrowings.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowings as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tool->nama ?? 'Alat tidak ditemukan' }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <span class="badge bg-info">{{ $item->status ?? 'Dipinjam' }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection