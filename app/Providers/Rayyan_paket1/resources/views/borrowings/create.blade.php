<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Peminjaman Manual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .card { border: none; border-radius: 15px; }
        .card-header { border-radius: 15px 15px 0 0 !important; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0">Form Peminjaman (Ketik Bebas)</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Member</label>
                            <input type="text" name="member_name" class="form-control" placeholder="Masukkan nama peminjam..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <input type="text" name="book_title" class="form-control" placeholder="Masukkan judul buku..." required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Tgl Pinjam</label>
                                <input type="date" name="borrow_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Tgl Kembali</label>
                                <input type="date" name="return_date" class="form-control">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
                            <a href="/" class="btn btn-light border">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>