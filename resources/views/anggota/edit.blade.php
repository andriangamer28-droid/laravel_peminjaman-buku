<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <a href="{{ route('anggota.index') }}" class="p-2 bg-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            Perbarui Profil Anggota
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb context --}}
            <div class="mb-6 flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400">
                <span class="text-indigo-500">Anggota</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                <span>Edit Mode</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-800">{{ $anggota->nama }}</span>
            </div>

            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Modifikasi Data</p>
                        <h3 class="text-xl font-black text-slate-800">Detail Informasi</h3>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-black text-slate-300 uppercase block">Bergabung Sejak</span>
                        <span class="text-sm font-bold text-slate-500">{{ $anggota->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <form action="{{ route('anggota.update', $anggota) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-y-8">
                        
                        {{-- Nama Lengkap --}}
                        <div class="group">
                            <label for="nama" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $anggota->nama) }}" 
                                class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                            @error('nama')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="group">
                            <label for="email" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Email Instansi / Pribadi</label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                </span>
                                <input type="email" name="email" id="email" value="{{ old('email', $anggota->email) }}" 
                                    class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 pl-14 pr-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                            </div>
                            @error('email')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>

                        {{-- Telepon --}}
                        <div class="group">
                            <label for="telepon" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Nomor Telepon Aktif</label>
                            <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $anggota->telepon) }}" 
                                class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all" required>
                            @error('telepon')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="group">
                            <label for="alamat" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Alamat Domisili</label>
                            <textarea name="alamat" id="alamat" rows="4" 
                                class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all resize-none" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                            @error('alamat')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row items-center gap-4 border-t border-slate-50 pt-8">
                        <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('anggota.show', $anggota) }}" class="w-full sm:w-auto px-10 py-4 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-center">
                            Batalkan
                        </a>
                    </div>
                </form>
            </div>

            {{-- Danger Zone Hint --}}
            <div class="mt-8 p-6 bg-rose-50 rounded-[2rem] border border-rose-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-rose-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/></svg>
                    </span>
                    <p class="text-xs font-bold text-rose-700 uppercase tracking-wider">Perubahan email akan mempengaruhi akses login anggota.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>