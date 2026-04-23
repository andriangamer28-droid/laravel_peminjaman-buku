<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 rounded-xl">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h2 class="font-black text-2xl text-slate-800 leading-tight">Form Peminjaman</h2>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                
                {{-- Progress Info (Opsional) --}}
                <div class="bg-indigo-600 px-8 py-4 flex justify-between items-center">
                    <p class="text-indigo-100 text-xs font-black uppercase tracking-widest">Langkah 1: Pilih Koleksi & Tanggal</p>
                    <span class="text-white/60 text-[10px] font-bold">Limit: 3 Buku/Anggota</span>
                </div>

                <div class="p-8">
                    @if(session('error'))
                        <div class="flex items-center gap-3 bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-2xl mb-8 animate-bounce">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <p class="text-sm font-bold">{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                            
                            {{-- KOLOM KIRI: Identitas --}}
                            <div class="space-y-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Identitas Peminjam</label>
                                    @if(auth()->user()->isAdmin())
                                        <div class="relative group">
                                            <select name="anggota_id" class="appearance-none block w-full rounded-[1.25rem] border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all cursor-pointer" required>
                                                <option value="">-- Cari Nama Anggota --</option>
                                                @foreach($anggotas as $anggota)
                                                    <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                                        {{ $anggota->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-indigo-50/50 border-2 border-dashed border-indigo-100 rounded-[1.25rem] p-5 flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-200">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-800 tracking-tight">{{ auth()->user()->name }}</p>
                                                <p class="text-xs font-bold text-indigo-500 uppercase tracking-tighter">Anggota Aktif</p>
                                            </div>
                                            <input type="hidden" name="anggota_id" value="{{ $anggotaLogin->id ?? '' }}">
                                        </div>
                                    @endif
                                    @error('anggota_id')<p class="text-rose-500 text-[10px] font-black mt-2 ml-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Waktu Peminjaman</label>
                                    <div class="relative">
                                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                               max="{{ date('Y-m-d') }}"
                                               class="block w-full rounded-[1.25rem] border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-3 ml-1 leading-relaxed">
                                        *Buku wajib dikembalikan maksimal <span class="text-indigo-500 font-black">7 hari</span> setelah tanggal pinjam.
                                    </p>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: Cari Buku --}}
                            <div class="flex flex-col h-full">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Cari & Pilih Buku</label>
                                
                                <div class="relative group mb-4">
                                    <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    </div>
                                    <input type="text" id="search-buku" placeholder="Judul atau Penulis..."
                                        class="w-full pl-14 pr-6 py-4 rounded-[1.25rem] border-slate-100 bg-slate-50 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all">
                                </div>

                                <input type="hidden" name="buku_id" id="buku_id" value="{{ old('buku_id') }}" required>
                                
                                <div id="buku-list" class="space-y-3 max-h-[320px] overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($bukus as $buku)
                                    <label class="buku-item flex items-center gap-4 p-4 bg-white border-2 border-slate-100 rounded-2xl cursor-pointer hover:border-indigo-200 transition-all duration-300 relative overflow-hidden group"
                                        data-judul="{{ strtolower($buku->judul) }}" data-penulis="{{ strtolower($buku->penulis) }}" data-id="{{ $buku->id }}">
                                        
                                        <input type="radio" name="_buku_radio" value="{{ $buku->id }}" class="hidden" onchange="document.getElementById('buku_id').value=this.value; highlightSelected(this)">
                                        
                                        {{-- Visual Cover --}}
                                        <div class="shrink-0">
                                            @if($buku->foto)
                                                <img src="{{ asset('storage/'.$buku->foto) }}" class="w-12 h-16 object-cover rounded-lg shadow-sm group-hover:rotate-3 transition-transform">
                                            @else
                                                <div class="w-12 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <p class="font-black text-slate-800 text-sm truncate leading-tight">{{ $buku->judul }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $buku->penulis }}</p>
                                        </div>

                                        <div class="text-right">
                                            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $buku->stok > 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                                {{ $buku->stok }} Sedia
                                            </span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                <p id="no-result" class="hidden text-xs font-bold text-slate-400 text-center py-10 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                                    Ups! Buku tidak ditemukan.
                                </p>
                                @error('buku_id')<p class="text-rose-500 text-[10px] font-black mt-2 ml-2">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mt-12 flex flex-col sm:flex-row items-center gap-4 pt-8 border-t border-slate-50">
                            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-[1.25rem] hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 active:scale-95 flex items-center justify-center gap-3">
                                <span>Ajukan Peminjaman</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                            <a href="{{ route('peminjaman.index') }}" class="w-full sm:w-auto px-10 py-4 bg-slate-100 text-slate-500 font-black rounded-[1.25rem] hover:bg-slate-200 transition text-center">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #6366f1; }
    </style>

    <script>
    // Live search buku (Optimized)
    document.getElementById('search-buku').addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        const items = document.querySelectorAll('.buku-item');
        let visible = 0;
        items.forEach(item => {
            const match = item.dataset.judul.includes(q) || item.dataset.penulis.includes(q);
            item.style.display = match ? 'flex' : 'none';
            if (match) visible++;
        });
        document.getElementById('no-result').classList.toggle('hidden', visible > 0);
    });

    // Highlight item terpilih dengan Class Tailwind
    function highlightSelected(radio) {
        document.querySelectorAll('.buku-item').forEach(item => {
            item.classList.remove('border-indigo-600', 'bg-indigo-50/50', 'ring-4', 'ring-indigo-100');
            item.classList.add('border-slate-100', 'bg-white');
        });
        const label = radio.closest('.buku-item');
        label.classList.remove('border-slate-100', 'bg-white');
        label.classList.add('border-indigo-600', 'bg-indigo-50/50', 'ring-4', 'ring-indigo-100');
    }

    // Auto-select buku dari Detail Page
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