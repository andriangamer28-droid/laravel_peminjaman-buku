<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-200 text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h2 class="font-black text-2xl text-slate-800 tracking-tight">
                {{ __('Tambah Kategori Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Card Utama --}}
            <div class="bg-white shadow-xl shadow-slate-200/60 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="p-8 sm:p-12">
                    <div class="mb-10">
                        <h3 class="text-xl font-black text-slate-800">Detail Kategori</h3>
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-1">Gunakan kategori yang spesifik untuk mempermudah pencarian buku</p>
                    </div>

                    <form action="{{ route('kategori.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        {{-- Nama Kategori --}}
                        <div class="group">
                            <label for="nama" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Kategori</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                                placeholder="Contoh: Sains Fiksi, Biografi..."
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl font-bold text-slate-700 placeholder-slate-300 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300" required>
                            @error('nama')
                                <p class="text-rose-500 text-xs font-bold mt-2 ml-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="group">
                            <label for="deskripsi" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" 
                                placeholder="Jelaskan cakupan buku dalam kategori ini..."
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl font-bold text-slate-700 placeholder-slate-300 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-rose-500 text-xs font-bold mt-2 ml-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-6">
                            <button type="submit" 
                                class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-300 active:scale-95">
                                Simpan Kategori
                            </button>
                            <a href="{{ route('kategori.index') }}" 
                                class="w-full sm:w-auto px-10 py-4 bg-white text-slate-400 font-bold rounded-2xl border border-slate-100 hover:bg-slate-50 hover:text-slate-600 transition-all duration-300 text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Tip --}}
            <div class="mt-8 px-8 py-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50 flex items-center gap-4">
                <span class="text-xl">💡</span>
                <p class="text-xs font-bold text-indigo-400 leading-relaxed">
                    Kategori yang rapi membantu anggota menemukan buku favorit mereka lebih cepat melalui sistem filter.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>