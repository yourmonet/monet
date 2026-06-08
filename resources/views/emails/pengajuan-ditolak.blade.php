<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Dana Ditolak</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; color: #191c1e;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px border-outline-variant/30;">
        <!-- Header -->
        <tr>
            <td align="center" style="background-color: #ba1a1a; padding: 40px 20px;">
                <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;">MONET</h1>
                <p style="color: #ffdad6; margin: 5px 0 0 0; font-size: 14px; font-weight: 500;">Sistem Keuangan Organisasi</p>
            </td>
        </tr>
        <!-- Body -->
        <tr>
            <td style="padding: 40px 30px;">
                <h2 style="font-size: 20px; font-weight: 700; margin-top: 0; color: #ba1a1a;">Halo, {{ $pengajuan->user->name }}</h2>
                <p style="font-size: 15px; line-height: 1.6; color: #434654;">
                    Mohon maaf, pengajuan dana/bantuan Anda belum dapat disetujui oleh Bendahara.
                </p>

                <!-- Details Card -->
                <table width="100%" style="background-color: #edeef0; border-radius: 16px; margin: 24px 0; padding: 20px; border-collapse: collapse;">
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;" width="40%">Jenis Pengajuan</td>
                        <td style="font-size: 14px; font-weight: bold; color: #191c1e; padding-bottom: 8px;">{{ $pengajuan->jenis_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Jumlah Dana</td>
                        <td style="font-size: 16px; font-weight: 800; color: #ba1a1a; padding-bottom: 8px;">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685; padding-bottom: 8px;">Tanggal Ditolak</td>
                        <td style="font-size: 14px; font-weight: bold; color: #191c1e; padding-bottom: 8px;">{{ \Carbon\Carbon::parse($pengajuan->rejected_at)->format('d F Y H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #ba1a1a; padding-bottom: 8px;">Alasan Penolakan</td>
                        <td style="font-size: 14px; font-weight: bold; color: #ba1a1a; padding-bottom: 8px;">{{ $pengajuan->rejection_reason }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; font-weight: bold; color: #737685;">Status</td>
                        <td style="font-size: 12px; font-weight: bold; color: #93000a; background-color: #ffdad6; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                            {{ $pengajuan->status }}
                        </td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #737685; line-height: 1.5;">
                    Jika ada kesalahan informasi atau ingin mengajukan ulang dengan data pendukung lain, Anda dapat membuat pengajuan baru di menu Pengajuan Dana.
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
