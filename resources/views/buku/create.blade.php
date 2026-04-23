<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <a href="{{ route('buku.index') }}" class="p-2 bg-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            Registrasi Koleksi Buku
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Left Side: Image Upload --}}
                    <div class="lg:col-span-4">
                        <div class="sticky top-8">
                            <div class="bg-white p-6 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Sampul Buku</label>
                                
                                <div class="relative group">
                                    {{-- Preview Container --}}
                                    <div id="preview-wrapper" class="relative aspect-[3/4] rounded-[2rem] overflow-hidden bg-slate-100 border-2 border-dashed border-slate-200 transition-all group-hover:border-indigo-300">
                                        <img id="foto-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                                        
                                        {{-- Default Placeholder --}}
                                        <div id="placeholder-content" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                            <div class="p-4 bg-slate-50 rounded-2xl mb-3">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <p class="text-xs font-bold leading-tight">Klik untuk unggah foto sampul</p>
                                            <p class="text-[10px] mt-1 opacity-60">Format: JPG, PNG (Maks 2MB)</p>
                                        </div>

                                        <input type="file" name="foto" id="foto" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewFoto(this)">
                                    </div>
                                    
                                    @error('foto')<p class="text-rose-500 text-[10px] font-black mt-3 ml-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="mt-6 bg-amber-50 rounded-2xl p-4 border border-amber-100">
                                    <p class="text-[10px] text-amber-700 font-bold leading-relaxed">
                                        <span class="block uppercase tracking-tighter mb-1">Tips:</span>
                                        Gunakan rasio 3:4 untuk hasil terbaik di katalog.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Form Details --}}
                    <div class="lg:col-span-8 space-y-6">
                        <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                                
                                {{-- Judul --}}
                                <div class="md:col-span-2 group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Judul Utama Buku</label>
                                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Laskar Pelangi"
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                                    @error('judul')<p class="text-rose-500 text-xs font-bold mt-2 ml-2">{{ $message }}</p>@enderror
                                </div>

                                {{-- Penulis --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Nama Penulis</label>
                                    <input type="text" name="penulis" value="{{ old('penulis') }}" placeholder="Nama penulis..."
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                                </div>

                                {{-- Penerbit --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Penerbit</label>
                                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit..."
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                                </div>

                                {{-- ISBN --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Nomor ISBN</label>
                                    <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="978-xxx-xxx"
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                                </div>

                                {{-- Tahun Terbit --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Tahun Terbit</label>
                                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}"
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                </div>

                                {{-- Kategori --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Kategori Koleksi</label>
                                    <select name="kategori_id" class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Stok --}}
                                <div class="group">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Jumlah Stok (Buku)</label>
                                    <input type="number" name="stok" value="{{ old('stok', 1) }}" min="1"
                                        class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                                </div>

                            </div>

                            <div class="mt-12 flex flex-col sm:flex-row items-center gap-4 border-t border-slate-50 pt-8">
                                <button type="submit" class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 active:scale-95">
                                    Simpan Koleksi
                                </button>
                                <a href="{{ route('buku.index') }}" class="w-full sm:w-auto px-12 py-4 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-center">
                                    Batal
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
        const preview = document.getElementById('foto-preview');
        const placeholder = document.getElementById('placeholder-content');
        const wrapper = document.getElementById('preview-wrapper');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                wrapper.classList.remove('border-dashed');
                wrapper.classList.add('border-solid', 'border-indigo-500');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</x-app-layout>