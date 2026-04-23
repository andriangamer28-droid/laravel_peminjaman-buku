<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Andrian Book') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(79, 70, 229, 0.1);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>
<body class="antialiased bg-white overflow-x-hidden">
    {{-- Decorative Background Blobs --}}
    <div class="blob -top-24 -left-24"></div>
    <div class="blob top-1/2 -right-24" style="background: rgba(59, 130, 246, 0.08);"></div>

    <div class="min-h-screen flex flex-col">
        <nav class="bg-white/70 backdrop-blur-xl border-b border-slate-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <div class="flex items-center gap-2">
                        <div class="p-2 bg-indigo-600 rounded-lg shadow-lg shadow-indigo-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <span class="text-xl font-black tracking-tight text-slate-800">Andrian<span class="text-indigo-600">Book.</span></span>
                    </div>

                    <div class="flex items-center space-x-6">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-indigo-600 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition shadow-xl shadow-slate-200 active:scale-95">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
                <div class="grid md:grid-cols-2 gap-16 items-center">
                    <div class="relative">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 mb-6">
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-ping"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600">v3.0 Sistem Perpustakaan Modern</span>
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tighter">
                            Baca Lebih <br> <span class="text-indigo-600">Mudah & Cepat.</span>
                        </h1>
                        <p class="text-lg text-slate-500 mt-8 leading-relaxed max-w-md">
                            Solusi cerdas untuk mengelola ribuan koleksi buku, data anggota, dan transaksi peminjaman dalam satu platform yang intuitif.
                        </p>
                        
                        <div class="mt-10 flex flex-wrap gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-2xl shadow-indigo-200 hover:bg-indigo-700 transition-all hover:-translate-y-1">
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-2xl shadow-indigo-200 hover:bg-indigo-700 transition-all hover:-translate-y-1">
                                    Mulai Gratis
                                </a>
                                <a href="#fitur" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 font-black rounded-2xl hover:bg-slate-50 transition">
                                    Pelajari Fitur
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
                        <img src="https://illustrations.popsy.co/amber/reading-book.svg" alt="Hero Illustration" class="w-full relative animate-float transition-all duration-700 hover:scale-105">
                        
                        {{-- Floating Card Info --}}
                        <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-2xl shadow-2xl border border-slate-50 hidden sm:flex items-center gap-4 animate-bounce-slow">
                            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-xl">✅</div>
                            <div>
                                <p class="text-xs font-black text-slate-800 leading-none">99.9% Akurat</p>
                                <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">Laporan Real-time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="fitur" class="py-24 relative overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-2xl mx-auto mb-20">
                        <h2 class="text-4xl font-black text-slate-900 tracking-tight">Didesain untuk Efisiensi</h2>
                        <p class="text-slate-500 font-bold mt-4">Kelola operasional perpustakaan Anda tanpa pusing dengan fitur otomatisasi kami.</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-10">
                        {{-- Card 1 --}}
                        <div class="group p-10 bg-white rounded-[2.5rem] border border-slate-100 hover:border-indigo-100 transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-100/50 hover:-translate-y-2">
                            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition-transform">📚</div>
                            <h3 class="text-xl font-black text-slate-800 mb-4">Katalog Pintar</h3>
                            <p class="text-slate-500 leading-relaxed font-medium">Atur ribuan buku dengan sistem kategori otomatis, pelacakan ISBN, dan monitoring stok otomatis.</p>
                        </div>

                        {{-- Card 2 --}}
                        <div class="group p-10 bg-white rounded-[2.5rem] border border-slate-100 hover:border-emerald-100 transition-all duration-500 hover:shadow-2xl hover:shadow-emerald-100/50 hover:-translate-y-2">
                            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition-transform">👥</div>
                            <h3 class="text-xl font-black text-slate-800 mb-4">Data Terpusat</h3>
                            <p class="text-slate-500 leading-relaxed font-medium">Simpan data anggota dengan aman, pantau riwayat pinjaman, dan berikan akses profil personal.</p>
                        </div>

                        {{-- Card 3 --}}
                        <div class="group p-10 bg-white rounded-[2.5rem] border border-slate-100 hover:border-amber-100 transition-all duration-500 hover:shadow-2xl hover:shadow-amber-100/50 hover:-translate-y-2">
                            <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:scale-110 group-hover:rotate-6 transition-transform">🔄</div>
                            <h3 class="text-xl font-black text-slate-800 mb-4">Denda Otomatis</h3>
                            <p class="text-slate-500 leading-relaxed font-medium">Sistem otomatis menghitung denda keterlambatan dan memberikan notifikasi tepat waktu kepada peminjam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-slate-900 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
                <div>
                    <span class="text-2xl font-black text-white">Andrian<span class="text-indigo-400">Book.</span></span>
                    <p class="text-slate-400 mt-2 text-sm">Elevating your library experience.</p>
                </div>
                <div class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em]">
                    &copy; {{ date('Y') }} Made with ❤️ by Andrian.
                </div>
            </div>
        </footer>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
    </style>
</body>
</html>