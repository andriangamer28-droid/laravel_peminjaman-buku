<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            📚 Koleksi Buku
        </h2>
    </x-slot>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="modal-hapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Hapus Buku?</h4>
                    <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-5">Buku <span id="nama-buku-hapus" class="font-semibold text-gray-800"></span> akan dihapus permanen dari sistem.</p>
            <div class="flex gap-3">
                <button onclick="tutupModal()" class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm transition">Batal</button>
                <button id="btn-konfirmasi-hapus" class="flex-1 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm transition">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h3 class="text-lg font-medium">Daftar Buku</h3>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('buku.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Buku
                            </a>
                        @endif
                    </div>

                    {{-- Filter & Search --}}
                    <form method="GET" action="{{ route('buku.index') }}" class="mb-6 space-y-3">
                        {{-- Search --}}
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    placeholder="Cari judul, penulis, ISBN..."
                                    class="w-full pl-9 pr-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">Cari</button>
                            @if(($search ?? '') || ($kategoriId ?? '') || ($penerbit ?? ''))
                                <a href="{{ route('buku.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm">Reset</a>
                            @endif
                        </div>

                        {{-- Filter Kategori & Penerbit --}}
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Kategori:</label>
                                <select name="kategori_id" onchange="this.form.submit()"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                                    <option value="">Semua</option>
                                    @foreach($kategoris as $kat)
                                        <option value="{{ $kat->id }}" {{ ($kategoriId ?? '') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Penerbit:</label>
                                <select name="penerbit" onchange="this.form.submit()"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                                    <option value="">Semua</option>
                                    @foreach($penerbitList as $p)
                                        <option value="{{ $p }}" {{ ($penerbit ?? '') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Badge filter aktif --}}
                            @if($kategoriId ?? '')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs">
                                    📂 {{ $kategoris->firstWhere('id', $kategoriId)?->nama }}
                                    <a href="{{ route('buku.index', array_filter(['search'=>$search,'penerbit'=>$penerbit])) }}" class="hover:text-indigo-900">✕</a>
                                </span>
                            @endif
                            @if($penerbit ?? '')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                    🏢 {{ $penerbit }}
                                    <a href="{{ route('buku.index', array_filter(['search'=>$search,'kategori_id'=>$kategoriId])) }}" class="hover:text-green-900">✕</a>
                                </span>
                            @endif
                        </div>
                    </form>

                    @if(($search ?? '') || ($kategoriId ?? '') || ($penerbit ?? ''))
                        <p class="text-sm text-gray-500 mb-4">{{ $bukus->total() }} buku ditemukan</p>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded"><p class="text-green-700">{{ session('success') }}</p></div>
                    @endif

                    {{-- Grid --}}
                    @if($bukus->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($bukus as $buku)
                        <div class="group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md hover:border-indigo-300 transition-all duration-200">
                            <a href="{{ route('buku.show', $buku) }}" class="block">
                                @if($buku->foto)
                                    <img src="{{ asset('storage/'.$buku->foto) }}" alt="{{ $buku->judul }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-200">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-indigo-100 to-blue-50 flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        <p class="text-xs text-indigo-300 mt-2">No Cover</p>
                                    </div>
                                @endif
                            </a>
                            <div class="p-3">
                                <a href="{{ route('buku.show', $buku) }}">
                                    <h4 class="font-semibold text-sm text-gray-800 leading-tight line-clamp-2 hover:text-indigo-600 transition">{{ $buku->judul }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 truncate">{{ $buku->penulis }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $buku->kategori->nama }}</p>
                                </a>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ $buku->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        Stok: {{ $buku->stok }}
                                    </span>
                                </div>
                                @if(auth()->user()->isAdmin())
                                <div class="mt-2 pt-2 border-t border-gray-100 flex gap-2">
                                    <a href="{{ route('buku.edit', $buku) }}" class="flex-1 text-center text-xs text-amber-600 hover:text-amber-700 font-medium">Edit</a>
                                    <span class="text-gray-200">|</span>
                                    {{-- Tombol hapus pakai modal --}}
                                    <button type="button"
                                        onclick="bukaModalHapus('{{ $buku->judul }}', '{{ route('buku.destroy', $buku) }}')"
                                        class="flex-1 text-xs text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <p>Tidak ada buku yang sesuai filter.</p>
                    </div>
                    @endif

                    <div class="mt-6">{{ $bukus->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form hapus hidden --}}
    <form id="form-hapus" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
    function bukaModalHapus(nama, url) {
        document.getElementById('nama-buku-hapus').textContent = nama;
        document.getElementById('form-hapus').action = url;
        document.getElementById('btn-konfirmasi-hapus').onclick = function() {
            document.getElementById('form-hapus').submit();
        };
        document.getElementById('modal-hapus').classList.remove('hidden');
    }
    function tutupModal() {
        document.getElementById('modal-hapus').classList.add('hidden');
    }
    // Tutup modal jika klik backdrop
    document.getElementById('modal-hapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });
    </script>
</x-app-layout>
