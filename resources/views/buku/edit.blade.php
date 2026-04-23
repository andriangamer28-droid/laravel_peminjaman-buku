<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <a href="{{ route('buku.index') }}" class="p-2 bg-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            Perbarui Data Buku
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form action="{{ route('buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- SISI KIRI: Managemen Sampul --}}
                    <div class="lg:col-span-4">
                        <div class="sticky top-8 space-y-6">
                            <div class="bg-white p-6 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Sampul Saat Ini</label>
                                
                                <div class="relative group aspect-[3/4] rounded-[2rem] overflow-hidden bg-slate-100 border-2 border-slate-200 shadow-inner">
                                    {{-- Image Display --}}
                                    <img id="foto-preview" 
                                         src="{{ $buku->foto ? asset('storage/'.$buku->foto) : 'https://placehold.co/600x800?text=No+Cover' }}" 
                                         alt="Preview" 
                                         class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105">
                                    
                                    {{-- Overlay untuk Upload --}}
                                    <label class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center cursor-pointer backdrop-blur-[2px]">
                                        <div class="p-3 bg-white/20 rounded-2xl mb-2">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <span class="text-white font-black text-xs uppercase tracking-tighter">Ganti Sampul</span>
                                        <input type="file" name="foto" id="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                                    </label>
                                </div>
                                
                                <div class="mt-4 flex items-start gap-3 p-3 bg-indigo-50 rounded-2xl border border-indigo-100">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                    <p class="text-[10px] text-indigo-700 font-bold leading-relaxed">Kosongkan jika tidak ingin mengubah sampul buku.</p>
                                </div>
                                @error('foto')<p class="text-rose-500 text-[10px] font-black mt-3 ml-2">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- SISI KANAN: Form Detail --}}
                    <div class="lg:col-span-8">
                        <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                                
                                {{-- Judul --}}
                                <div class="md:col-span-2 group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Judul Buku</label>
                                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" 
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                    @error('judul')<p class="text-rose-500 text-xs font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                                </div>

                                {{-- Penulis --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Penulis</label>
                                    <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" 
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                </div>

                                {{-- Penerbit --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Penerbit</label>
                                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" 
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                </div>

                                {{-- ISBN --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">ISBN</label>
                                    <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" 
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                </div>

                                {{-- Tahun Terbit --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Tahun Terbit</label>
                                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="{{ date('Y') }}"
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                </div>

                                {{-- Kategori --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Kategori</label>
                                    <select name="kategori_id" class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all cursor-pointer" required>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ old('kategori_id', $buku->kategori_id) == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Stok --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Persediaan Stok</label>
                                    <div class="relative">
                                        <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" min="1"
                                            class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 uppercase tracking-widest">Ekspl</span>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-12 flex flex-col sm:flex-row items-center gap-4 border-t border-slate-50 pt-8">
                                <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 active:scale-95 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('buku.index') }}" class="w-full sm:w-auto px-10 py-4 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-center">
                                    Batalkan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById('foto-preview');
                preview.src = e.target.result;
                // Tambahkan efek kilatan saat foto berubah
                preview.classList.add('brightness-125');
                setTimeout(() => preview.classList.remove('brightness-125'), 300);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</x-app-layout>