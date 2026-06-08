<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengajuan Dana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #003d9b;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #003d9b;
            color: #ffffff;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-approved {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .badge-rejected {
            background-color: #ffdad6;
            color: #93000a;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PENGAJUAN DANA & BANTUAN</h2>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
        @if($status || $search || $tglMulai || $tglSelesai)
            <p style="font-size: 10px;">
                Filter: 
                @if($status) [Status: {{ $status }}] @endif
                @if($search) [Pencarian: "{{ $search }}"] @endif
                @if($tglMulai) [Dari: {{ $tglMulai }}] @endif
                @if($tglSelesai) [Sampai: {{ $tglSelesai }}] @endif
            </p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama Pemohon</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Jenis Pengajuan</th>
                <th width="12%" class="text-right">Nominal</th>
                <th width="10%" class="text-center">Status</th>
                <th width="15%">Diverifikasi Oleh</th>
                <th width="20%">Catatan / Alasan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name }} ({{ ucfirst($item->user->role) }})</td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->jenis_pengajuan }}</td>
                    <td class="text-right">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($item->status === 'Disetujui')
                            <span class="badge badge-approved">DISETUJUI</span>
                        @elseif($item->status === 'Ditolak')
                            <span class="badge badge-rejected">DITOLAK</span>
                        @else
                            <span class="badge badge-pending">PENDING</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status === 'Disetujui')
                            {{ $item->approvedBy ? $item->approvedBy->name : '-' }}
                        @elseif($item->status === 'Ditolak')
                            {{ $item->rejectedBy ? $item->rejectedBy->name : '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->status === 'Disetujui')
                            {{ $item->approval_note ?: '-' }}
                        @elseif($item->status === 'Ditolak')
                            {{ $item->rejection_reason ?: '-' }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pengajuan dana.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh Platform MONET.
    </div>
</body>
</html>
