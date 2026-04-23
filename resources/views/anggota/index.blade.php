<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <span class="p-2 bg-indigo-100 rounded-xl text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </span>
            Manajemen Anggota
        </h2>
    </x-slot>

    {{-- Modal Konfirmasi Hapus (Enhanced) --}}
    <div id="modal-hapus" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all">
        <div class="bg-white rounded-[2.5rem] shadow-2xl p-8 w-full max-w-sm mx-4 transform transition-all border border-slate-100">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h4 class="text-xl font-black text-slate-800">Hapus Anggota?</h4>
                <p class="text-slate-500 text-sm mt-2">Data anggota <span id="nama-anggota-hapus" class="font-bold text-slate-800"></span> dan akun loginnya akan dihapus secara permanen.</p>
            </div>
            <div class="flex gap-3 mt-8">
                <button onclick="tutupModal()" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">Batal</button>
                <button id="btn-konfirmasi-hapus" class="flex-1 py-3 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header & Action Section --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div class="space-y-1">
                    <h3 class="text-slate-400 text-xs font-black uppercase tracking-[0.2em]">Database Center</h3>
                    <p class="text-3xl font-black text-slate-800">Daftar Anggota Aktif</p>
                </div>
                <a href="{{ route('anggota.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah Anggota Baru
                </a>
            </div>

            {{-- Filter & Search Card --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8 mb-8">
                <form method="GET" action="{{ route('anggota.index') }}" class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- Search Input --}}
                        <div class="lg:col-span-2 relative group">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Cari Database</label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    placeholder="Ketik nama, email, atau nomor telepon..."
                                    class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-medium">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-end gap-3">
                            <button type="submit" class="flex-1 py-3.5 bg-slate-800 text-white rounded-2xl font-black hover:bg-slate-900 shadow-lg shadow-slate-200 transition-all">Cari Data</button>
                            @if($search || $dari || $sampai)
                                <a href="{{ route('anggota.index') }}" class="p-3.5 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-100 transition-all" title="Reset Filter">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Date Range Filter --}}
                    <div class="pt-6 border-t border-slate-50 flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rentang Pendaftaran</span>
                            <div class="flex items-center gap-2">
                                <input type="date" name="dari" value="{{ $dari ?? '' }}" class="rounded-xl border-slate-100 bg-slate-50 text-xs font-bold text-slate-600 focus:ring-indigo-100 focus:border-indigo-500">
                                <span class="text-slate-300">—</span>
                                <input type="date" name="sampai" value="{{ $sampai ?? '' }}" class="rounded-xl border-slate-100 bg-slate-50 text-xs font-bold text-slate-600 focus:ring-indigo-100 focus:border-indigo-500">
                            </div>
                        </div>
                        <button type="submit" class="text-xs font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-700 transition-colors">Terapkan Filter Tanggal</button>
                    </div>
                </form>
            </div>

            {{-- Table Card --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Profil Anggota</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Informasi Kontak</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Alamat Domisili</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Terdaftar</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($anggotas as $anggota)
                            @php $userAnggota = \App\Models\User::where('email', $anggota->email)->first(); @endphp
                            <tr class="group hover:bg-indigo-50/30 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <img src="{{ $userAnggota ? $userAnggota->fotoUrl() : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=6366f1&color=fff&size=100' }}"
                                                alt="{{ $anggota->nama }}"
                                                class="w-12 h-12 rounded-2xl object-cover ring-2 ring-white shadow-md group-hover:scale-110 transition-transform">
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $anggota->nama }}</span>
                                            <span class="text-xs text-slate-400 font-medium tracking-tight">ID: #{{ str_pad($anggota->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700">{{ $anggota->email }}</span>
                                        <span class="text-xs font-bold text-slate-400">{{ $anggota->telepon }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 max-w-[200px]">
                                    <p class="text-sm text-slate-500 font-medium truncate italic" title="{{ $anggota->alamat }}">
                                        {{ $anggota->alamat }}
                                    </p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-black w-fit uppercase">
                                        {{ $anggota->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-end items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('anggota.show', $anggota) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('anggota.edit', $anggota) }}" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <button type="button"
                                            onclick="bukaModalHapus('{{ $anggota->nama }}', '{{ route('anggota.destroy', $anggota) }}')"
                                            class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="p-4 bg-slate-50 rounded-full text-slate-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold italic">Data anggota tidak ditemukan dalam database.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-8 bg-slate-50/30 border-t border-slate-50">
                    {{ $anggotas->links() }}
                </div>
            </div>
        </div>
    </div>

    <form id="form-hapus" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>

    <script>
    function bukaModalHapus(nama, url) {
        document.getElementById('nama-anggota-hapus').textContent = nama;
        document.getElementById('form-hapus').action = url;
        document.getElementById('btn-konfirmasi-hapus').onclick = () => document.getElementById('form-hapus').submit();
        
        const modal = document.getElementById('modal-hapus');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100'), 10);
    }
    function tutupModal() {
        const modal = document.getElementById('modal-hapus');
        modal.classList.add('hidden');
    }
    document.getElementById('modal-hapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });
    </script>
</x-app-layout>