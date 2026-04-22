<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            🔄 Data Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded"><p class="text-green-700">{{ session('success') }}</p></div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded"><p class="text-red-700">{{ session('error') }}</p></div>
            @endif

            {{-- Info kuota untuk anggota --}}
            @if(auth()->user()->isAnggota())
                @php
                    $anggotaLogin = \App\Models\Anggota::where('email', auth()->user()->email)->first();
                    $jumlahAktif  = $anggotaLogin ? \App\Models\Peminjaman::where('anggota_id', $anggotaLogin->id)->whereIn('status',['menunggu','disetujui','dipinjam'])->count() : 0;
                    $sisaKuota    = 3 - $jumlahAktif;
                @endphp
                <div class="mb-4 px-5 py-3 rounded-xl border flex items-center gap-3
                    {{ $jumlahAktif >= 3 ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200' }}">
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 3; $i++)
                            <div class="w-6 h-6 rounded-full border-2 {{ $i <= $jumlahAktif ? 'bg-indigo-500 border-indigo-500' : 'bg-white border-gray-300' }}"></div>
                        @endfor
                    </div>
                    <p class="text-sm {{ $jumlahAktif >= 3 ? 'text-red-700' : 'text-blue-700' }}">
                        @if($jumlahAktif >= 3)
                            <span class="font-semibold">Kuota penuh!</span> Kembalikan buku dulu sebelum pinjam lagi.
                        @else
                            Kamu meminjam <span class="font-semibold">{{ $jumlahAktif }}/3</span> buku. Sisa kuota: <span class="font-semibold">{{ $sisaKuota }}</span> buku.
                        @endif
                    </p>
                </div>
            @endif

            {{-- Panel Menunggu Validasi (admin only) --}}
            @if(auth()->user()->isAdmin())
            @php $menunggu = $peminjamans->getCollection()->where('status','menunggu'); @endphp
            @if($menunggu->count() > 0)
            <div class="bg-yellow-50 border border-yellow-200 shadow-sm sm:rounded-2xl overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-yellow-200 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse"></span>
                    <h3 class="font-semibold text-yellow-800">Menunggu Validasi ({{ $menunggu->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-yellow-100">
                        <thead class="bg-yellow-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-700 uppercase">Anggota</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-700 uppercase">Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-700 uppercase">Tgl Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-yellow-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-yellow-100 bg-white">
                            @foreach($menunggu as $p)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $p->anggota->nama }}</td>
                                <td class="px-4 py-3">{{ $p->buku->judul }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('peminjaman.setujui', $p) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button onclick="return confirm('Setujui?')" class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700">✓ Setujui</button>
                                        </form>
                                        <button onclick="document.getElementById('modal-tolak-{{ $p->id }}').classList.remove('hidden')"
                                            class="px-3 py-1.5 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700">✕ Tolak</button>
                                        <a href="{{ route('peminjaman.show', $p) }}" class="text-indigo-600 text-xs hover:underline">Detail</a>
                                    </div>
                                    <div id="modal-tolak-{{ $p->id }}" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                                        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
                                            <h4 class="font-semibold mb-3">Alasan Penolakan</h4>
                                            <form action="{{ route('peminjaman.tolak', $p) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <textarea name="catatan_admin" rows="3" placeholder="Alasan (opsional)..." class="w-full rounded-lg border-gray-300 text-sm"></textarea>
                                                <div class="flex gap-3 mt-4">
                                                    <button type="submit" class="flex-1 py-2 bg-red-600 text-white rounded-lg text-sm">Tolak</button>
                                                    <button type="button" onclick="document.getElementById('modal-tolak-{{ $p->id }}').classList.add('hidden')" class="flex-1 py-2 border border-gray-300 rounded-lg text-sm">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif

            {{-- Tabel Utama --}}
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h3 class="font-semibold text-gray-800">
                            {{ auth()->user()->isAdmin() ? 'Semua Peminjaman' : 'Peminjaman Saya' }}
                        </h3>
                        @if(!(isset($jumlahAktif) && $jumlahAktif >= 3))
                        <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                            + Ajukan Peminjaman
                        </a>
                        @else
                        <span class="px-4 py-2 bg-gray-100 text-gray-400 text-sm rounded-lg cursor-not-allowed">Kuota Penuh</span>
                        @endif
                    </div>

                    {{-- Search & Filter --}}
                    <form method="GET" action="{{ route('peminjaman.index') }}" class="mt-4 space-y-3">
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    placeholder="{{ auth()->user()->isAdmin() ? 'Cari anggota, buku, token...' : 'Cari buku, token...' }}"
                                    class="w-full pl-9 pr-4 py-2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">Cari</button>
                            @if(($search??'')||($status??'')||($dari??'')||($sampai??''))
                                <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-50 text-sm">Reset</a>
                            @endif
                        </div>

                        {{-- Filter Status & Tanggal (admin) --}}
                        @if(auth()->user()->isAdmin())
                        <div class="flex flex-wrap gap-3 items-center">
                            <div class="flex items-center gap-2">
                                <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Status:</label>
                                <select name="status" onchange="this.form.submit()"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                                    <option value="">Semua</option>
                                    <option value="menunggu"      {{ ($status??'')=='menunggu'      ?'selected':'' }}>Menunggu</option>
                                    <option value="disetujui"    {{ ($status??'')=='disetujui'    ?'selected':'' }}>Disetujui</option>
                                    <option value="dipinjam"     {{ ($status??'')=='dipinjam'     ?'selected':'' }}>Dipinjam</option>
                                    <option value="dikembalikan" {{ ($status??'')=='dikembalikan' ?'selected':'' }}>Dikembalikan</option>
                                    <option value="ditolak"      {{ ($status??'')=='ditolak'      ?'selected':'' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Dari:</label>
                                <input type="date" name="dari" value="{{ $dari??''  }}"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-xs font-medium text-gray-500 whitespace-nowrap">Sampai:</label>
                                <input type="date" name="sampai" value="{{ $sampai??''  }}"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                            </div>
                        </div>
                        @else
                        {{-- Filter status untuk anggota --}}
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-medium text-gray-500">Status:</label>
                            <select name="status" onchange="this.form.submit()"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-1.5">
                                <option value="">Semua</option>
                                <option value="menunggu"      {{ ($status??'')=='menunggu'      ?'selected':'' }}>Menunggu</option>
                                <option value="disetujui"    {{ ($status??'')=='disetujui'    ?'selected':'' }}>Disetujui</option>
                                <option value="dipinjam"     {{ ($status??'')=='dipinjam'     ?'selected':'' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ ($status??'')=='dikembalikan' ?'selected':'' }}>Dikembalikan</option>
                                <option value="ditolak"      {{ ($status??'')=='ditolak'      ?'selected':'' }}>Ditolak</option>
                            </select>
                        </div>
                        @endif
                    </form>
                    @if(($search??'')||($status??'')||($dari??'')||($sampai??''))
                        <p class="text-sm text-gray-500 mt-2">{{ $peminjamans->total() }} data ditemukan</p>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Anggota</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Token</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($peminjamans as $p)
                            @php $denda = $p->hitungDenda(); @endphp
                            <tr class="hover:bg-gray-50 {{ $denda > 0 && $p->status === 'dipinjam' ? 'bg-red-50' : '' }}">
                                <td class="px-4 py-4 font-medium">{{ $p->anggota->nama }}</td>
                                <td class="px-4 py-4">{{ $p->buku->judul }}</td>
                                <td class="px-4 py-4">{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $p->badgeStatus() }}">{{ ucfirst($p->status) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    @if($p->token)
                                        <span class="font-mono text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded">{{ $p->token }}</span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @if($p->status === 'dikembalikan' && $p->denda > 0)
                                        <span class="text-sm font-semibold text-red-600">Rp {{ number_format($p->denda, 0, ',', '.') }}</span>
                                    @elseif($denda > 0)
                                        <span class="text-sm font-semibold text-red-500">
                                            Rp {{ number_format($denda, 0, ',', '.') }}
                                            <span class="text-xs font-normal text-red-400">(berjalan)</span>
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('peminjaman.show', $p) }}" class="text-indigo-600 hover:underline text-xs">Detail</a>
                                        @if(auth()->user()->isAdmin())
                                            @if($p->status === 'disetujui')
                                                <form action="{{ route('peminjaman.ambil', $p) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="text-blue-600 hover:underline text-xs" onclick="return confirm('Tandai diambil?')">Diambil</button>
                                                </form>
                                            @endif
                                            @if($p->status === 'dipinjam')
                                                <form action="{{ route('peminjaman.kembalikan', $p) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="text-green-600 hover:underline text-xs" onclick="return confirm('Kembalikan?')">Kembalikan</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('peminjaman.destroy', $p) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline text-xs" onclick="return confirm('Hapus?')">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                {{ ($search ?? '') ? 'Tidak ada data yang cocok.' : 'Belum ada data peminjaman.' }}
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $peminjamans->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
