<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            📊 Laporan Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded"><p class="text-green-700">{{ session('success') }}</p></div>
            @endif

            {{-- Filter --}}
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Filter Laporan</h3>
                <form method="GET" action="{{ route('laporan.index') }}">
                    <div class="flex flex-wrap gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="dari" value="{{ $dari }}"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="sampai" value="{{ $sampai }}"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Semua Status</option>
                                <option value="menunggu"     {{ $status === 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui"   {{ $status === 'disetujui'   ? 'selected' : '' }}>Disetujui</option>
                                <option value="dipinjam"    {{ $status === 'dipinjam'    ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan"{{ $status === 'dikembalikan'? 'selected' : '' }}>Dikembalikan</option>
                                <option value="ditolak"     {{ $status === 'ditolak'     ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                                Tampilkan
                            </button>
                            <a href="{{ route('laporan.print', ['dari' => $dari, 'sampai' => $sampai, 'status' => $status]) }}"
                                target="_blank"
                                class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 text-sm inline-flex items-center gap-2">
                                🖨️ Print PDF
                            </a>
                        </div>
                    </div>
                </form>
                <p class="text-xs text-gray-400 mt-3">Menampilkan data dari <span class="font-medium">{{ \Carbon\Carbon::parse($dari)->format('d F Y') }}</span> sampai <span class="font-medium">{{ \Carbon\Carbon::parse($sampai)->format('d F Y') }}</span></p>
            </div>

            {{-- Statistik Ringkasan --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPeminjaman }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total</p>
                </div>
                <div class="bg-yellow-50 border border-yellow-100 shadow-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $totalMenunggu }}</p>
                    <p class="text-xs text-yellow-500 mt-1">Menunggu</p>
                </div>
                <div class="bg-orange-50 border border-orange-100 shadow-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-bold text-orange-600">{{ $totalDipinjam }}</p>
                    <p class="text-xs text-orange-500 mt-1">Dipinjam</p>
                </div>
                <div class="bg-green-50 border border-green-100 shadow-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $totalDikembalikan }}</p>
                    <p class="text-xs text-green-500 mt-1">Dikembalikan</p>
                </div>
                <div class="bg-red-50 border border-red-100 shadow-sm rounded-2xl p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $totalDitolak }}</p>
                    <p class="text-xs text-red-500 mt-1">Ditolak</p>
                </div>
                <div class="bg-indigo-50 border border-indigo-100 shadow-sm rounded-2xl p-4 text-center">
                    <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                    <p class="text-xs text-indigo-500 mt-1">Total Denda</p>
                </div>
            </div>

            {{-- Top Buku & Anggota --}}
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Top Buku --}}
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <h4 class="font-semibold text-gray-800 mb-4">📚 Buku Terpopuler</h4>
                    @forelse($topBuku as $item)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold flex items-center justify-center">{{ $loop->iteration }}</span>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item['buku']->judul }}</p>
                                <p class="text-xs text-gray-400">{{ $item['buku']->penulis }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-indigo-600">{{ $item['jumlah'] }}x</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">Tidak ada data.</p>
                    @endforelse
                </div>

                {{-- Top Anggota --}}
                <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                    <h4 class="font-semibold text-gray-800 mb-4">👥 Anggota Teraktif</h4>
                    @forelse($topAnggota as $item)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold flex items-center justify-center">{{ $loop->iteration }}</span>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item['anggota']->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $item['anggota']->email }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-green-600">{{ $item['jumlah'] }}x</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-4">Tidak ada data.</p>
                    @endforelse
                </div>
            </div>

            {{-- Tabel Detail --}}
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h4 class="font-semibold text-gray-800">Detail Peminjaman ({{ $peminjamans->count() }} data)</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($peminjamans as $i => $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium">{{ $p->anggota->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->anggota->email }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium">{{ $p->buku->judul }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->buku->penulis }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $p->badgeStatus() }}">{{ ucfirst($p->status) }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm {{ $p->denda > 0 ? 'font-semibold text-red-600' : 'text-gray-400' }}">
                                    {{ $p->denda > 0 ? 'Rp '.number_format($p->denda, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada data pada periode ini.</td></tr>
                            @endforelse
                        </tbody>
                        @if($peminjamans->count() > 0)
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-sm font-semibold text-gray-700 text-right">Total Denda:</td>
                                <td class="px-4 py-3 text-sm font-bold text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
