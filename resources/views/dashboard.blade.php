<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-indigo-400 to-cyan-500 overflow-hidden shadow-sm sm:rounded-2xl text-white p-6">
                <h3 class="text-2xl font-bold">Selamat datang, {{ Auth::user()->name }}!</h3>
                <p class="text-indigo-100 mt-1">
                    @if(auth()->user()->isAdmin())
                        Kelola perpustakaan dengan mudah melalui panel ini.
                    @else
                        Temukan dan pinjam buku favoritmu di sini.
                    @endif
                </p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Buku</p>
                            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Buku::count() }}</p>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Anggota</p>
                            <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Anggota::count() }}</p>
                        </div>
                    </div>
                </div>
                @else
                {{-- Untuk anggota: tampilkan peminjaman aktif milik sendiri --}}
                @php
                    $anggotaLogin = \App\Models\Anggota::where('email', auth()->user()->email)->first();
                    $pinjamAktif = $anggotaLogin ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)->whereIn('status',['menunggu','disetujui','dipinjam'])->count() : 0;
                @endphp
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pinjaman Aktif Saya</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $pinjamAktif }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-yellow-100 rounded-xl p-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">
                                @if(auth()->user()->isAdmin()) Buku Dipinjam @else Menunggu Validasi @endif
                            </p>
                            <p class="text-3xl font-bold text-gray-900">
                                @if(auth()->user()->isAdmin())
                                    {{ \App\Models\Peminjaman::where('status','dipinjam')->count() }}
                                @else
                                    {{ $anggotaLogin ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)->where('status','menunggu')->count() : 0 }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aksi Cepat -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('buku.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Buku
                        </a>
                        <a href="{{ route('anggota.create') }}" class="inline-flex items-center px-4 py-2 bg-green-50 rounded-lg text-sm font-medium text-green-700 hover:bg-green-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Tambah Anggota
                        </a>
                        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-50 rounded-lg text-sm font-medium text-yellow-700 hover:bg-yellow-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Kelola Peminjaman
                        </a>
                    @else
                        <a href="{{ route('buku.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Lihat Buku
                        </a>
                        <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-4 py-2 bg-green-50 rounded-lg text-sm font-medium text-green-700 hover:bg-green-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Pinjam Buku
                        </a>
                        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-50 rounded-lg text-sm font-medium text-yellow-700 hover:bg-yellow-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Riwayat Peminjaman Saya
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tabel Peminjaman Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    @if(auth()->user()->isAdmin()) Peminjaman Terbaru @else Riwayat Peminjaman Saya @endif
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                if (auth()->user()->isAdmin()) {
                                    $recentPinjam = \App\Models\Peminjaman::with(['anggota','buku'])->latest()->take(5)->get();
                                } else {
                                    $recentPinjam = $anggotaLogin
                                        ? \App\Models\Peminjaman::with(['anggota','buku'])->where('anggota_id', $anggotaLogin->id)->latest()->take(5)->get()
                                        : collect();
                                }
                            @endphp
                            @forelse($recentPinjam as $p)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $p->anggota->nama }}</td>
                                <td class="px-4 py-3 text-sm">{{ $p->buku->judul }}</td>
                                <td class="px-4 py-3 text-sm">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $p->badgeStatus() }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
