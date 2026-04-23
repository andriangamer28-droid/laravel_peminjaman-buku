<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <span class="p-2 bg-rose-100 rounded-xl text-rose-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </span>
            Kategori Koleksi
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header section with counts --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <p class="text-3xl font-black text-slate-800 tracking-tight">Pengorganisasian Buku</p>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-widest mt-1">Total {{ $kategoris->total() }} Klasifikasi Unik</p>
                </div>
                <a href="{{ route('kategori.create') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-rose-500 text-white rounded-2xl font-black hover:bg-rose-600 transition-all shadow-xl shadow-rose-100 group">
                    <svg class="w-5 h-5 mr-2 group-hover:scale-125 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Buat Kategori Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-8 flex items-center gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl shadow-sm animate-bounce">
                    <span class="p-1.5 bg-emerald-500 rounded-lg text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Table with Card Style --}}
            <div class="bg-white shadow-xl shadow-slate-200/50 rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-50">
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Klasifikasi</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Deskripsi Cakupan</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($kategoris as $kategori)
                            <tr class="group hover:bg-rose-50/30 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-rose-100 group-hover:text-rose-600 transition-all font-black">
                                            {{ substr($kategori->nama, 0, 1) }}
                                        </div>
                                        <span class="text-lg font-black text-slate-700 group-hover:text-rose-600 transition-colors">{{ $kategori->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm text-slate-500 font-medium leading-relaxed max-w-md italic">
                                        {{ $kategori->deskripsi ?: 'Tidak ada deskripsi tambahan untuk kategori ini.' }}
                                    </p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-end items-center gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                        <a href="{{ route('kategori.show', $kategori) }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-black text-xs hover:bg-slate-200 transition-all">
                                            Detail
                                        </a>
                                        <a href="{{ route('kategori.edit', $kategori) }}" class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L12.172 13.514a1.5 1.5 0 01-.632.406l-3.218.804 1.103-3.218a1.5 1.5 0 01.406-.632l8.341-8.341z"/></svg>
                                        </a>
                                        <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition-all shadow-sm" onclick="return confirm('Menghapus kategori akan mempengaruhi data buku yang terkait. Lanjutkan?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-6 bg-slate-50 rounded-full mb-4">
                                            <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        </div>
                                        <p class="font-black text-slate-400 italic">Belum ada kategori koleksi yang didefinisikan.</p>
                                        <a href="{{ route('kategori.create') }}" class="mt-4 text-rose-500 font-bold hover:underline text-sm tracking-tight">+ Tambahkan Kategori Pertama</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination with custom container --}}
                <div class="p-8 bg-slate-50/50 border-t border-slate-50">
                    {{ $kategoris->links() }}
                </div>
            </div>

            {{-- Pro Tip / Info --}}
            <div class="mt-8 flex items-center gap-4 p-6 bg-amber-50 rounded-[2rem] border border-amber-100 shadow-sm">
                <span class="text-2xl">💡</span>
                <p class="text-xs font-bold text-amber-700 leading-relaxed uppercase tracking-wider">
                    Tip Admin: Gunakan nama kategori yang spesifik dan singkat untuk memudahkan pencarian oleh anggota perpustakaan di aplikasi mobile atau web mereka.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>