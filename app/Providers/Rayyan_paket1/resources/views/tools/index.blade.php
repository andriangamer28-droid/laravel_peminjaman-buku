<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Alat | SMK Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.3s ease;
        }
        .gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.4);
        }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Daftar Inventaris <span class="text-indigo-600">Alat</span></h1>
                <p class="text-gray-500 text-sm mt-1">Kelola dan pantau semua aset peralatan sekolah Anda.</p>
            </div>
            
            <a href="/alat/create" class="gradient-btn text-white px-6 py-3 rounded-xl font-medium flex items-center justify-center gap-2 w-fit">
                <i class="fas fa-plus"></i>
                Tambah Alat
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-5 rounded-2xl shadow-sm border-l-4 border-indigo-500">
                <p class="text-xs text-gray-400 uppercase font-semibold">Total Alat</p>
                <h3 class="text-2xl font-bold text-gray-700">124 Unit</h3>
            </div>
            <div class="glass-card p-5 rounded-2xl shadow-sm border-l-4 border-green-500">
                <p class="text-xs text-gray-400 uppercase font-semibold">Kondisi Baik</p>
                <h3 class="text-2xl font-bold text-gray-700">118 Unit</h3>
            </div>
            <div class="glass-card p-5 rounded-2xl shadow-sm border-l-4 border-yellow-500">
                <p class="text-xs text-gray-400 uppercase font-semibold">Sedang Dipinjam</p>
                <h3 class="text-2xl font-bold text-gray-700">6 Unit</h3>
            </div>
        </div>

        <div class="glass-card shadow-xl rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Alat</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">Waktu Simpan</th>
                            <th class="px-6 py-4 text-sm font-semibold text-gray-600 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <div class