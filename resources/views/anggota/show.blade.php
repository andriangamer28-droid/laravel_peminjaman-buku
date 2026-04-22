<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            👁️ Detail Anggota
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6">

                    @php
                        $userAnggota = \App\Models\User::where('email', $anggota->email)->first();
                    @endphp

                    {{-- Header: foto + nama --}}
                    <div class="flex items-center gap-5 mb-8">
                        <img src="{{ $userAnggota ? $userAnggota->fotoUrl() : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=6366f1&color=fff&size=128' }}"
                            alt="{{ $anggota->nama }}"
                            class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200 shadow-sm">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $anggota->nama }}</h3>
                            <span class="inline-block mt-1 px-3 py-0.5 bg-green-100 text-green-700 text-sm rounded-full">Anggota Aktif</span>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Email</p>
                            <p class="font-medium mt-1">{{ $anggota->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Telepon</p>
                            <p class="font-medium mt-1">{{ $anggota->telepon }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Alamat</p>
                            <p class="font-medium mt-1">{{ $anggota->alamat }}</p>
                        </div>
                    </div>

                    <h4 class="font-semibold text-gray-800 mb-4">Riwayat Peminjaman</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($anggota->peminjamans as $pinjam)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $pinjam->buku->judul }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $pinjam->tanggal_kembali ? $pinjam->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $pinjam->badgeStatus() }}">{{ ucfirst($pinjam->status) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $pinjam->denda > 0 ? 'Rp '.number_format($pinjam->denda, 0, ',', '.') : '-' }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="px-4 py-4 text-center text-gray-400">Belum ada riwayat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex gap-3">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('anggota.edit', $anggota) }}" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">Edit</a>
                            <form action="{{ route('anggota.destroy', $anggota) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                                    onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                            </form>
                        @endif
                        <a href="{{ route('anggota.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">&larr; Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
