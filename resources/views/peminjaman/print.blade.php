<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Peminjaman - {{ $peminjaman->token }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            display: flex; 
            justify-content: center; 
            padding: 40px 20px; 
            color: #1e293b;
        }
        
        .card {
            background: white;
            width: 100%;
            max-width: 450px;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
        }

        /* Dekorasi Lingkaran Kertas (Efek Tiket) */
        .card::before, .card::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            background: #f8fafc;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }
        .card::before { left: -10px; }
        .card::after { right: -10px; }

        .header {
            background: #4f46e5; /* Warna solid agar lebih bersih saat print */
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header .logo { 
            font-size: 32px; 
            margin-bottom: 8px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .header h1 { 
            font-size: 24px; 
            font-weight: 800; 
            letter-spacing: -0.5px; 
            margin-bottom: 4px;
        }

        .header p { 
            font-size: 13px; 
            opacity: 0.9; 
            font-weight: 500;
        }

        .badge-status {
            display: inline-block;
            margin-top: 16px;
            padding: 6px 16px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 12px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .token-box {
            background: #f1f5f9;
            margin: 30px 30px;
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .token-box .label { 
            font-size: 10px; 
            color: #64748b; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            font-weight: 800; 
            margin-bottom: 10px;
        }

        .token-box .token { 
            font-size: 32px; 
            font-weight: 800; 
            color: #1e1b4b; 
            letter-spacing: 4px; 
            font-family: 'JetBrains Mono', monospace; 
        }

        .token-box .note { 
            font-size: 11px; 
            color: #6366f1; 
            margin-top: 12px;
            font-weight: 600;
        }

        .info { 
            padding: 0 35px 30px; 
        }

        .row { 
            display: flex; 
            justify-content: space-between; 
            padding: 12px 0; 
            border-bottom: 1px dashed #e2e8f0; 
        }

        .row:last-child { border-bottom: none; }

        .row .key { 
            font-size: 12px; 
            color: #64748b; 
            font-weight: 600; 
        }

        .row .val { 
            font-size: 13px; 
            color: #0f172a; 
            font-weight: 700; 
            text-align: right; 
            max-width: 65%; 
        }

        .footer {
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            padding: 24px 35px;
            text-align: center;
        }

        .footer p { 
            font-size: 11px; 
            color: #94a3b8; 
            line-height: 1.6; 
            font-weight: 500;
        }

        .print-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: calc(100% - 70px);
            margin: 0 35px 25px;
            padding: 14px;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .print-btn:hover { background: #0f172a; transform: translateY(-2px); }

        @media print {
            body { background: white; padding: 0; }
            .card { box-shadow: none; border-radius: 0; max-width: 100%; border: none; }
            .print-btn { display: none; }
            .card::before, .card::after { display: none; }
            .header { background: #4f46e5 !important; -webkit-print-color-adjust: exact; }
            .token-box { border: 2px solid #e2e8f0; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">📖</div>
            <h1>Andrian Book</h1>
            <p>E-Receipt Peminjaman</p>
            <div class="badge-status">{{ $peminjaman->status }}</div>
        </div>

        <div class="token-box">
            <div class="label">Token Peminjaman</div>
            <div class="token">{{ $peminjaman->token }}</div>
            <p class="note">Wajib ditunjukkan kepada petugas perpustakaan</p>
        </div>

        <div class="info">
            <div class="row">
                <span class="key">ID Transaksi</span>
                <span class="val">#TRX-{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="row">
                <span class="key">Peminjam</span>
                <span class="val">{{ $peminjaman->anggota->nama }}</span>
            </div>
            <div class="row">
                <span class="key">Buku</span>
                <span class="val">{{ $peminjaman->buku->judul }}</span>
            </div>
            <div class="row">
                <span class="key">Tgl Pinjam</span>
                <span class="val">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</span>
            </div>
            <div class="row">
                <span class="key">Jatuh Tempo</span>
                <span class="val" style="color: #e11d48;">{{ $peminjaman->tanggal_pinjam->addDays(7)->format('d/m/Y') }}</span>
            </div>
            <div class="row" style="border: none; margin-top: 10px; opacity: 0.5;">
                <span class="key">Dicetak pada</span>
                <span class="val">{{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <button class="print-btn" onclick="window.print()">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Dokumen
        </button>

        <div class="footer">
            <p>Simpan bukti ini dalam bentuk digital atau cetak.<br>
            Keterlambatan pengembalian akan dikenakan denda sesuai ketentuan.</p>
        </div>
    </div>
</body>
</html>