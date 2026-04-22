<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'anggota_id', 'buku_id', 'tanggal_pinjam',
        'tanggal_kembali', 'status', 'denda', 'token', 'catatan_admin'
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Generate token format AMD-2026-DDMMYYYY-XXXX
     */
    public static function generateToken(): string
    {
        $tanggal = Carbon::now()->format('dmY');
        $random  = strtoupper(\Illuminate\Support\Str::random(4));
        return "AMD-2026-{$tanggal}-{$random}";
    }

    /**
     * Hitung denda: Rp 2.000/hari keterlambatan (batas 7 hari)
     */
    public function hitungDenda(): int
    {
        if ($this->status === 'dikembalikan') {
            return (int) $this->denda;
        }

        if ($this->status !== 'dipinjam') {
            return 0;
        }

        $batasWaktu = Carbon::parse($this->tanggal_pinjam)->addDays(7);
        $hariIni    = Carbon::now()->startOfDay();

        if ($hariIni->greaterThan($batasWaktu)) {
            return $batasWaktu->diffInDays($hariIni) * 2000;
        }

        return 0;
    }

    public function sisaHari(): int
    {
        $batasWaktu = Carbon::parse($this->tanggal_pinjam)->addDays(7);
        return (int) Carbon::now()->startOfDay()->diffInDays($batasWaktu, false);
    }

    public function badgeStatus(): string
    {
        return match($this->status) {
            'menunggu'    => 'bg-yellow-100 text-yellow-800',
            'disetujui'   => 'bg-blue-100 text-blue-800',
            'dipinjam'    => 'bg-orange-100 text-orange-800',
            'dikembalikan'=> 'bg-green-100 text-green-800',
            'ditolak'     => 'bg-red-100 text-red-800',
            default       => 'bg-gray-100 text-gray-800',
        };
    }
}
