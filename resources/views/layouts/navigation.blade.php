<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> {{-- Tinggi dinaikkan menjadi h-20 --}}
            <div class="flex items-center">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-black bg-gradient-to-tr from-indigo-600 via-blue-500 to-indigo-400 bg-clip-text text-transparent tracking-tighter transition-all hover:opacity-80">
                        📚 {{ config('app.name', 'Bookify') }}
                    </a>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-4 py-2 rounded-xl transition-all font-bold">
                        Dashboard
                    </x-nav-link>
                    
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')" class="px-4 py-2 rounded-xl transition-all font-bold">
                            Kategori
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')" class="px-4 py-2 rounded-xl transition-all font-bold">
                        Buku
                    </x-nav-link>

                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('anggota.index')" :active="request()->routeIs('anggota.*')" class="px-4 py-2 rounded-xl transition-all font-bold">
                            Anggota
                        </x-nav-link>
                        <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')" class="px-4 py-2 rounded-xl transition-all font-bold">
                            Laporan
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')" class="px-4 py-2 rounded-xl transition-all font-bold">
                        Peminjaman
                    </x-nav-link>
                </div>
            </div>

            {{-- Settings Dropdown (Desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="64"> {{-- Lebar dropdown ditambah --}}
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-3 py-2 rounded-2xl bg-slate-50 text-sm font-bold text-slate-700 hover:bg-slate-100 border border-slate-100 transition-all focus:outline-none">
                            <img src="{{ auth()->user()->fotoUrl() }}" alt="User" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-100">
                            <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- User Header Info --}}
                        <div class="p-5 border-b border-slate-50">
                            <div class="flex items-center gap-4">
                                <img src="{{ auth()->user()->fotoUrl() }}" class="w-12 h-12 rounded-2xl object-cover border-2 border-slate-100">
                                <div class="overflow-hidden">
                                    <p class="text-sm font-black text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                    <span class="inline-flex mt-1 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider rounded-lg {{ auth()->user()->isAdmin() ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600' }}">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 space-y-1">
                            <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-bold flex items-center gap-2 text-slate-600">
                                👤 Profil Saya
                            </x-dropdown-link>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-xl font-bold flex items-center gap-2 text-rose-500 hover:bg-rose-50">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger Mobile --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2.5 rounded-2xl text-slate-500 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 transition-all focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 20h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Menu Mobile --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-50 animate-fade-in-down">
        <div class="p-4 space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-2xl font-bold">Dashboard</x-responsive-nav-link>
            
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')" class="rounded-2xl font-bold">Kategori</x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('buku.index')" :active="request()->routeIs('buku.*')" class="rounded-2xl font-bold">Buku</x-responsive-nav-link>

            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('anggota.index')" :active="request()->routeIs('anggota.*')" class="rounded-2xl font-bold">Anggota</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.*')" class="rounded-2xl font-bold">Laporan</x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman.*')" class="rounded-2xl font-bold">Peminjaman</x-responsive-nav-link>
        </div>

        {{-- Mobile User Info --}}
        <div class="p-6 border-t border-slate-50 bg-slate-50/50 rounded-b-[2rem]">
            <div class="flex items-center gap-4">
                <img src="{{ auth()->user()->fotoUrl() }}" class="w-12 h-12 rounded-2xl object-cover ring-4 ring-white">
                <div>
                    <p class="font-black text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs font-medium text-slate-400">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <a href="{{ route('profile.edit') }}" class="flex justify-center items-center py-3 bg-white text-slate-700 font-bold rounded-2xl border border-slate-100 shadow-sm">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-rose-500 text-white font-bold rounded-2xl shadow-lg shadow-rose-100">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</nav>