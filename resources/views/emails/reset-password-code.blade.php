<!DOCTYPE html>
<html>
<head>
    <title>Kode Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo,</h2>
    <p>Kami menerima permintaan untuk mereset password akun Anda. Silakan gunakan kode berikut untuk mereset password Anda:</p>
    
    <div style="background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
        <h1 style="margin: 0; font-size: 32px; letter-spacing: 5px; color: #003d9b;">{{ $code }}</h1>
    </div>
    
    <p>Kode ini akan kadaluarsa dalam 15 menit.</p>
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
    
    <br>
    <p>Terima kasih,<br>{{ config('app.name') }}</p>
</body>
</html>
