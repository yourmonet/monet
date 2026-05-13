<!DOCTYPE html>
<html>
<head>
    <title>Kode Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo,</h2>
    <p>Terima kasih telah mendaftar. Untuk menyelesaikan proses pendaftaran Anda, silakan gunakan kode verifikasi berikut:</p>
    
    <div style="background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
        <h1 style="margin: 0; font-size: 32px; letter-spacing: 5px; color: #003d9b;">{{ $code }}</h1>
    </div>
    
    <p>Kode ini akan kadaluarsa dalam 15 menit.</p>
    <p>Jika Anda tidak merasa mendaftar di aplikasi ini, abaikan email ini.</p>
    
    <br>
    <p>Terima kasih,<br>{{ config('app.name') }}</p>
</body>
</html>
