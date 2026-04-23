<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <a href="{{ route('anggota.index') }}" class="p-2 bg-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            Registrasi Anggota
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Alert Information --}}
            <div class="mb-8 bg-indigo-600 rounded-[2rem] p-6 shadow-xl shadow-indigo-100 relative overflow-hidden group">
                <div class="relative z-10 flex items-start gap-4">
                    <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-black text-lg">Otomatisasi Akun</h4>
                        <p class="text-indigo-100 text-sm leading-relaxed mt-1">Sistem akan membuatkan akun login secara otomatis menggunakan email anggota. Password awal diatur ke <span class="px-2 py-0.5 bg-white/20 rounded-md font-mono font-bold text-white uppercase tracking-tighter">password123</span>.</p>
                    </div>
                </div>
                {{-- Decorative circles --}}
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full group-hover:scale-110 transition-transform"></div>
            </div>

            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Formulir Input</p>
                    <h3 class="text-xl font-black text-slate-800">Data Personal Anggota</h3>
                </div>

                <form action="{{ route('anggota.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="grid grid-cols-1 gap-y-8">
                        
                        {{-- Nama Lengkap --}}
                        <div class="group">
                            <label for="nama" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Nama Lengkap Anggota</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                                placeholder="Masukkan nama sesuai kartu identitas..."
                                class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                            @error('nama')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div class="group">
                            <label for="email" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Alamat Email (Login ID)</label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                </span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                    placeholder="nama@email.com"
                                    class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 pl-14 pr-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                            </div>
                            @error('email')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Telepon --}}
                            <div class="group">
                                <label for="telepon" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Nomor Telepon/WA</label>
                                <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" 
                                    placeholder="0812xxxx"
                                    class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300" required>
                                @error('telepon')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                            </div>

                            {{-- Role (Optional addition for UI) --}}
                            <div class="group opacity-50">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Status Keanggotaan</label>
                                <div class="w-full rounded-2xl border-slate-100 bg-slate-200 py-4 px-5 font-black text-slate-500 cursor-not-allowed">
                                    Aktif Secara Otomatis
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="group">
                            <label for="alamat" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 group-focus-within:text-indigo-600 transition-colors">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="4" 
                                placeholder="Masukkan alamat lengkap rumah anggota saat ini..."
                                class="block w-full rounded-2xl border-slate-100 bg-slate-50 py-4 px-5 font-bold text-slate-700 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-300 resize-none" required>{{ old('alamat') }}</textarea>
                            @error('alamat')<p class="text-rose-500 text-xs font-bold mt-2 ml-2 tracking-tight">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row items-center gap-4 border-t border-slate-50 pt-8">
                        <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 active:scale-95">
                            Daftarkan Anggota
                        </button>
                        <a href="{{ route('anggota.index') }}" class="w-full sm:w-auto px-10 py-4 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all text-center">
                            Batalkan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>