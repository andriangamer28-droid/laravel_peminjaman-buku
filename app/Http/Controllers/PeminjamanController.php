<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    private function getAnggotaLogin(): ?Anggota
    {
        return Anggota::where('email', auth()->user()->email)->first();
    }

    public function index(Request $request)
    {
        $search    = $request->input('search');
        $status    = $request->input('status', '');
        $dari      = $request->input('dari', '');
        $sampai    = $request->input('sampai', '');

        if (auth()->user()->isAdmin()) {
            $peminjamans = Peminjaman::with(['anggota', 'buku'])
                ->when($search, function ($q) use ($search) {
                    $q->where(function($q) use ($search) {
                        $q->whereHas('anggota', fn($q) => $q->where('nama', 'like', "%{$search}%"))
                          ->orWhereHas('buku', fn($q) => $q->where('judul', 'like', "%{$search}%"))
                          ->orWhere('token', 'like', "%{$search}%");
                    });
                })
                ->when($status, fn($q) => $q->where('status', $status))
                ->when($dari,   fn($q) => $q->whereDate('tanggal_pinjam', '>=', $dari))
                ->when($sampai, fn($q) => $q->whereDate('tanggal_pinjam', '<=', $sampai))
                ->latest()->paginate(10)->withQueryString();
        } else {
            $anggota = $this->getAnggotaLogin();
            if (!$anggota) {
                $peminjamans = Peminjaman::whereNull('id')->paginate(10);
            } else {
                $peminjamans = Peminjaman::with(['anggota', 'buku'])
                    ->where('anggota_id', $anggota->id)
                    ->when($search, function ($q) use ($search) {
                        $q->whereHas('buku', fn($q) => $q->where('judul', 'like', "%{$search}%"))
                          ->orWhere('token', 'like', "%{$search}%");
                    })
                    ->when($status, fn($q) => $q->where('status', $status))
                    ->latest()->paginate(10)->withQueryString();
            }
        }

        return view('peminjaman.index', compact('peminjamans', 'search', 'status', 'dari', 'sampai'));
    }

    public function create(Request $request)
    {
        $anggotas     = Anggota::all();
        $bukus        = Buku::where('stok', '>', 0)->get();
        $anggotaLogin = $this->getAnggotaLogin();
        $selectedBuku = $request->input('buku_id'); // dari halaman detail buku
        return view('peminjaman.create', compact('anggotas', 'bukus', 'anggotaLogin', 'selectedBuku'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            $anggotaLogin = $this->getAnggotaLogin();
            if (!$anggotaLogin) {
                return back()->with('error', 'Data anggota tidak ditemukan. Hubungi admin.');
            }
            $request->merge(['anggota_id' => $anggotaLogin->id]);
        }

        $request->validate([
            'anggota_id'     => 'required|exists:anggotas,id',
            'buku_id'        => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Cek batas maksimal 3 peminjaman aktif per anggota
        $aktif = Peminjaman::where('anggota_id', $request->anggota_id)
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
            ->count();

        if ($aktif >= 3) {
            return back()->with('error', 'Batas peminjaman tercapai. Maksimal 3 buku aktif per anggota. Kembalikan buku terlebih dahulu.');
        }

        if (Buku::findOrFail($request->buku_id)->stok <= 0) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        Peminjaman::create([
            'anggota_id'     => $request->anggota_id,
            'buku_id'        => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status'         => 'menunggu',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(Peminjaman $peminjaman)
    {
        if (!auth()->user()->isAdmin()) {
            $anggota = $this->getAnggotaLogin();
            abort_unless($anggota && $peminjaman->anggota_id === $anggota->id, 403);
        }
        $denda = $peminjaman->hitungDenda();
        return view('peminjaman.show', compact('peminjaman', 'denda'));
    }

    public function setujui(Peminjaman $peminjaman)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        if ($peminjaman->status !== 'menunggu') return back()->with('error', 'Sudah diproses.');
        $buku = $peminjaman->buku;
        if ($buku->stok <= 0) return back()->with('error', 'Stok habis.');
        $buku->decrement('stok');
        $peminjaman->update(['status' => 'disetujui', 'token' => Peminjaman::generateToken()]);
        return back()->with('success', 'Disetujui. Token digenerate.');
    }

    public function tolak(Request $request, Peminjaman $peminjaman)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        if ($peminjaman->status !== 'menunggu') return back()->with('error', 'Sudah diproses.');
        $peminjaman->update(['status' => 'ditolak', 'catatan_admin' => $request->catatan_admin]);
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function ambil(Peminjaman $peminjaman)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        if ($peminjaman->status !== 'disetujui') return back()->with('error', 'Harus disetujui dulu.');
        $peminjaman->update(['status' => 'dipinjam']);
        return back()->with('success', 'Buku ditandai sudah diambil.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        if ($peminjaman->status === 'dikembalikan') return back()->with('error', 'Sudah dikembalikan.');
        $peminjaman->buku->increment('stok');
        $peminjaman->update([
            'tanggal_kembali' => Carbon::now(),
            'status'          => 'dikembalikan',
            'denda'           => $peminjaman->hitungDenda(),
        ]);
        return back()->with('success', 'Buku dikembalikan. Denda: Rp ' . number_format($peminjaman->denda, 0, ',', '.'));
    }

    public function destroy(Peminjaman $peminjaman)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        if ($peminjaman->status === 'dipinjam') $peminjaman->buku->increment('stok');
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data dihapus.');
    }

    public function print(Peminjaman $peminjaman)
    {
        if (!auth()->user()->isAdmin()) {
            $anggota = $this->getAnggotaLogin();
            abort_unless($anggota && $peminjaman->anggota_id === $anggota->id, 403);
        }
        abort_unless($peminjaman->token, 403, 'Belum disetujui.');
        return view('peminjaman.print', compact('peminjaman'));
    }
}
