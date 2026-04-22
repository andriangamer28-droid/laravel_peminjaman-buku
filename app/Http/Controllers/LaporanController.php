<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $dari   = $request->input('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', Carbon::now()->format('Y-m-d'));
        $status = $request->input('status', '');

        $query = Peminjaman::with(['anggota', 'buku'])
            ->whereBetween('tanggal_pinjam', [$dari, $sampai]);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans = $query->latest()->get();

        // Statistik ringkasan
        $totalPeminjaman  = $peminjamans->count();
        $totalDikembalikan = $peminjamans->where('status', 'dikembalikan')->count();
        $totalDipinjam    = $peminjamans->where('status', 'dipinjam')->count();
        $totalMenunggu    = $peminjamans->where('status', 'menunggu')->count();
        $totalDitolak     = $peminjamans->where('status', 'ditolak')->count();
        $totalDenda       = $peminjamans->sum('denda');

        // Top 5 buku terpinjam
        $topBuku = Peminjaman::with('buku')
            ->whereBetween('tanggal_pinjam', [$dari, $sampai])
            ->get()
            ->groupBy('buku_id')
            ->map(fn($g) => ['buku' => $g->first()->buku, 'jumlah' => $g->count()])
            ->sortByDesc('jumlah')
            ->take(5);

        // Top 5 anggota teraktif
        $topAnggota = Peminjaman::with('anggota')
            ->whereBetween('tanggal_pinjam', [$dari, $sampai])
            ->get()
            ->groupBy('anggota_id')
            ->map(fn($g) => ['anggota' => $g->first()->anggota, 'jumlah' => $g->count()])
            ->sortByDesc('jumlah')
            ->take(5);

        return view('laporan.index', compact(
            'peminjamans', 'dari', 'sampai', 'status',
            'totalPeminjaman', 'totalDikembalikan', 'totalDipinjam',
            'totalMenunggu', 'totalDitolak', 'totalDenda',
            'topBuku', 'topAnggota'
        ));
    }

    public function print(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $dari   = $request->input('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', Carbon::now()->format('Y-m-d'));
        $status = $request->input('status', '');

        $query = Peminjaman::with(['anggota', 'buku'])
            ->whereBetween('tanggal_pinjam', [$dari, $sampai]);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjamans      = $query->latest()->get();
        $totalDenda       = $peminjamans->sum('denda');
        $totalPeminjaman  = $peminjamans->count();

        return view('laporan.print', compact('peminjamans', 'dari', 'sampai', 'status', 'totalDenda', 'totalPeminjaman'));
    }
}
