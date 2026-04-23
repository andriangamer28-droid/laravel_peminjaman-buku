<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <span class="p-2 bg-emerald-100 rounded-xl text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </span>
            Pengaturan Akun
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Sidebar Informasi --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-4">
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 text-center">
                            <div class="relative inline-block mb-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff&size=200" 
                                     alt="Avatar" 
                                     class="w-32 h-32 rounded-[2rem] object-cover ring-4 ring-emerald-50 shadow-lg">
                                <div class="absolute -bottom-2 -right-2 bg-white p-2 rounded-xl shadow-md border border-slate-100">
                                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-black text-slate-800">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-slate-400 font-bold uppercase tracking-widest mt-1">{{ Auth::user()->role ?? 'Administrator' }}</p>
                            
                            <div class="mt-6 pt-6 border-t border-slate-50 flex items-center justify-center gap-4 text-slate-500">
                                <div class="text-center">
                                    <p class="text-[10px] font-black uppercase tracking-tighter">Terdaftar Sejak</p>
                                    <p class="text-xs font-bold text-slate-700">{{ Auth::user()->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-emerald-600 p-6 rounded-[2rem] shadow-lg shadow-emerald-200 text-white relative overflow-hidden group">
                            <svg class="absolute -right-4 -bottom-4 w-24 h-24 text-emerald-500 opacity-20 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 9.503l7.834-4.603a2 2 0 00-1.72-3.4H3.886a2 2 0 00-1.72 3.4zM18 7.166L10 11.87 2 7.166V15a2 2 0 002 2h12a2 2 0 002-2V7.166z" clip-rule="evenodd"/></svg>
                            <p class="relative z-10 text-xs font-black uppercase tracking-widest opacity-80">Email Aktif</p>
                            <p class="relative z-10 font-bold truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Form Section --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Update Profile Info --}}
                    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="text-lg font-black text-slate-800">Informasi Profil</h3>
                            <p class="text-sm text-slate-500 font-medium">Perbarui informasi dasar dan alamat email akun Anda.</p>
                        </div>
                        <div class="p-8">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    {{-- Update Password --}}
                    <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30">
                            <h3 class="text-lg font-black text-slate-800">Keamanan Kata Sandi</h3>
                            <p class="text-sm text-slate-500 font-medium">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak.</p>
                        </div>
                        <div class="p-8">
                            <div class="max-w-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                    {{-- Delete Account --}}
                    <div class="bg-rose-50/50 shadow-xl shadow-rose-100 rounded-[2.5rem] border border-rose-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-rose-100 bg-rose-100/20">
                            <h3 class="text-lg font-black text-rose-800">Zona Bahaya</h3>
                            <p class="text-sm text-rose-600 font-medium">Sekali dihapus, semua data Anda akan hilang secara permanen.</p>
                        </div>
                        <div class="p-8">
                            <div class="max-w-xl">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>