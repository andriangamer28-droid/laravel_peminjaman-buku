<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <span class="p-2 bg-amber-100 rounded-xl text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </span>
            Laporan & Analisis
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Filter Section --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                    <h3 class="font-black text-slate-800 uppercase tracking-wider text-sm">Konfigurasi Laporan</h3>
                </div>
                
                <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-500 uppercase ml-1">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ $dari }}"
                            class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-500 uppercase ml-1">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ $sampai }}"
                            class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-500 uppercase ml-1">Status Transaksi</label>
                        <select name="status" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-bold text-slate-700">
                            <option value="">Semua Status</option>
                            @foreach(['menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'ditolak'] as $st)
                                <option value="{{ $st }}" {{ $status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-2xl font-black hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                            Filter
                        </button>
                        <a href="{{ route('laporan.print', ['dari' => $dari, 'sampai' => $sampai, 'status' => $status]) }}"
                            target="_blank"
                            class="p-3 bg-slate-800 text-white rounded-2xl hover:bg-slate-900 transition-all shadow-lg shadow-slate-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        </a>
                    </div>
                </form>
                <div class="mt-6 flex items-center gap-2 text-xs font-bold text-slate-400 italic">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Periode Aktif: {{ \Carbon\Carbon::parse($dari)->translatedFormat('d M Y') }} — {{ \Carbon\Carbon::parse($sampai)->translatedFormat('d M Y') }}
                </div>
            </div>

            {{-- Statistik Dashboard --}}
            <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
                @php
                    $stats = [
                        ['label' => 'Total', 'val' => $totalPeminjaman, 'color' => 'slate', 'bg' => 'bg-white'],
                        ['label' => 'Menunggu', 'val' => $totalMenunggu, 'color' => 'amber', 'bg' => 'bg-amber-50'],
                        ['label' => 'Dipinjam', 'val' => $totalDipinjam, 'color' => 'orange', 'bg' => 'bg-orange-50'],
                        ['label' => 'Kembali', 'val' => $totalDikembalikan, 'color' => 'emerald', 'bg' => 'bg-emerald-50'],
                        ['label' => 'Ditolak', 'val' => $totalDitolak, 'color' => 'rose', 'bg' => 'bg-rose-50'],
                    ];
                @endphp

                @foreach($stats as $s)
                <div class="{{ $s['bg'] }} border border-{{ $s['color'] }}-100 shadow-sm rounded-3xl p-5 transition-transform hover:-translate-y-1">
                    <p class="text-3xl font-black text-{{ $s['color'] }}-600">{{ $s['val'] }}</p>
                    <p class="text-[10px] font-black uppercase tracking-widest text-{{ $s['color'] }}-400 mt-1">{{ $s['label'] }}</p>
                </div>
                @endforeach

                <div class="bg-indigo-600 shadow-lg shadow-indigo-100 rounded-3xl p-5 col-span-2 lg:col-span-1 flex flex-col justify-center transition-transform hover:-translate-y-1">
                    <p class="text-xl font-black text-white leading-none">Rp{{ number_format($totalDenda, 0, ',', '.') }}</p>
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mt-1">Total Pendapatan Denda</p>
                </div>
            </div>

            {{-- Top Charts --}}
            <div class="grid lg:grid-cols-2 gap-8">
                {{-- Top Buku --}}
                <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8">
                    <h4 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span class="text-2xl">🔥</span> Buku Terpopuler
                    </h4>
                    <div class="space-y-4">
                        @forelse($topBuku as $item)
                        <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black shrink-0">
                                #{{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-black text-slate-800 truncate">{{ $item['buku']->judul }}</p>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-tight">{{ $item['buku']->penulis }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-indigo-600 leading-none">{{ $item['jumlah'] }}</p>
                                <p class="text-[9px] font-black text-slate-300 uppercase">Pinjaman</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-center py-10 text-slate-400 font-bold">Data belum tersedia.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Top Anggota --}}
                <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8">
                    <h4 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span class="text-2xl">🏆</span> Anggota Teraktif
                    </h4>
                    <div class="space-y-4">
                        @forelse($topAnggota as $item)
                        <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 font-black shrink-0">
                                #{{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-black text-slate-800 truncate">{{ $item['anggota']->nama }}</p>
                                <p class="text-xs text-slate-400 font-bold tracking-tight">{{ $item['anggota']->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-emerald-600 leading-none">{{ $item['jumlah'] }}</p>
                                <p class="text-[9px] font-black text-slate-300 uppercase">Aktivitas</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-center py-10 text-slate-400 font-bold">Data belum tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Detail Table --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <div>
                        <h4 class="text-xl font-black text-slate-800">Detail Transaksi</h4>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">{{ $peminjamans->count() }} Data Ditemukan</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">No</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Peminjam & Buku</th>
                                <th class="px-8 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Periode</th>
                                <th class="px-8 py-4 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($peminjamans as $i => $p)
                            <tr class="group hover:bg-slate-50/80 transition-all">
                                <td class="px-8 py-6 text-sm font-black text-slate-300">#{{ $i + 1 }}</td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $p->anggota->nama }}</span>
                                        <span class="text-xs text-slate-400 font-bold italic">{{ $p->buku->judul }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col text-xs font-bold text-slate-500">
                                        <span>In: {{ $p->tanggal_pinjam->format('d/m/Y') }}</span>
                                        <span class="{{ $p->tanggal_kembali ? 'text-emerald-500' : 'text-slate-300' }}">
                                            Out: {{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '---' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-block px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $p->badgeStatus() }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($p->denda > 0)
                                        <span class="text-sm font-black text-rose-600">Rp{{ number_format($p->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-200 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Tidak ada data untuk filter ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($peminjamans->count() > 0)
                        <tfoot class="bg-indigo-50/50">
                            <tr>
                                <td colspan="4" class="px-8 py-5 text-right text-xs font-black text-indigo-400 uppercase tracking-widest">Total Akumulasi Denda:</td>
                                <td class="px-8 py-5 text-right text-xl font-black text-indigo-600">Rp{{ number_format($totalDenda, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>