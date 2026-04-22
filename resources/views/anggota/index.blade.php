<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            👥 Data Anggota
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
                    <h4 class="font-semibold text-gray-800">Hapus Anggota?</h4>
                    <p class="text-sm text-gray-500">Akun login juga akan ikut dihapus.</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-5">Anggota <span id="nama-anggota-hapus" class="font-semibold text-gray-800"></span> akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button onclick="tutupModal()" class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                <button id="btn-konfirmasi-hapus" class="flex-1 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Anggota Perpustakaan</h3>
                        <a href="{{ route('anggota.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Anggota
                        </a>
                    </div>

                    {{-- Search & Filter --}}
                    <form method="GET" action="{{ route('anggota.index') }}" class="mb-6 space-y-3">
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    placeholder="Cari nama, email, atau telepon..."
                                    class="w-full pl-9 pr-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">Cari</button>
                            @if(($search??'')||($dari??'')||($sampai??''))
                                <a href="{{ route('anggota.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm">Reset</a>
                            @endif
                        </div>

                        {{-- Filter Tanggal Daftar --}}
                        <div class="flex flex-wrap gap-3 items-center">
                            <span class="text-xs font-medium text-gray-500">Tanggal Daftar:</span>
                            <div class="flex items-center gap-2">
                                <label class="text-xs text-gray-500">Dari</label>
                                <input type="date" name="dari" value="{{ $dari ?? '' }}"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-xs text-gray-500">Sampai</label>
                                <input type="date" name="sampai" value="{{ $sampai ?? '' }}"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                            </div>
                            @if(($dari??'')||($sampai??''))
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700">Terapkan</button>
                            @endif
                        </div>

                        {{-- Badge filter aktif --}}
                        @if(($dari??'')||($sampai??''))
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">Filter aktif:</span>
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs">
                                📅
                                {{ ($dari??'') ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : '...' }}
                                —
                                {{ ($sampai??'') ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : '...' }}
                            </span>
                        </div>
                        @endif
                    </form>

                    @if(($search??'')||($dari??'')||($sampai??''))
                        <p class="text-sm text-gray-500 mb-4">{{ $anggotas->total() }} anggota ditemukan</p>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded"><p class="text-green-700">{{ session('success') }}</p></div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Daftar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($anggotas as $anggota)
                                @php $userAnggota = \App\Models\User::where('email', $anggota->email)->first(); @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $userAnggota ? $userAnggota->fotoUrl() : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=6366f1&color=fff&size=64' }}"
                                                alt="{{ $anggota->nama }}"
                                                class="w-9 h-9 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $anggota->nama }}</p>
                                                <p class="text-xs text-gray-500">{{ $anggota->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $anggota->telepon }}</td>
                                    <td class="px-4 py-4 text-gray-600 text-sm max-w-xs truncate">{{ $anggota->alamat }}</td>
                                    <td class="px-4 py-4 text-gray-500 text-sm">{{ $anggota->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-4 text-sm space-x-2">
                                        <a href="{{ route('anggota.show', $anggota) }}" class="text-indigo-600 hover:underline">Detail</a>
                                        <a href="{{ route('anggota.edit', $anggota) }}" class="text-amber-600 hover:underline">Edit</a>
                                        <button type="button"
                                            onclick="bukaModalHapus('{{ $anggota->nama }}', '{{ route('anggota.destroy', $anggota) }}')"
                                            class="text-red-600 hover:underline">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                    {{ ($search??'')||($dari??'')||($sampai??'') ? 'Tidak ada anggota yang sesuai filter.' : 'Belum ada data anggota.' }}
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $anggotas->links() }}</div>
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
        document.getElementById('modal-hapus').classList.remove('hidden');
    }
    function tutupModal() {
        document.getElementById('modal-hapus').classList.add('hidden');
    }
    document.getElementById('modal-hapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });
    </script>
</x-app-layout>
