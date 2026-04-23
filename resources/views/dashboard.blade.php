<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-[#fafafa] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="relative overflow-hidden shadow-2xl shadow-indigo-200 sm:rounded-[2rem] bg-gradient-to-br from-indigo-600 via-indigo-500 to-violet-500 p-8 text-white">
                <div class="relative z-10">
                    <h3 class="text-3xl font-black tracking-tight">Selamat datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-indigo-100 mt-2 text-lg font-medium opacity-90">
                        @if(auth()->user()->isAdmin())
                            Siap mengelola perpustakaan hari ini? Kendalikan semuanya dari sini.
                        @else
                            Mau baca apa hari ini? Koleksi buku terbaru kami menunggu Anda.
                        @endif
                    </p>
                </div>
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-indigo-400/20 rounded-full blur-2xl"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-7 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-5">
                        <div class="bg-blue-50 rounded-2xl p-4 text-blue-600 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Koleksi</p>
                            <p class="text-4xl font-black text-slate-900 leading-none mt-1">{{ \App\Models\Buku::count() }}</p>
                        </div>
                    </div>
                </div>

                @php
                    $anggotaLogin = \App\Models\Anggota::where('email', auth()->user()->email)->first();
                @endphp
                <div class="bg-white p-7 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-5">
                        <div class="bg-emerald-50 rounded-2xl p-4 text-emerald-600 shadow-inner">
                            @if(auth()->user()->isAdmin())
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                                {{ auth()->user()->isAdmin() ? 'Total Anggota' : 'Pinjaman Aktif' }}
                            </p>
                            <p class="text-4xl font-black text-slate-900 leading-none mt-1">
                                @if(auth()->user()->isAdmin())
                                    {{ \App\Models\Anggota::count() }}
                                @else
                                    {{ $anggotaLogin ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)->whereIn('status',['menunggu','disetujui','dipinjam'])->count() : 0 }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-7 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-5">
                        <div class="bg-amber-50 rounded-2xl p-4 text-amber-600 shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                                {{ auth()->user()->isAdmin() ? 'Sedang Dipinjam' : 'Menunggu Validasi' }}
                            </p>
                            <p class="text-4xl font-black text-slate-900 leading-none mt-1">
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

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center">
                    <span class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></span>
                    Aksi Cepat
                </h3>
                <div class="flex flex-wrap gap-4">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('buku.create') }}" class="group flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Buku Baru
                        </a>
                        @else
                        <a href="{{ route('buku.index') }}" class="group flex items-center px-6 py-3 bg-white border-2 border-indigo-600 text-indigo-600 rounded-2xl font-bold text-sm hover:bg-indigo-600 hover:text-white transition-all duration-300">
                            Eksplorasi Buku
                        </a>
                        <a href="{{ route('peminjaman.create') }}" class="group flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all duration-300">
                            Ajukan Peminjaman
                        </a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-slate-100">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ auth()->user()->isAdmin() ? 'Peminjaman Terbaru' : 'Riwayat Peminjaman' }}
                    </h3>
                    <a href="{{ route('peminjaman.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700">Lihat Semua &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Anggota</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">Judul Buku</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @php
                                $query = \App\Models\Peminjaman::with(['anggota','buku'])->latest();
                                $recentPinjam = auth()->user()->isAdmin() ? $query->take(5)->get() : ($anggotaLogin ? $query->where('anggota_id', $anggotaLogin->id)->take(5)->get() : collect());
                            @endphp
                            @forelse($recentPinjam as $p)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-800">{{ $p->anggota->nama }}</p>
                                    <p class="text-xs text-slate-400">{{ $p->tanggal_pinjam->format('d M Y') }}</p>
                                </td>
                                <td class="px-8 py-5 text-sm font-medium text-slate-600">{{ $p->buku->judul }}</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="inline-flex px-4 py-1.5 text-[10px] font-black uppercase tracking-tighter rounded-full {{ $p->badgeStatus() }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-4xl mb-3">📭</span>
                                        <p class="text-slate-400 font-medium">Belum ada aktivitas peminjaman.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>