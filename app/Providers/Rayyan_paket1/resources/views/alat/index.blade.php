<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Pro | SMK Kiansantang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top right, #eef2ff, #f8fafc);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.03);
        }
        .item-row {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .item-row:hover {
            transform: translateX(10px);
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.02);
        }
        .btn-fancy {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>
<body class="p-6 md:p-12">

    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="h-1 w-8 bg-indigo-600 rounded-full"></div>
                    <span class="text-indigo-600 font-bold text-[10px] uppercase tracking-[0.2em]">SMK Kiansantang System</span>
                </div>
                <h1 class="text-5xl font-extrabold text-slate-800 tracking-tight">
                    Koleksi <span class="text-indigo-600">Alat Saya</span>
                </h1>
                <p class="text-slate-400 mt-2 font-medium">Monitoring aset sekolah dalam satu dashboard terpadu.</p>
            </div>
            
            <a href="{{ route('alat.create') }}" class="btn-fancy text-white px-8 py-4 rounded-2xl font-bold flex items-center gap-3 transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-plus"></i>
                <span>Tambah Alat Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            @php 
                $stats = [
                    ['label' => 'Total Alat', 'val' => $totalAlat ?? 0, 'icon' => 'fa-box', 'color' => 'indigo'],
                    ['label' => 'Kondisi Bagus', 'val' => $kondisiBagus ?? 0, 'icon' => 'fa-check-circle', 'color' => 'emerald'],
                    ['label' => 'Kondisi Buruk', 'val' => 6, 'icon' => 'fa-exclamation-triangle', 'color' => 'amber']
                ];
            @endphp
            @foreach($stats as $s)
            <div class="glass-card p-8 rounded-[2rem] flex items-center gap-6">
                <div class="w-14 h-14 bg-{{ $s['color'] }}-100 text-{{ $s['color'] }}-600 rounded-2xl flex items-center justify-center text-2xl">
                    <i class="fas {{ $s['icon'] }}"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">{{ $s['label'] }}</p>
                    <h4 class="text-3xl font-extrabold text-slate-700">{{ $s['val'] }} <span class="text-sm font-medium text-slate-400">Unit</span></h4>
                </div>
            </div>
            @endforeach
        </div>

        <div class="glass-card rounded-[2.5rem] overflow-hidden">
            <div class="p-10 border-b border-slate-100/50 flex justify-between items-center">
                <h3 class="font-extrabold text-slate-700 text-xl">Daftar Inventaris Terbaru</h3>
                <span class="bg-white px-4 py-2 rounded-xl text-slate-400 text-xs font-bold shadow-sm border border-slate-50">
                    Showing {{ count($semuaAlat) }} Items
                </span>
            </div>

            <div class="p-6">
                @forelse($semuaAlat as $alat)
                    <div class="item-row flex flex-col md:flex-row justify-between items-start md:items-center p-6 rounded-3xl mb-3">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-microchip text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-700 text-lg capitalize">{{ $alat->nama_alat }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">In Stock / Available</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-12 mt-4 md:mt-0 w-full md:w-auto justify-between md:justify-end">
                            <span class="px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-tighter {{ strtolower($alat->kategori) == 'elektronik' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600' }}">
                                {{ $alat->kategori }}
                            </span>
                            
                            <div class="text-right">
                                <p class="text-slate-700 font-bold text-sm">{{ $alat->created_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">Logged at {{ $alat->created_at->format('H:i') }}</p>
                            </div>
                            
                            <div class="flex gap-2">
                                <button class="w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <img src="https://illustrations.popsy.co/flat/empty-box.svg" class="w-48 mx-auto mb-6 opacity-50" alt="empty">
                        <p class="text-slate-400 font-medium italic">Belum ada alat yang terdaftar di sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>