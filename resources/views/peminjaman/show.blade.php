<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h2 class="font-black text-2xl text-slate-800 leading-tight">Detail Transaksi</h2>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-[1.25rem] flex items-center gap-3 animate-fade-in-down">
                    <div class="bg-emerald-500 rounded-full p-1 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                {{-- Header Card --}}
                <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Nomor Referensi</p>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">TRX-{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-sm {{ $peminjaman->badgeStatus() }}">
                            ● {{ $peminjaman->status }}
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        
                        {{-- Data Peminjam & Buku --}}
                        <div class="space-y-8">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 shrink-0 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Identitas Anggota</p>
                                    <p class="font-black text-slate-800 leading-tight text-lg">{{ $peminjaman->anggota->nama }}</p>
                                    <p class="text-xs font-bold text-slate-400">{{ $peminjaman->anggota->email }}</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-12 h-12 shrink-0 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Koleksi Buku</p>
                                    <p class="font-black text-slate-800 leading-tight text-lg">{{ $peminjaman->buku->judul }}</p>
                                    <p class="text-xs font-bold text-slate-400">{{ $peminjaman->buku->penulis }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Timeline Waktu --}}
                        <div class="bg-slate-50 rounded-[2rem] p-6 space-y-6">
                            <div class="flex justify-between items-center border-b border-slate-200 pb-4">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pinjam</p>
                                <p class="font-black text-slate-700">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
                            </div>
                            <div class="flex justify-between items-center border-b border-slate-200 pb-4">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-orange-500">Batas</p>
                                <p class="font-black text-orange-600">{{ $peminjaman->tanggal_pinjam->addDays(7)->format('d/m/Y') }}</p>
                            </div>
                            @if($peminjaman->tanggal_kembali)
                            <div class="flex justify-between items-center text-emerald-600">
                                <p class="text-[10px] font-black uppercase tracking-widest">Kembali</p>
                                <p class="font-black">{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Section Khusus: Denda, Token, Catatan --}}
                    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($denda > 0)
                            <div class="bg-rose-50 border border-rose-100 rounded-[1.5rem] p-6 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-1">Tagihan Denda</p>
                                    <p class="text-2xl font-black text-rose-600">Rp {{ number_format($denda, 0, ',', '.') }}</p>
                                </div>
                                <div class="p-3 bg-rose-500 text-white rounded-2xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                        @endif

                        @if($peminjaman->token)
                            <div class="bg-indigo-600 rounded-[1.5rem] p-6 text-white shadow-xl shadow-indigo-100">
                                <p class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-2">Token Pengambilan</p>
                                <div class="flex items-center justify-between">
                                    <p class="font-mono text-3xl font-black tracking-[0.3em]">{{ $peminjaman->token }}</p>
                                    <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($peminjaman->catatan_admin)
                        <div class="mt-6 p-5 bg-slate-50 border-l-4 border-rose-500 rounded-r-2xl">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Administrasi</p>
                            <p class="text-sm font-bold text-slate-700 italic">"{{ $peminjaman->catatan_admin }}"</p>
                        </div>
                    @endif

                    {{-- Countdown Status --}}
                    @if($peminjaman->status === 'dipinjam')
                        @php $sisa = $peminjaman->sisaHari(); @endphp
                        <div class="mt-8 p-6 rounded-[1.5rem] flex items-center gap-5 {{ $sisa < 0 ? 'bg-rose-50 border border-rose-100' : 'bg-indigo-50 border border-indigo-100' }}">
                            <div class="shrink-0 w-12 h-12 flex items-center justify-center rounded-2xl {{ $sisa < 0 ? 'bg-rose-500 text-white' : 'bg-indigo-500 text-white' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                @if($sisa < 0)
                                    <p class="font-black text-rose-700 leading-tight">Terjadi Keterlambatan!</p>
                                    <p class="text-xs font-bold text-rose-500 uppercase">Segera kembalikan buku. Telat {{ abs($sisa) }} hari.</p>
                                @else
                                    <p class="font-black text-indigo-700 leading-tight">Masa Pinjam Aktif</p>
                                    <p class="text-xs font-bold text-indigo-500 uppercase">Sisa {{ $sisa }} hari lagi untuk pengembalian gratis.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Action Bar --}}
                <div class="px-8 py-8 bg-slate-50 border-t border-slate-100 flex flex-wrap items-center gap-4">
                    @if(auth()->user()->isAdmin())
                        @if($peminjaman->status === 'menunggu')
                            <form action="{{ route('peminjaman.setujui', $peminjaman) }}" method="POST" class="shrink-0">
                                @csrf @method('PATCH')
                                <button class="px-6 py-3 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Setujui Pinjaman
                                </button>
                            </form>
                            <button onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                                class="px-6 py-3 bg-white border-2 border-rose-100 text-rose-600 font-black rounded-xl hover:bg-rose-50 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tolak
                            </button>
                        @endif

                        @if($peminjaman->status === 'disetujui')
                            <form action="{{ route('peminjaman.ambil', $peminjaman) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-6 py-3 bg-indigo-600 text-white font-black rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    Konfirmasi Pengambilan
                                </button>
                            </form>
                        @endif

                        @if($peminjaman->status === 'dipinjam')
                            <form action="{{ route('peminjaman.kembalikan', $peminjaman) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-6 py-3 bg-emerald-600 text-white font-black rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 0118 0z"/></svg>
                                    Proses Pengembalian
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST" class="ml-auto">
                            @csrf @method('DELETE')
                            <button class="p-3 text-rose-300 hover:text-rose-600 transition" onclick="return confirm('Hapus data transaksi ini secara permanen?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    @endif

                    @if($peminjaman->token)
                        <a href="{{ route('peminjaman.print', $peminjaman) }}" target="_blank"
                            class="px-6 py-3 bg-slate-800 text-white font-black rounded-xl hover:bg-slate-900 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Bukti
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tolak (Elegant Version) --}}
    <div id="modal-tolak" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl p-8 w-full max-w-md animate-scale-up">
            <h4 class="font-black text-2xl text-slate-800 mb-2">Tolak Pengajuan</h4>
            <p class="text-slate-400 text-sm font-bold mb-6 uppercase tracking-widest">Berikan alasan kepada anggota</p>
            
            <form action="{{ route('peminjaman.tolak', $peminjaman) }}" method="POST">
                @csrf @method('PATCH')
                <textarea name="catatan_admin" rows="4" placeholder="Contoh: Stok buku rusak atau identitas anggota tidak valid..."
                    class="w-full rounded-[1.25rem] border-slate-100 bg-slate-50 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-rose-100 focus:border-rose-400 transition-all mb-6 p-4"></textarea>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 py-4 bg-rose-600 text-white font-black rounded-2xl hover:bg-rose-700 transition shadow-lg shadow-rose-100">Konfirmasi Tolak</button>
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="flex-1 py-4 bg-slate-100 text-slate-500 font-black rounded-2xl hover:bg-slate-200 transition">Batal</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>