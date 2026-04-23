<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
                <a href="{{ route('anggota.index') }}" class="p-2 bg-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                Profil Lengkap Anggota
            </h2>
            
            <div class="flex gap-2">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('anggota.edit', $anggota) }}" class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L12.172 13.514a1.5 1.5 0 01-.632.406l-3.218.804 1.103-3.218a1.5 1.5 0 01.406-.632l8.341-8.341z"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Profile Header Card --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden mb-8">
                <div class="p-8 md:p-12 flex flex-col md:flex-row items-center gap-8">
                    @php
                        $userAnggota = \App\Models\User::where('email', $anggota->email)->first();
                    @endphp
                    
                    <div class="relative">
                        <img src="{{ $userAnggota ? $userAnggota->fotoUrl() : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=6366f1&color=fff&size=200' }}"
                             alt="{{ $anggota->nama }}"
                             class="w-32 h-32 md:w-40 md:h-40 rounded-[2.5rem] object-cover ring-8 ring-indigo-50 shadow-2xl">
                        <div class="absolute -bottom-2 -right-2 bg-emerald-500 text-white p-2 rounded-xl border-4 border-white shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-4 justify-center md:justify-start">
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $anggota->nama }}</h3>
                            <span class="inline-flex items-center px-4 py-1 bg-emerald-100 text-emerald-700 text-xs font-black uppercase tracking-widest rounded-full border border-emerald-200">
                                Anggota Aktif
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                            <div class="flex items-center justify-center md:justify-start gap-3 text-slate-500">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                </div>
                                <span class="font-bold text-sm">{{ $anggota->email }}</span>
                            </div>
                            <div class="flex items-center justify-center md:justify-start gap-3 text-slate-500">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <span class="font-bold text-sm">{{ $anggota->telepon }}</span>
                            </div>
                            <div class="md:col-span-2 flex items-start justify-center md:justify-start gap-3 text-slate-500">
                                <div class="p-2 bg-slate-100 rounded-lg text-slate-400 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <span class="font-bold text-sm leading-relaxed italic">{{ $anggota->alamat }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-indigo-600 p-6 rounded-[2rem] text-white shadow-lg shadow-indigo-100">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Total Pinjam</p>
                    <p class="text-3xl font-black mt-1">{{ $anggota->peminjamans->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Berjalan</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $anggota->peminjamans->where('status', 'dipinjam')->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Selesai</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $anggota->peminjamans->where('status', 'kembali')->count() }}</p>
                </div>
                <div class="bg-rose-50 p-6 rounded-[2rem] border border-rose-100">
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Total Denda</p>
                    <p class="text-xl font-black text-rose-600 mt-1 truncate">Rp {{ number_format($anggota->peminjamans->sum('denda'), 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Loan History --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                    <h4 class="font-black text-slate-800 uppercase tracking-wider text-sm">Riwayat Peminjaman Koleksi</h4>
                    <span class="p-2 bg-slate-50 rounded-xl">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-50">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Judul Buku</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($anggota->peminjamans->sortByDesc('tanggal_pinjam') as $pinjam)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-8 py-5">
                                    <p class="font-bold text-slate-700">{{ $pinjam->buku->judul }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">ISBN: {{ $pinjam->buku->isbn ?? '-' }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-600">{{ $pinjam->tanggal_pinjam->format('d M Y') }}</span>
                                        <span class="text-[10px] text-slate-400 italic">sampai {{ $pinjam->tanggal_kembali ? $pinjam->tanggal_kembali->format('d M Y') : 'Sekarang' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-tighter rounded-lg {{ $pinjam->badgeStatus() }}">
                                        {{ $pinjam->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-slate-700">
                                    {{ $pinjam->denda > 0 ? 'Rp '.number_format($pinjam->denda, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center">
                                    <p class="font-bold text-slate-300 italic">Belum ada riwayat aktivitas peminjaman.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Danger Action --}}
            @if(auth()->user()->isAdmin())
            <div class="mt-12 flex justify-center">
                <form action="{{ route('anggota.destroy', $anggota) }}" method="POST" onsubmit="return confirm('Hapus seluruh data anggota ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-rose-100 text-rose-500 font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Keanggotaan
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>