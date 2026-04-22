<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Buku</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-8">

                        {{-- Foto Sampul --}}
                        <div class="flex-shrink-0">
                            @if($buku->foto)
                                <img src="{{ asset('storage/'.$buku->foto) }}" alt="{{ $buku->judul }}"
                                     class="w-48 h-64 object-cover rounded-xl shadow-md border border-gray-200">
                            @else
                                <div class="w-48 h-64 bg-gradient-to-br from-indigo-100 to-blue-50 rounded-xl shadow-md border border-gray-200 flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-xs text-indigo-300 mt-2">No Cover</p>
                                </div>
                            @endif
                        </div>

                        {{-- Info Buku --}}
                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $buku->judul }}</h3>
                                    <p class="text-gray-500 mt-1">{{ $buku->penulis }}</p>
                                </div>
                                <span class="px-3 py-1 text-sm rounded-full flex-shrink-0 {{ $buku->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Penerbit</p>
                                    <p class="font-medium text-gray-800 mt-1">{{ $buku->penerbit }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Tahun Terbit</p>
                                    <p class="font-medium text-gray-800 mt-1">{{ $buku->tahun_terbit }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">ISBN</p>
                                    <p class="font-medium text-gray-800 mt-1">{{ $buku->isbn }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Kategori</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-indigo-100 text-indigo-700 text-sm rounded-full">{{ $buku->kategori->nama }}</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Stok Tersedia</p>
                                    <p class="font-bold text-2xl text-gray-800 mt-1">{{ $buku->stok }}</p>
                                </div>
                            </div>

                            {{-- Tombol Pinjam --}}
                            <div class="mt-8 flex flex-wrap gap-3">
                                @if($buku->stok > 0)
                                    @php
                                        $anggotaLogin = \App\Models\Anggota::where('email', auth()->user()->email)->first();
                                        $kuotaPenuh   = $anggotaLogin
                                            ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)
                                                ->whereIn('status', ['menunggu','disetujui','dipinjam'])
                                                ->count() >= 3
                                            : false;
                                        $sudahPinjam  = $anggotaLogin
                                            ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)
                                                ->where('buku_id', $buku->id)
                                                ->whereIn('status', ['menunggu','disetujui','dipinjam'])
                                                ->exists()
                                            : false;
                                    @endphp

                                    @if($sudahPinjam)
                                        <span class="px-5 py-2.5 bg-gray-100 text-gray-400 rounded-lg text-sm cursor-not-allowed">
                                            Sudah dipinjam
                                        </span>
                                    @elseif($kuotaPenuh && !auth()->user()->isAdmin())
                                        <span class="px-5 py-2.5 bg-red-50 text-red-400 rounded-lg text-sm cursor-not-allowed">
                                            Kuota penuh (maks. 3 buku)
                                        </span>
                                    @else
                                        <a href="{{ route('peminjaman.create', ['buku_id' => $buku->id]) }}"
                                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Pinjam Buku Ini
                                        </a>
                                    @endif
                                @else
                                    <span class="px-5 py-2.5 bg-red-50 text-red-400 rounded-lg text-sm cursor-not-allowed">
                                        Stok habis
                                    </span>
                                @endif

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('buku.edit', $buku) }}" class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('buku.destroy', $buku) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                            onclick="return confirm('Hapus buku ini?')">🗑️ Hapus</button>
                                    </form>
                                @endif

                                <a href="{{ route('buku.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                    ← Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
