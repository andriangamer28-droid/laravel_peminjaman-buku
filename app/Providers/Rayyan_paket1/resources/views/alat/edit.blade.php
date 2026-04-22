<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4 text-warning">Edit Data Alat</h4>
                    <form action="{{ route('alat.update', $alat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Alat</label>
                            <input type="text" name="nama_alat" class="form-control" value="{{ $alat->nama_alat }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Merk</label>
                            <input type="text" name="merk" class="form-control" value="{{ $alat->merk }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Jumlah Unit</label>
                            <input type="number" name="jumlah" class="form-control" value="{{ $alat->jumlah }}">
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold">Update Inventaris</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>