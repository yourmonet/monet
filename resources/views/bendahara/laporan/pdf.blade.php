<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mutasi Transaksi {{ $namaBulan }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 110px 40px 60px 40px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 9pt;
            color: #191c1e;
            background: #fff;
        }
        
        /* Fixed Header */
        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            height: 70px;
            border-bottom: 1px solid #e1e2e4;
            display: table;
            width: 100%;
        }
        
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }
        
        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 50%;
        }

        .logo-text {
            font-size: 16pt;
            font-weight: bold;
            color: #0c56d0;
            letter-spacing: -0.5px;
        }
        
        .header-title {
            font-size: 14pt;
            font-weight: normal;
            color: #191c1e;
        }
        
        .header-subtitle {
            font-size: 10pt;
            color: #191c1e;
            margin-top: 2px;
        }

        /* Fixed Footer */
        footer {
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
            height: 30px;
            border-top: 1px solid #e1e2e4;
            display: table;
            width: 100%;
            font-size: 7.5pt;
            color: #737685;
            padding-top: 8px;
        }

        .footer-left {
            display: table-cell;
            vertical-align: top;
            width: 80%;
        }

        .footer-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 20%;
        }

        .page-number:after {
            content: counter(page) " / " counter(pages);
        }

        /* Account Info Section */
        .account-info {
            margin-top: 5px;
            margin-bottom: 25px;
            display: table;
            width: 100%;
        }
        
        .account-icon {
            display: table-cell;
            width: 60px;
            vertical-align: middle;
        }
        
        .account-icon-box {
            width: 45px;
            height: 45px;
            background: #dae2ff;
            border-radius: 50%;
            text-align: center;
            line-height: 45px;
            font-size: 18pt;
            color: #003d9b;
        }
        
        .account-details {
            display: table-cell;
            vertical-align: middle;
        }
        
        .account-name {
            font-size: 13pt;
            font-weight: normal;
            color: #191c1e;
        }
        
        .account-number {
            font-size: 9pt;
            color: #434654;
            margin-top: 3px;
        }

        /* Table Styles */
        table.mutasi-table {
            width: 100%;
            border-collapse: collapse;
        }

        tr.date-group {
            background-color: #006aff; /* Biru terang mirip referensi */
        }

        tr.date-group td {
            color: #ffffff;
            font-size: 8.5pt;
            padding: 6px 12px;
        }

        tr.tx-row td {
            padding: 12px;
            border-bottom: 1px solid #c3c6d6;
            vertical-align: top;
        }

        .icon-col {
            width: 50px;
            text-align: center;
        }

        .idr-box {
            display: inline-block;
            border: 1px solid #c3c6d6;
            border-radius: 4px;
            padding: 3px;
            text-align: center;
            background: #f8f9fb;
            width: 34px;
        }
        
        .idr-text {
            font-size: 6pt;
            color: #434654;
            border-bottom: 1px solid #e1e2e4;
            padding-bottom: 2px;
            margin-bottom: 2px;
            font-weight: 600;
        }
        
        .idr-arrow {
            display: block;
            font-size: 7.5pt;
            line-height: 1;
            font-weight: 700;
        }

        .desc-col {
            width: auto;
        }

        .tx-desc {
            font-size: 9.5pt;
            font-weight: 700;
            text-transform: uppercase;
            color: #191c1e;
        }

        .tx-sub {
            font-size: 8pt;
            color: #434654;
            margin-top: 3px;
        }

        .amount-col {
            width: 120px;
            text-align: right;
            font-size: 9.5pt;
            font-weight: normal;
        }

        .text-in { color: #1a6b3a; }
        .text-out { color: #ba1a1a; }
        
        .saldo-summary {
            margin-top: 30px;
            border-top: 2px solid #e1e2e4;
            padding-top: 15px;
            display: table;
            width: 100%;
        }
        
        .saldo-col {
            display: table-cell;
            width: 33.33%;
            text-align: center;
        }
        
        .saldo-label {
            font-size: 8pt;
            color: #737685;
            text-transform: uppercase;
        }
        
        .saldo-val {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 4px;
        }
    </style>
</head>
<body>

@php
    // Logika penggabungan data dalam blade
    $allTransactions = collect();
    
    foreach($kasMasuk as $km) {
        $allTransactions->push((object)[
            'tanggal' => $km->tanggal,
            'keterangan' => $km->keterangan,
            'sumber' => $km->sumber ?? '-',
            'tipe' => 'masuk',
            'nominal' => $km->jumlah,
            'created_at' => $km->created_at ?? $km->tanggal . ' 00:00:00',
        ]);
    }
    
    foreach($kasKeluar as $kk) {
        $allTransactions->push((object)[
            'tanggal' => $kk->tanggal,
            'keterangan' => $kk->keterangan,
            'sumber' => $kk->sumber ?? '-',
            'tipe' => 'keluar',
            'nominal' => $kk->nominal,
            'created_at' => $kk->created_at ?? $kk->tanggal . ' 00:00:00',
        ]);
    }
    
    // Sort descending by date and time
    $allTransactions = $allTransactions->sortByDesc(function ($item) {
        return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($item->created_at)->format('H:i:s');
    })->values();

    // Group by localized date
    $groupedTransactions = $allTransactions->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y');
    });
