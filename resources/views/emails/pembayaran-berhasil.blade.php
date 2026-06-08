<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil Diverifikasi</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #191c1e;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px border-outline-variant/30;">
        <!-- Header -->
        <tr>
            <td align="center" style="background-color: #198754; padding: 40px 20px;">
                <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">BERHASIL</h1>
                <p style="color: #d1e7dd; margin: 5px 0 0 0; font-size: 14px; font-weight: 500;">Pembayaran Kas Diterima</p>
            </td>
        </tr>
        <!-- Body -->
        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 0; color: #198754;">Halo, {{ $pembayaran->user->name }}</h2>
                <p style="font-size: 15px; line-height: 1.6; color: #434654;">
                    Pembayaran uang kas Anda telah diverifikasi oleh Bendahara dan dinyatakan lunas. Terima kasih atas partisipasi aktif Anda.
                </p>

                <!-- Details Card -->
                <table width="100%" style="background-color: #edeef0; border-radius: 16px; margin: 24px 0; padding: 20px; border-collapse: collapse;">
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;" width="40%">Organisasi</td>
                        <td style="font-size: 14px; font-weight: bold; color: #191c1e; padding-bottom: 8px;">MONET</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Periode</td>
                        <td style="font-size: 14px; font-weight: bold; color: #191c1e; padding-bottom: 8px;">
                            @php
                                $parts = explode('-', $pembayaran->periode);
                                $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                $bulanNama = isset($parts[1]) ? $months[(int)$parts[1]] : $pembayaran->periode;
                                $tahun = isset($parts[0]) ? $parts[0] : '';
                            @endphp
                            {{ $bulanNama }} {{ $tahun }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Nominal Pembayaran</td>
                        <td style="font-size: 16px; font-weight: 800; color: #198754; padding-bottom: 8px;">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Tanggal Verifikasi</td>
                        <td style="font-size: 14px; font-weight: bold; color: #191c1e; padding-bottom: 8px;">{{ \Carbon\Carbon::parse($pembayaran->updated_at)->format('d F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685;">Status Akhir</td>
                        <td style="font-size: 12px; font-weight: bold; color: #0f5132; background-color: #d1e7dd; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                            {{ $pembayaran->status }}
                        </td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #737685; text-align: center; margin-top: 30px;">
                    Transaksi ini otomatis dicatat ke dalam modul Kas Masuk Organisasi.
                </p>
            </td>
        </tr>
        <!-- Footer -->
        <tr>
            <td align="center" style="background-color: #edeef0; padding: 24px; font-size: 12px; color: #737685;">
                <p style="margin: 0;">Email ini dikirim secara otomatis oleh platform MONET.</p>
                <p style="margin: 5px 0 0 0;">&copy; 2026 MONET. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
