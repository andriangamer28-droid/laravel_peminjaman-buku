<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman - {{ $peminjaman->token }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; display: flex; justify-content: center; padding: 30px 20px; }
        .card {
            background: white;
            width: 100%;
            max-width: 480px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            padding: 28px 28px 24px;
            text-align: center;
        }
        .header .logo { font-size: 28px; margin-bottom: 4px; }
        .header h1 { font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { font-size: 12px; opacity: 0.8; margin-top: 2px; }
        .badge-status {
            display: inline-block;
            margin-top: 12px;
            padding: 4px 14px;
            background: rgba(255,255,255,0.2);
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .token-box {
            background: #eef2ff;
            border: 2px dashed #818cf8;
            margin: 20px 24px;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }
        .token-box .label { font-size: 11px; color: #6366f1; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .token-box .token { font-size: 26px; font-weight: 800; color: #3730a3; letter-spacing: 3px; margin-top: 6px; font-family: 'Courier New', monospace; }
        .token-box .note { font-size: 11px; color: #818cf8; margin-top: 6px; }
        .info { padding: 0 24px 20px; }
        .row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6; }
        .row:last-child { border-bottom: none; }
        .row .key { font-size: 12px; color: #9ca3af; font-weight: 500; }
        .row .val { font-size: 13px; color: #1f2937; font-weight: 600; text-align: right; max-width: 60%; }
        .footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 16px 24px;
            text-align: center;
        }
        .footer p { font-size: 11px; color: #9ca3af; line-height: 1.6; }
        .print-btn {
            display: block;
            width: calc(100% - 48px);
            margin: 0 24px 20px;
            padding: 12px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
        }
        .print-btn:hover { background: #4338ca; }
        @media print {
            body { background: white; padding: 0; }
            .card { box-shadow: none; border-radius: 0; max-width: 100%; }
            .print-btn { display: none; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">📚</div>
            <h1>Andrian Book</h1>
            <p>Bukti Peminjaman Buku</p>
            <div class="badge-status">{{ strtoupper($peminjaman->status) }}</div>
        </div>

        <div class="token-box">
            <div class="label">Token Peminjaman</div>
            <div class="token">{{ $peminjaman->token }}</div>
            <div class="note">Tunjukkan token ini kepada petugas</div>
        </div>

        <div class="info">
            <div class="row">
                <span class="key">No. Peminjaman</span>
                <span class="val">#{{ $peminjaman->id }}</span>
            </div>
            <div class="row">
                <span class="key">Nama Anggota</span>
                <span class="val">{{ $peminjaman->anggota->nama }}</span>
            </div>
            <div class="row">
                <span class="key">Email</span>
                <span class="val">{{ $peminjaman->anggota->email }}</span>
            </div>
            <div class="row">
                <span class="key">Judul Buku</span>
                <span class="val">{{ $peminjaman->buku->judul }}</span>
            </div>
            <div class="row">
                <span class="key">Penulis</span>
                <span class="val">{{ $peminjaman->buku->penulis }}</span>
            </div>
            <div class="row">
                <span class="key">Tanggal Pinjam</span>
                <span class="val">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</span>
            </div>
            <div class="row">
                <span class="key">Batas Kembali</span>
                <span class="val">{{ $peminjaman->tanggal_pinjam->addDays(7)->format('d F Y') }}</span>
            </div>
            <div class="row">
                <span class="key">Dicetak</span>
                <span class="val">{{ now()->format('d F Y, H:i') }}</span>
            </div>
        </div>

        <button class="print-btn" onclick="window.print()">🖨️ Print / Simpan PDF</button>

        <div class="footer">
            <p>Dokumen ini adalah bukti sah peminjaman buku.<br>
            Harap dijaga dan dibawa saat pengambilan buku.</p>
        </div>
    </div>
</body>
</html>
