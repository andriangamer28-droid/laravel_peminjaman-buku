<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            🔍 Detail Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Peminjaman #{{ $peminjaman->id }}</h3>
                    <span class="px-3 py-1 text-sm rounded-full {{ $peminjaman->badgeStatus() }}">
                        {{ ucfirst($peminjaman->status) }}
                    </span>
                </div>

                <div class="grid md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Anggota</p>
                        <p class="font-medium mt-1">{{ $peminjaman->anggota->nama }}</p>
                        <p class="text-sm text-gray-400">{{ $peminjaman->anggota->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Buku</p>
                        <p class="font-medium mt-1">{{ $peminjaman->buku->judul }}</p>
                        <p class="text-sm text-gray-400">{{ $peminjaman->buku->penulis }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Tanggal Pinjam</p>
                        <p class="font-medium mt-1">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Batas Pengembalian</p>
                        <p class="font-medium mt-1 text-orange-600">{{ $peminjaman->tanggal_pinjam->addDays(7)->format('d F Y') }}</p>
                    </div>
                    @if($peminjaman->tanggal_kembali)
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Tanggal Dikembalikan</p>
                        <p class="font-medium mt-1">{{ $peminjaman->tanggal_kembali->format('d F Y') }}</p>
                    </div>
                    @endif
                    @if($denda > 0)
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Denda</p>
                        <p class="font-bold text-lg text-red-600 mt-1">Rp {{ number_format($denda, 0, ',', '.') }}</p>
                    </div>
                    @endif
                    @if($peminjaman->catatan_admin)
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Catatan Admin</p>
                        <p class="mt-1 text-sm text-red-600 bg-red-50 rounded-lg p-3">{{ $peminjaman->catatan_admin }}</p>
                    </div>
                    @endif
                </div>

                {{-- Token box (tampil jika sudah disetujui) --}}
                @if($peminjaman->token)
                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 mb-6">
                    <p class="text-xs text-indigo-500 uppercase tracking-wide mb-1">Token Peminjaman</p>
                    <p class="font-mono text-2xl font-bold text-indigo-700 tracking-widest">{{ $peminjaman->token }}</p>
                    <p class="text-xs text-indigo-400 mt-1">Tunjukkan token ini kepada petugas saat mengambil buku.</p>
                </div>
                @endif

                {{-- Indikator sisa hari --}}
                @if($peminjaman->status === 'dipinjam')
                    @php $sisa = $peminjaman->sisaHari(); @endphp
                    <div class="mb-6 p-4 rounded-xl {{ $sisa < 0 ? 'bg-red-50 border border-red-200' : ($sisa <= 2 ? 'bg-yellow-50 border border-yellow-200' : 'bg-blue-50 border border-blue-200') }}">
                        @if($sisa < 0)
                            <p class="font-medium text-red-700">⚠️ Terlambat {{ abs($sisa) }} hari!</p>
                        @elseif($sisa == 0)
                            <p class="font-medium text-orange-700">⏰ Jatuh tempo hari ini!</p>
                        @else
                            <p class="text-blue-700">📅 Sisa {{ $sisa }} hari sebelum jatuh tempo.</p>
                        @endif
                    </div>
                @endif

                {{-- Tombol aksi admin --}}
                <div class="flex flex-wrap gap-3">
                    @if(auth()->user()->isAdmin())
                        @if($peminjaman->status === 'menunggu')
                            <form action="{{ route('peminjaman.setujui', $peminjaman) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                    onclick="return confirm('Setujui dan generate token?')">✓ Setujui</button>
                            </form>
                            <button onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">✕ Tolak</button>
                        @endif
                        @if($peminjaman->status === 'disetujui')
                            <form action="{{ route('peminjaman.ambil', $peminjaman) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                                    onclick="return confirm('Tandai buku sudah diambil?')">📦 Buku Diambil</button>
                            </form>
                        @endif
                        @if($peminjaman->status === 'dipinjam')
                            <form action="{{ route('peminjaman.kembalikan', $peminjaman) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                                    onclick="return confirm('Kembalikan buku?')">↩ Kembalikan</button>
                            </form>
                        @endif
                        <form action="{{ route('peminjaman.destroy', $peminjaman) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition"
                                onclick="return confirm('Hapus data ini?')">Hapus</button>
                        </form>
                    @endif

                    {{-- Tombol print (anggota & admin bisa) --}}
                    @if($peminjaman->token)
                        <a href="{{ route('peminjaman.print', $peminjaman) }}" target="_blank"
                            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                            🖨️ Print Bukti
                        </a>
                    @endif

                    <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div id="modal-tolak" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4">
            <h4 class="font-semibold text-gray-800 mb-3">Alasan Penolakan</h4>
            <form action="{{ route('peminjaman.tolak', $peminjaman) }}" method="POST">
                @csrf @method('PATCH')
                <textarea name="catatan_admin" rows="3" placeholder="Tulis alasan penolakan (opsional)..."
                    class="w-full rounded-lg border-gray-300 text-sm focus:border-red-400 focus:ring-red-400"></textarea>
                <div class="flex gap-3 mt-4">
                    <button type="submit" class="flex-1 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Tolak</button>
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="flex-1 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm">Batal</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
