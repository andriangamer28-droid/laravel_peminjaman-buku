<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1f2937; background: white; padding: 24px; }

        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 16px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: 700; color: #4f46e5; }
        .header p { color: #6b7280; margin-top: 4px; font-size: 12px; }

        .meta { display: flex; justify-content: space-between; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .meta div { }
        .meta .label { font-size: 10px; color: #9ca3af; text-transform: uppercase; }
        .meta .value { font-size: 13px; font-weight: 600; color: #1f2937; margin-top: 2px; }

        .stats { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-bottom: 20px; }
        .stat-box { text-align: center; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; }
        .stat-box .num { font-size: 20px; font-weight: 700; }
        .stat-box .lbl { font-size: 10px; color: #9ca3af; margin-top: 2px; }
        .stat-box.total  { border-color: #c7d2fe; background: #eef2ff; } .stat-box.total .num { color: #4f46e5; }
        .stat-box.hijau  { border-color: #bbf7d0; background: #f0fdf4; } .stat-box.hijau .num { color: #16a34a; }
        .stat-box.kuning { border-color: #fde68a; background: #fffbeb; } .stat-box.kuning .num { color: #d97706; }
        .stat-box.merah  { border-color: #fecaca; background: #fef2f2; } .stat-box.merah .num { color: #dc2626; }
        .stat-box.denda  { border-color: #ddd6fe; background: #f5f3ff; } .stat-box.denda .num { font-size: 14px; color: #7c3aed; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead th { background: #4f46e5; color: white; padding: 8px 10px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:hover { background: #eef2ff; }
        td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .sub { font-size: 10px; color: #9ca3af; margin-top: 1px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 600; }
        .badge-menunggu    { background: #fef3c7; color: #92400e; }
        .badge-disetujui   { background: #dbeafe; color: #1e40af; }
        .badge-dipinjam    { background: #ffedd5; color: #9a3412; }
        .badge-dikembalikan{ background: #dcfce7; color: #166534; }
        .badge-ditolak     { background: #fee2e2; color: #991b1b; }
        tfoot td { background: #f9fafb; font-weight: 700; padding: 8px 10px; border-top: 2px solid #e5e7eb; }
        .denda-val { color: #dc2626; font-weight: 700; }

        .footer { text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 12px; margin-top: 20px; }
        .print-btn { display: block; text-align: center; margin: 0 auto 20px; padding: 10px 28px; background: #4f46e5; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; }

        @media print {
            .print-btn { display: none; }
            body { padding: 16px; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>📚 Laporan Peminjaman Buku</h1>
        <p>{{ config('app.name', 'Bookify') }} &mdash; Dicetak oleh {{ auth()->user()->name }} pada {{ now()->format('d F Y, H:i') }}</p>
    </div>

    <div class="meta">
        <div>
            <div class="label">Periode</div>
            <div class="value">{{ \Carbon\Carbon::parse($dari)->format('d F Y') }} &mdash; {{ \Carbon\Carbon::parse($sampai)->format('d F Y') }}</div>
        </div>
        <div>
            <div class="label">Filter Status</div>
            <div class="value">{{ $status ? ucfirst($status) : 'Semua Status' }}</div>
        </div>
        <div>
            <div class="label">Total Data</div>
            <div class="value">{{ $totalPeminjaman }} peminjaman</div>
        </div>
    </div>

    <div class="stats">
        <div class="stat-box total">
            <div class="num">{{ $totalPeminjaman }}</div>
            <div class="lbl">Total</div>
        </div>
        <div class="stat-box kuning">
            <div class="num">{{ $peminjamans->whereIn('status',['menunggu','disetujui'])->count() }}</div>
            <div class="lbl">Proses</div>
        </div>
        <div class="stat-box kuning">
            <div class="num">{{ $peminjamans->where('status','dipinjam')->count() }}</div>
            <div class="lbl">Dipinjam</div>
        </div>
        <div class="stat-box hijau">
            <div class="num">{{ $peminjamans->where('status','dikembalikan')->count() }}</div>
            <div class="lbl">Dikembalikan</div>
        </div>
        <div class="stat-box denda">
            <div class="num">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
            <div class="lbl">Total Denda</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Token</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $p->anggota->nama }}
                    <div class="sub">{{ $p->anggota->email }}</div>
                </td>
                <td>
                    {{ $p->buku->judul }}
                    <div class="sub">{{ $p->buku->penulis }}</div>
                </td>
                <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                <td style="font-family:monospace; font-size:10px">{{ $p->token ?? '-' }}</td>
                <td class="{{ $p->denda > 0 ? 'denda-val' : '' }}">
                    {{ $p->denda > 0 ? 'Rp '.number_format($p->denda, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center; padding:20px; color:#9ca3af">Tidak ada data pada periode ini.</td></tr>
            @endforelse
        </tbody>
        @if($peminjamans->count() > 0)
        <tfoot>
            <tr>
                <td colspan="7" style="text-align:right">Total Denda Keseluruhan:</td>
                <td class="denda-val">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <button class="print-btn" onclick="window.print()">🖨️ Print / Simpan PDF</button>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem {{ config('app.name', 'Bookify') }}.</p>
        <p>{{ now()->format('d F Y, H:i:s') }}</p>
    </div>

</body>
</html>
