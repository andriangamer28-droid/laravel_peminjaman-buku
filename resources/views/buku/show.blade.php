<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-slate-800 leading-tight">Detail Koleksi</h2>
            <a href="{{ route('buku.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-[3rem] border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row gap-12">

                        {{-- SISI KIRI: Visual Buku --}}
                        <div class="flex-shrink-0 mx-auto md:mx-0">
                            <div class="relative group">
                                @if($buku->foto)
                                    <img src="{{ asset('storage/'.$buku->foto) }}" alt="{{ $buku->judul }}"
                                         class="w-64 h-80 object-cover rounded-[2rem] shadow-2xl shadow-indigo-200 border-4 border-white transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-64 h-80 bg-gradient-to-br from-slate-100 to-slate-200 rounded-[2rem] shadow-inner flex flex-col items-center justify-center border-4 border-white">
                                        <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-4">No Digital Cover</p>
                                    </div>
                                @endif
                                
                                {{-- Badge Status --}}
                                <div class="absolute -top-3 -right-3">
                                    <span class="flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider shadow-lg {{ $buku->stok > 0 ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                        {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- SISI KANAN: Informasi & Aksi --}}
                        <div class="flex-1 space-y-8">
                            <div>
                                <span class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-lg mb-3">
                                    {{ $buku->kategori->nama }}
                                </span>
                                <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">{{ $buku->judul }}</h1>
                                <p class="text-xl font-bold text-slate-400 mt-2 flex items-center gap-2">
                                    <span class="w-8 h-[2px] bg-slate-200"></span>
                                    {{ $buku->penulis }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-6 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Penerbit</p>
                                    <p class="font-bold text-slate-700">{{ $buku->penerbit }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Terbit</p>
                                    <p class="font-bold text-slate-700">{{ $buku->tahun_terbit }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ISBN</p>
                                    <p class="font-bold text-slate-700 tracking-tighter">{{ $buku->isbn }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stok Fisik</p>
                                    <p class="font-black text-2xl text-indigo-600">{{ $buku->stok }} <span class="text-xs text-slate-400 font-bold">Buku</span></p>
                                </div>
                            </div>

                            {{-- Logika Aksi --}}
                            <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                                @if($buku->stok > 0)
                                    @php
                                        $anggotaLogin = \App\Models\Anggota::where('email', auth()->user()->email)->first();
                                        $kuotaPenuh   = $anggotaLogin ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)->whereIn('status', ['menunggu','disetujui','dipinjam'])->count() >= 3 : false;
                                        $sudahPinjam  = $anggotaLogin ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)->where('buku_id', $buku->id)->whereIn('status', ['menunggu','disetujui','dipinjam'])->exists() : false;
                                    @endphp

                                    @if($sudahPinjam)
                                        <button disabled class="w-full sm:w-auto px-8 py-4 bg-slate-100 text-slate-400 font-black rounded-2xl flex items-center justify-center gap-2 cursor-not-allowed">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Sudah Masuk Daftar Pinjam
                                        </button>
                                    @elseif($kuotaPenuh && !auth()->user()->isAdmin())
                                        <div class="flex-1 p-4 bg-rose-50 border border-rose-100 rounded-2xl">
                                            <p class="text-xs font-bold text-rose-600 text-center uppercase tracking-tighter">⚠️ Limit Peminjaman Tercapai (Maks 3 Buku)</p>
                                        </div>
                                    @else
                                        <a href="{{ route('peminjaman.create', ['buku_id' => $buku->id]) }}"
                                           class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 active:scale-95 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                            Pinjam Buku Ini
                                        </a>
                                    @endif
                                @else
                                    <button disabled class="w-full sm:w-auto px-8 py-4 bg-rose-50 text-rose-400 font-black rounded-2xl border border-rose-100 cursor-not-allowed uppercase tracking-widest text-xs">
                                        Stok Habis di Perpustakaan
                                    </button>
                                @endif

                                {{-- Admin Tools --}}
                                @if(auth()->user()->isAdmin())
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <a href="{{ route('buku.edit', $buku) }}" class="p-4 bg-amber-100 text-amber-600 rounded-2xl hover:bg-amber-200 transition shadow-sm" title="Edit Buku">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-4 bg-rose-100 text-rose-600 rounded-2xl hover:bg-rose-200 transition shadow-sm" onclick="return confirm('Hapus buku ini secara permanen?')" title="Hapus Buku">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                
                {{-- Footer Info --}}
                <div class="bg-slate-50 border-t border-slate-100 px-8 py-6">
                    <p class="text-[10px] font-bold text-slate-400 text-center uppercase tracking-[0.3em]">Sistem Informasi Perpustakaan Digital &bull; Koleksi ID: #B-{{ str_pad($buku->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>