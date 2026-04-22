<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            📋 Form Peminjaman Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6">

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded"><p class="text-red-700">{{ session('error') }}</p></div>
                @endif

                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">

                        {{-- Pilih Anggota --}}
                        @if(auth()->user()->isAdmin())
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Anggota</label>
                                <select name="anggota_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                            {{ $anggota->nama }} ({{ $anggota->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('anggota_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        @else
                            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-lg">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <span class="ml-auto text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full">Peminjam</span>
                            </div>
                            <input type="hidden" name="anggota_id" value="{{ $anggotaLogin->id ?? '' }}">
                        @endif

                        {{-- Search & Pilih Buku --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Buku</label>

                            {{-- Search box --}}
                            <div class="relative mb-2">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" id="search-buku" placeholder="Ketik judul atau penulis..."
                                    class="w-full pl-9 pr-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>

                            {{-- Daftar buku (card style) --}}
                            <input type="hidden" name="buku_id" id="buku_id" value="{{ old('buku_id') }}" required>
                            <div id="buku-list" class="space-y-2 max-h-72 overflow-y-auto pr-1">
                                @foreach($bukus as $buku)
                                <label class="buku-item flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50"
                                    data-judul="{{ strtolower($buku->judul) }}" data-penulis="{{ strtolower($buku->penulis) }}" data-id="{{ $buku->id }}">
                                    <input type="radio" name="_buku_radio" value="{{ $buku->id }}" class="hidden" onchange="document.getElementById('buku_id').value=this.value; highlightSelected(this)">
                                    @if($buku->foto)
                                        <img src="{{ asset('storage/'.$buku->foto) }}" class="w-10 h-14 object-cover rounded shadow-sm flex-shrink-0">
                                    @else
                                        <div class="w-10 h-14 bg-indigo-100 rounded flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-sm text-gray-800 truncate">{{ $buku->judul }}</p>
                                        <p class="text-xs text-gray-500">{{ $buku->penulis }}</p>
                                        <p class="text-xs text-gray-400">{{ $buku->kategori->nama }}</p>
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded-full flex-shrink-0 {{ $buku->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        Stok: {{ $buku->stok }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                            <p id="no-result" class="hidden text-sm text-gray-400 text-center py-4">Buku tidak ditemukan.</p>
                            @error('buku_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                            Ajukan Peminjaman
                        </button>
                        <a href="{{ route('peminjaman.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Live search buku
    document.getElementById('search-buku').addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        const items = document.querySelectorAll('.buku-item');
        let visible = 0;
        items.forEach(item => {
            const match = item.dataset.judul.includes(q) || item.dataset.penulis.includes(q);
            item.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        document.getElementById('no-result').classList.toggle('hidden', visible > 0);
    });

    // Highlight item terpilih
    function highlightSelected(radio) {
        document.querySelectorAll('.buku-item').forEach(item => {
            item.classList.remove('border-indigo-500', 'bg-indigo-50', 'ring-2', 'ring-indigo-300');
        });
        const label = radio.closest('.buku-item');
        label.classList.add('border-indigo-500', 'bg-indigo-50', 'ring-2', 'ring-indigo-300');
    }
    </script>

    <script>
    // Auto-select buku jika ada selectedBuku dari URL
    document.addEventListener('DOMContentLoaded', function() {
        const selected = "{{ $selectedBuku ?? '' }}";
        if (selected) {
            document.querySelectorAll('.buku-item').forEach(item => {
                const radio = item.querySelector('input[type=radio]');
                if (radio && radio.value == selected) {
                    radio.checked = true;
                    document.getElementById('buku_id').value = selected;
                    highlightSelected(radio);
                    item.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }
    });
    </script>

</x-app-layout>