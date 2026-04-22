<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alat Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f6f8fb; }
        .glass-form { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 2rem; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="glass-form shadow-2xl p-10 w-full max-w-lg border border-white">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Tambah <span class="text-indigo-600">Alat Baru</span></h2>
        <p class="text-slate-400 text-sm mb-8">Lengkapi detail informasi alat di bawah ini.</p>

        <form action="{{ route('alat.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Nama Alat</label>
                <input type="text" name="nama_alat" placeholder="Contoh: Solder Listrik" 
                    class="w-full px-5 py-3 rounded-xl border border-slate-100 focus:ring-2 focus:ring-indigo-400 outline-none transition-all shadow-sm">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Kategori</label>
                <select name="kategori" class="w-full px-5 py-3 rounded-xl border border-slate-100 focus:ring-2 focus:ring-indigo-400 outline-none transition-all shadow-sm">
                    <option value="Elektronik">Elektronik</option>
                    <option value="Mekanik">Mekanik</option>
                    <option value="Perkakas">Perkakas</option>
                    
                </select>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-200 transition-all">
                    Simpan Alat
                </button>
                <a href="{{ route('alat.index') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 text-center font-bold py-3.5 rounded-xl transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>

</body>
</html>