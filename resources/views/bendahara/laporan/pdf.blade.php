<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Laporan Keuangan {{ $namaBulan }}</title>
    <link rel="shortcut icon" href="https://cdn-1.yourmonet.web.id/images/monet.png" type="png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 50px 100px 60px 100px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 10pt;
            color: #1f2937;
            background: #ffffff;
            line-height: 1.5;
            padding: 0 10px;
        }

        /* Header */
        .report-header {
            width: 100%;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: middle;
        }

        .brand-name {
            font-size: 24pt;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.5px;
            margin-left: 10px;
        }

        .report-title {
            text-align: right;
            font-size: 18pt;
            font-weight: 600;
            color: #111827;
        }

        .report-period {
            text-align: right;
            font-size: 11pt;
            color: #6b7280;
            margin-top: 4px;
        }

        /* Summary Boxes */
        .summary-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .summary-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
        }

        .summary-label {
            font-size: 9pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 14pt;
            font-weight: 700;
        }

        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
        .text-blue { color: #2563eb; }

        /* Transaction Table */
        .tx-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .tx-table th {
            text-align: left;
            padding: 12px 8px;
            border-bottom: 1px solid #d1d5db;
            font-size: 9pt;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
        }

        .tx-row td {
            padding: 12px 8px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
            font-size: 9.5pt;
        }

        .date-cell {
            color: #4b5563;
            width: 15%;
            font-weight: 500;
        }

        .desc-cell {
            width: 50%;
        }

        .desc-title {
            font-weight: 600;
            color: #111827;
        }

        .desc-sub {
            font-size: 8pt;
            color: #9ca3af;
            margin-top: 2px;
        }

        .type-cell {
            width: 15%;
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .badge-in { background-color: #d1fae5; color: #065f46; }
        .badge-out { background-color: #fee2e2; color: #991b1b; }

        .amount-cell {
            width: 20%;
            text-align: right;
            font-weight: 600;
        }

        /* Footer */
        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 40px;
            border-top: 1px solid #e5e7eb;
            padding: 10px 10px 0 10px;
        }

        .footer-table {
            width: 100%;
            font-size: 8pt;
            color: #9ca3af;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>

@php
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
    
    // Sort chronological (ascending) for reports
    $allTransactions = $allTransactions->sortBy(function ($item) {
        return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($item->created_at)->format('H:i:s');
    })->values();
@endphp

<footer>
    <table class="footer-table">
        <tr>
            <td style="width: 50%;">MONET - Sistem Manajemen Keuangan</td>
            <td style="width: 50%; text-align: right;">Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d M Y, H:i') }} | Hal. <span class="page-number"></span></td>
        </tr>
    </table>
</footer>

<div class="report-header">
    <table class="header-table">
        <tr>
            <td style="width: 50%;">
                <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="Logo" style="height: 35px; vertical-align: middle;">
            </td>
            <td style="width: 50%;">
                <div class="report-title">Laporan Keuangan</div>
                <div class="report-period">Periode: {{ $namaBulan }}</div>
            </td>
        </tr>
    </table>
</div>

<table class="summary-table">
    <tr>
        <td style="width: 33.33%; padding-right: 8px;">
            <div class="summary-box" style="border-left: 4px solid #059669;">
                <div class="summary-label">Total Pemasukan</div>
                <div class="summary-value text-green">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
            </div>
        </td>
        <td style="width: 33.33%; padding-right: 4px; padding-left: 4px;">
            <div class="summary-box" style="border-left: 4px solid #dc2626;">
                <div class="summary-label">Total Pengeluaran</div>
                <div class="summary-value text-red">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
            </div>
        </td>
        <td style="width: 33.33%; padding-left: 8px;">
            <div class="summary-box" style="border-left: 4px solid #2563eb;">
                <div class="summary-label">Saldo Bersih</div>
                <div class="summary-value {{ $saldoBersih >= 0 ? 'text-blue' : 'text-red' }}">
                    {{ $saldoBersih >= 0 ? '' : '-' }}Rp {{ number_format(abs($saldoBersih), 0, ',', '.') }}
                </div>
            </div>
        </td>
    </tr>
</table>

<table class="tx-table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Keterangan Transaksi</th>
            <th style="text-align: center;">Tipe</th>
            <th style="text-align: right;">Nominal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($allTransactions as $tx)
            <tr class="tx-row">
                <td class="date-cell">
                    {{ \Carbon\Carbon::parse($tx->tanggal)->format('d/m/Y') }}
                </td>
                <td class="desc-cell">
                    <div class="desc-title">{{ $tx->keterangan }}</div>
                    <div class="desc-sub">Ref: {{ strtoupper(substr(md5($tx->keterangan . $tx->tanggal), 0, 8)) }}</div>
                </td>
                <td class="type-cell">
                    @if($tx->tipe === 'masuk')
                        <span class="badge badge-in">MASUK</span>
                    @else
                        <span class="badge badge-out">KELUAR</span>
                    @endif
                </td>
                <td class="amount-cell {{ $tx->tipe === 'masuk' ? 'text-green' : 'text-red' }}">
                    {{ $tx->tipe === 'masuk' ? '+' : '-' }} Rp{{ number_format($tx->nominal, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#9ca3af; padding: 40px;">
                    Tidak ada transaksi pada periode ini.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
