<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight flex items-center gap-3">
            <span class="p-2 bg-indigo-100 rounded-xl text-xl">📚</span>
            {{ __('Koleksi Perpustakaan') }}
        </h2>
    </x-slot>

    {{-- Modal Konfirmasi Hapus (Enhanced) --}}
    <div id="modal-hapus" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-[100] transition-all duration-300">
        <div class="bg-white rounded-[2rem] shadow-2xl p-8 w-full max-w-sm mx-4 transform transition-all">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-slate-800">Hapus Buku?</h4>
                <p class="text-slate-500 mt-2">Buku <span id="nama-buku-hapus" class="font-bold text-slate-700"></span> akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.</p>
            </div>
            <div class="flex gap-3 mt-8">
                <button onclick="tutupModal()" class="flex-1 py-3.5 px-4 bg-slate-100 text-slate-600 font-bold rounded-2xl hover:bg-slate-200 transition-all">Batal</button>
                <button id="btn-konfirmasi-hapus" class="flex-1 py-3.5 px-4 bg-rose-500 text-white font-bold rounded-2xl hover:bg-rose-600 shadow-lg shadow-rose-100 transition-all">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div class="py-10 bg-[#fafafa] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Search & Filter Section --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="space-y-1">
                        <h3 class="text-xl font-bold text-slate-800">Cari Koleksi</h3>
                        <p class="text-sm text-slate-400 font-medium">Temukan buku favorit Anda berdasarkan judul atau penulis</p>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('buku.create') }}" class="flex items-center px-6 py-3.5 bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Buku
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('buku.index') }}" class="mt-8 grid grid-cols-1 md:grid-cols-12 gap-4">
                    {{-- Search Input --}}
                    <div class="md:col-span-6 relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                            placeholder="Cari judul, penulis, atau ISBN..." 
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all text-sm font-medium placeholder:text-slate-400">
                    </div>

                    {{-- Category Select --}}
                    <div class="md:col-span-3">
                        <select name="kategori_id" onchange="this.form.submit()" 
                            class="w-full px-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all text-sm font-bold text-slate-600 cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ ($kategoriId ?? '') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-slate-800 transition-all">Filter</button>
                        @if(($search ?? '') || ($kategoriId ?? '') || ($penerbit ?? ''))
                            <a href="{{ route('buku.index') }}" class="p-3.5 bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-100 transition-all" title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Grid Section --}}
            @if($bukus->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($bukus as $buku)
                        <div class="group bg-white rounded-[2rem] border border-slate-100 overflow-hidden hover:shadow-2xl hover:shadow-indigo-100 hover:-translate-y-2 transition-all duration-300">
                            {{-- Cover Image --}}
                            <div class="relative aspect-[3/4] overflow-hidden bg-slate-100">
                                @if($buku->foto)
                                    <img src="{{ asset('storage/'.$buku->foto) }}" alt="{{ $buku->judul }}" 
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                @endif
                                {{-- Quick Status Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-tighter rounded-full {{ $buku->stok > 0 ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                        {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <div class="min-h-[80px]">
                                    <h4 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $buku->judul }}
                                    </h4>
                                    <p class="text-xs font-semibold text-slate-400 mt-2 truncate italic">oleh {{ $buku->penulis }}</p>
                                    <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mt-1">{{ $buku->kategori->nama }}</p>
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                                    <a href="{{ route('buku.show', $buku) }}" class="text-xs font-black text-slate-900 hover:text-indigo-600">DETAIL &rarr;</a>
                                    
                                    @if(auth()->user()->isAdmin())
                                        <div class="flex gap-3">
                                            <a href="{{ route('buku.edit', $buku) }}" class="text-slate-400 hover:text-amber-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <button onclick="bukaModalHapus('{{ $buku->judul }}', '{{ route('buku.destroy', $buku) }}')" class="text-slate-400 hover:text-rose-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-12 px-4">
                    {{ $bukus->links() }}
                </div>
            @else
                <div class="bg-white rounded-[2.5rem] p-20 text-center border border-dashed border-slate-200">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-slate-800">Tidak ada koleksi ditemukan</h3>
                    <p class="text-slate-400 mt-2">Coba ubah kata kunci atau filter pencarian Anda</p>
                    <a href="{{ route('buku.index') }}" class="inline-block mt-6 text-indigo-600 font-bold hover:underline">Lihat Semua Koleksi</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Form Hapus (Tetap Sama) --}}
    <form id="form-hapus" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function bukaModalHapus(nama, url) {
            const modal = document.getElementById('modal-hapus');
            document.getElementById('nama-buku-hapus').textContent = nama;
            document.getElementById('form-hapus').action = url;
            document.getElementById('btn-konfirmasi-hapus').onclick = () => document.getElementById('form-hapus').submit();
            
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