<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Kas Baru</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #191c1e;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px border-outline-variant/30;">
        <!-- Header -->
        <tr>
            <td align="center" style="background-color: #003d9b; padding: 40px 20px;">
                <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">MONET</h1>
                <p style="color: #dae2ff; margin: 5px 0 0 0; font-size: 14px; font-weight: 500;">Sistem Keuangan Organisasi</p>
            </td>
        </tr>
        <!-- Body -->
        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 0; color: #003d9b;">Halo, {{ $pembayaran->user->name }}</h2>
                <p style="font-size: 15px; line-height: 1.6; color: #434654;">
                    Tagihan kas bulanan baru Anda telah diterbitkan untuk organisasi. Harap lakukan pembayaran sebelum tanggal jatuh tempo.
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
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Nominal</td>
                        <td style="font-size: 16px; font-weight: 800; color: #003d9b; padding-bottom: 8px;">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Jatuh Tempo</td>
                        <td style="font-size: 14px; font-weight: bold; color: #ba1a1a; padding-bottom: 8px;">10 {{ $bulanNama }} {{ $tahun }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685;">Status</td>
                        <td style="font-size: 12px; font-weight: bold; color: #856404; background-color: #fff3cd; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                            {{ $pembayaran->status }}
                        </td>
                    </tr>
                </table>

                <!-- Button -->
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                    <tr>
                        <td align="center" style="background-color: #003d9b; border-radius: 12px;">
                            <a href="{{ url('/user/pembayaran') }}" target="_blank" style="display: inline-block; padding: 14px 30px; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: bold; letter-spacing: 0.5px;">Bayar Sekarang</a>
                        </td>
                    </tr>
                </table>
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
