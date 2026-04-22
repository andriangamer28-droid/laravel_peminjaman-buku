<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="fw-bold">Koleksi Buku Saya</h2>
            <a href="{{ route('alat.create') }}" class="btn btn-primary">+ Tambah Alat</a>
        </div>
<h2 class="fw-bold">Koleksi Alat Saya</h2>

<a href="{{ route('alat.create') }}" class="btn btn-primary">+ Tambah Alat</a>
        <div class="card shadow-sm">
            <table class="table mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Waktu Simpan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuabuku as $b)
                    <tr>
                        <td>{{ $b->judul }}</td>
                        <td>{{ $b->kategori }}</td>
                        <td>{{ $b->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>