@endphp

<header>
    <div class="header-left">
        <img src="https://cdn-1.yourmonet.web.id/images/monet.png" alt="Logo" style="height: 35px; vertical-align: middle; margin-right: 8px;">
        <span class="logo-text" style="vertical-align: middle;">monet</span>
    </div>
    <div class="header-right">
        <div class="header-title">Mutasi Transaksi</div>
        <div class="header-subtitle">{{ $namaBulan }}</div>
    </div>
</header>

<footer>
    <div class="footer-left">
        monet.id | Sistem Manajemen Keuangan HIMA PSTI<br>
        Dokumen dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
    </div>
    <div class="footer-right">
        Halaman/Page <span class="page-number"></span>
    </div>
</footer>

<div class="account-info">
    <div class="account-icon">
        <img src="https://cdn-1.yourmonet.web.id/images/monet.png" alt="Logo" style="width: 50px; height: 50px;">
    </div>
    <div class="account-details">
        <div class="account-name" style="font-weight: 600;">MONET</div>
        <div class="account-number">Sistem Manajemen Keuangan - Periode Laporan: {{ $namaBulan }}</div>
    </div>
</div>

<table class="mutasi-table">
    <tbody>
        @forelse($groupedTransactions as $date => $transactions)
            <!-- Date Banner -->
            <tr class="date-group">
                <td colspan="3">{{ $date }}</td>
            </tr>
            
            <!-- Transactions -->
            @foreach($transactions as $tx)
                <tr class="tx-row">
                    <td class="icon-col">
                        <div class="idr-box">
                            <div class="idr-text">IDR</div>
                            @if($tx->tipe === 'masuk')
                                <span class="idr-arrow text-in">IN</span>
                            @else
                                <span class="idr-arrow text-out">OUT</span>
                            @endif
                        </div>
                    </td>
                    <td class="desc-col">
                        <div class="tx-desc">
                            {{ $tx->tipe === 'masuk' ? 'PEMASUKAN' : 'PENGELUARAN' }}
                        </div>
                        <div class="tx-sub">
                            {{ $tx->keterangan }} 
                            | {{ \Carbon\Carbon::parse($tx->created_at)->format('H:i:s') }} 
                            | {{ strtoupper(substr(md5($tx->keterangan . $tx->tanggal), 0, 16)) }}
                        </div>
                    </td>
                    <td class="amount-col {{ $tx->tipe === 'masuk' ? 'text-in' : 'text-out' }}">
                        Rp {{ number_format($tx->nominal, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        @empty
            <tr class="tx-row">
                <td colspan="3" style="text-align:center; color:#737685; padding: 20px;">
                    Tidak ada mutasi transaksi pada bulan ini.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="saldo-summary">
    <div class="saldo-col">
        <div class="saldo-label">Total Pemasukan</div>
        <div class="saldo-val text-in">Rp {{ number_format($totalMasuk, 2, ',', '.') }}</div>
    </div>
    <div class="saldo-col">
        <div class="saldo-label">Total Pengeluaran</div>
        <div class="saldo-val text-out">Rp {{ number_format($totalKeluar, 2, ',', '.') }}</div>
    </div>
    <div class="saldo-col">
        <div class="saldo-label">Saldo Bersih</div>
        <div class="saldo-val {{ $saldoBersih >= 0 ? 'text-in' : 'text-out' }}">
            {{ $saldoBersih >= 0 ? '+' : '-' }} Rp {{ number_format(abs($saldoBersih), 2, ',', '.') }}
        </div>
    </div>
</div>

</body>
</html>
