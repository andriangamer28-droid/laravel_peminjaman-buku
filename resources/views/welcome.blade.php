<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">📚 Andrian Book</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-md shadow-indigo-200">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
                            Kelola <span class="text-indigo-600">Perpustakaan</span> Digital Anda dengan Mudah
                        </h1>
                        <p class="text-lg text-gray-600 mt-6">
                            Catat buku, anggota, dan transaksi peminjaman secara efisien. Dapatkan laporan real-time dan notifikasi keterlambatan.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
                                    Mulai Sekarang
                                </a>
                                <a href="{{ route('login') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                                    Login
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <img src="https://illustrations.popsy.co/amber/reading-book.svg" alt="Reading" class="w-full max-w-md mx-auto">
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="bg-gray-50 py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900">Fitur Unggulan</h2>
                        <p class="text-gray-600 mt-2">Semua yang Anda butuhkan untuk manajemen perpustakaan modern</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-2xl mb-4">📖</div>
                            <h3 class="text-xl font-semibold mb-2">Katalog Buku</h3>
                            <p class="text-gray-600">Kelola ribuan koleksi buku dengan kategori, ISBN, dan stok real-time.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl mb-4">👥</div>
                            <h3 class="text-xl font-semibold mb-2">Manajemen Anggota</h3>
                            <p class="text-gray-600">Database anggota lengkap dengan riwayat peminjaman dan status keanggotaan.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl mb-4">🔄</div>
                            <h3 class="text-xl font-semibold mb-2">Peminjaman & Denda</h3>
                            <p class="text-gray-600">Proses peminjaman cepat, perhitungan denda otomatis, dan pengembalian mudah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Andrian. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>