# 🪙 MONET - Money on Internet

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.2-blue.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/Database-PostgreSQL-blue.svg)](https://www.postgresql.org)
[![Tailwind CSS](https://img.shields.io/badge/CSS-Tailwind%20%26%20Vanilla-38bdf8.svg)](https://tailwindcss.com)

**MONET (Money on Internet)** adalah platform manajemen keuangan organisasi modern berbasis Laravel 12. Aplikasi ini dirancang untuk mempermudah pencatatan arus kas, penagihan iuran anggota, pengajuan dana bantuan, verifikasi pembayaran real-time, serta penyusunan laporan keuangan secara transparan, akuntabel, dan efisien.

---

## 🌟 Fitur Utama

### 👥 1. Sistem Multi-Role Terproteksi (Otorisasi Pengguna)
Aplikasi membedakan hak akses dan fungsionalitas berdasarkan 3 peran utama secara ketat:
*   **Bendahara:** Memiliki kendali penuh atas manajemen kas masuk/keluar, pengelolaan kategori transaksi, pembuatan tagihan iuran bulanan, verifikasi pembayaran anggota, persetujuan/penolakan pengajuan dana, manajemen data anggota, serta ekspor laporan keuangan.
*   **Pengurus:** Memiliki akses untuk memonitor status pembayaran kas anggota, melakukan pengajuan dana organisasi, memantau riwayat transaksi keuangan, serta melakukan persetujuan (approval) pengajuan dana tertentu.
*   **Anggota:** Mengakses dashboard pribadi, melihat tagihan yang belum dibayar, mengunggah bukti transfer manual atau membayar via gateway, dan mengajukan dana bantuan.

### 📧 2. Otomatisasi Tagihan & Notifikasi Email
*   **Generate Tagihan Massal:** Bendahara dapat membuat tagihan iuran kas bulanan secara masal untuk seluruh anggota aktif (Pengurus & Bendahara) dengan nominal yang ditentukan.
*   **Notifikasi Tagihan Baru:** Sistem secara otomatis mengirimkan email notifikasi tagihan baru saat tagihan berhasil dibuat.
*   **Email Transaksional Status:** Pengiriman email konfirmasi otomatis kepada anggota saat pembayaran berhasil diverifikasi (`Lunas`) atau ditolak (`Ditolak`) lengkap dengan alasan penolakan yang ditulis oleh Bendahara.

### 🔔 3. Manajemen Tagihan & Pengingat Massal (Spam Protected)
*   **Siklus Status Pembayaran:** Terintegrasi mulai dari *Belum Bayar*, *Menunggu Verifikasi*, *Lunas*, hingga *Ditolak*.
*   **Upload Bukti Pembayaran:** Anggota dapat mengunggah bukti pembayaran secara langsung melalui dashboard mereka.
*   **Pengingat Massal (Mass Reminder):** Bendahara dan Pengurus dapat mengirimkan email pengingat (reminder) secara massal ke seluruh anggota yang menunggak secara synchronous. Dilengkapi proteksi spam (maksimal 1 kali pengingat per 24 jam per anggota) dan pengaman waktu eksekusi PHP (`set_time_limit(0)`).

### ⚖️ 4. Approval System Pengajuan Dana & Timeline
*   **Formulir Pengajuan Dana:** Pengguna dapat mengajukan bantuan/dana dengan melampirkan keterangan nominal, bank tujuan, nomor rekening, dan dokumen pendukung.
*   **Tinjauan & Keputusan:** Bendahara dan Pengurus dapat meninjau, menyetujui, atau menolak pengajuan dana dengan menyertakan catatan persetujuan atau alasan penolakan.
*   **Timeline Status Dinamis:** Dilengkapi visualisasi riwayat status proses pengajuan secara dinamis dari pembuatan hingga keputusan akhir.

### 📊 5. Transaksi & Laporan Keuangan Interaktif
*   **Kas Masuk & Kas Keluar:** Pencatatan arus keuangan yang dikelompokkan berdasarkan kategori transaksi.
*   **Grafik Interaktif:** Visualisasi data pengeluaran dan pemasukan bulanan untuk memudahkan analisis.
*   **Ekspor Data:** Fitur cetak laporan keuangan dan pengajuan dana ke format **PDF** dan **Excel** menggunakan Barryvdh DomPDF & PhpSpreadsheet.

### 🔐 6. Google OAuth & Sistem Keamanan (OTP)
*   **Google Sign-In:** Integrasi OAuth 2.0 menggunakan Laravel Socialite dengan alur pelengkapan profil (complete profile) apabila data belum lengkap.
*   **Sistem OTP (One-Time Password):** Digunakan untuk proses verifikasi email dan reset password secara aman.

### 💳 7. Integrasi Midtrans Payment Gateway
*   Mendukung pemrosesan pembayaran otomatis melalui callback webhook Midtrans untuk integrasi pembayaran online yang aman dan real-time.

---

## 🛠️ Spesifikasi Teknologi

| Teknologi | Deskripsi |
| --- | --- |
| **Framework Utama** | Laravel 12 (PHP >= 8.2) |
| **Database** | PostgreSQL (Supabase RDS dengan Connection Pooler) |
| **Front-End Styling** | TailwindCSS, Vanilla CSS, Material Symbols Outlined |
| **Penyimpanan Media** | AWS S3 SDK (Supabase Storage Cloud Bucket) |
| **Layanan Email** | SMTP (Gmail SMTP dengan enkripsi SSL/SMTPS) |
| **Payment Gateway** | Midtrans API & Webhook Callback |
| **Eksportir Dokumen** | Barryvdh DomPDF & PhpSpreadsheet |
| **Autentikasi Pihak ke-3** | Laravel Socialite (Google OAuth 2.0) |

---

## 📂 Struktur Direktori Utama

Untuk memudahkan pengembangan, berikut adalah struktur folder utama dari aplikasi ini:

```
monet/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                  # Controller Autentikasi (Google OAuth, OTP, dll)
│   │   │   ├── Bendahara/             # Controller khusus fitur Bendahara (Manajemen Anggota)
│   │   │   ├── Pengurus/              # Controller khusus fitur Pengurus
│   │   │   ├── User/                  # Controller khusus fitur Anggota (Pembayaran Kas)
│   │   │   └── ...                    # Controller KasMasuk, KasKeluar, Laporan, Midtrans, dll
│   ├── Models/                        # Model Eloquent (User, KasMasuk, KasKeluar, TagihanKas, dll)
│   ├── Mail/                          # Template Mailable untuk notifikasi email
│   ├── Jobs/                          # Background Jobs (jika menggunakan queue async)
│   └── Providers/                     # Service Providers
├── bootstrap/                         # Bootstrapping Laravel (konfigurasi routing & middleware)
├── config/                            # File konfigurasi aplikasi (app, database, services, dll)
├── database/
│   ├── migrations/                    # File migrasi database
│   └── seeders/                       # Seed data untuk testing
├── resources/
│   ├── css/                           # File stylesheet (Tailwind & custom CSS)
│   ├── js/                            # JavaScript frontend
│   └── views/                         # Template Blade (layouts, dashboard, kas, dll)
├── routes/
│   ├── web.php                        # Route utama aplikasi (dashboard, kas, pengajuan, dll)
│   └── auth.php                       # Route autentikasi (login, register, reset password, OTP)
└── vite.config.js                     # Konfigurasi bundling Vite
```

---

## 💾 Skema Database Utama

Berikut penjelasan singkat mengenai skema tabel-tabel utama di database:

*   **`users`**: Menyimpan informasi pengguna (nama, email, role, google_id, nomor hp, avatar, status verifikasi).
*   **`tagihan_kas`**: Tabel master untuk mengelola periode nominal iuran kas bulanan.
*   **`pembayaran_kas`**: Menyimpan status iuran kas anggota per periode (status: *Belum Bayar*, *Menunggu Verifikasi*, *Lunas*, *Ditolak*), bukti bayar, dan alasan penolakan.
*   **`pembayaran_kas_reminders`**: Log pengiriman email pengingat iuran kas untuk mencegah spam (proteksi 24 jam).
*   **`pengajuan_dana`**: Menyimpan permohonan dana bantuan (nominal, rekening, bank tujuan, dokumen pendukung, status persetujuan).
*   **`pengajuan_dana_histories`**: Log riwayat status approval pengajuan dana (timeline data).
*   **`kas_masuk` & `kas_keluar`**: Transaksi arus kas keluar masuk organisasi.
*   **`kategori_transaksi`**: Kategori penataan kas masuk dan keluar.

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat Sistem
Pastikan perangkat Anda telah terinstal:
*   **PHP >= 8.2** (aktifkan ekstensi `pdo_pgsql`, `openssl`, `mbstring`, `curl`, `gd`, `zip`)
*   **Composer** (Dependency manager PHP)
*   **Node.js & NPM** (untuk build tool frontend)
*   **PostgreSQL** (lokal atau cloud instance seperti Supabase)

### 2. Kloning Repositori
```bash
git clone <url-repository> monet
cd monet
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan lengkapi konfigurasi berikut:

*   **Database (PostgreSQL)**
    ```env
    DB_CONNECTION=pgsql
    DB_HOST=your-supabase-host.supabase.co
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres.xxxx
    DB_PASSWORD=your_password
    ```
*   **Mail Server (SMTP Gmail)**
    ```env
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=465
    MAIL_USERNAME=yourmonet.idn@gmail.com
    MAIL_PASSWORD=your_gmail_app_password
    MAIL_ENCRYPTION=smtps
    MAIL_FROM_ADDRESS=yourmonet.idn@gmail.com
    MAIL_FROM_NAME="${APP_NAME}"
    ```
*   **AWS S3 Storage (Supabase Storage)**
    ```env
    FILESYSTEM_DISK=s3
    AWS_ACCESS_KEY_ID=your_access_key
    AWS_SECRET_ACCESS_KEY=your_secret_key
    AWS_DEFAULT_REGION=ap-northeast-1
    AWS_BUCKET=avatars
    AWS_ENDPOINT=https://your-project.supabase.co/storage/v1/s3
    AWS_URL=https://your-project.supabase.co/storage/v1/object/public/avatars
    AWS_USE_PATH_STYLE_ENDPOINT=true
    ```
*   **Google OAuth 2.0 (Socialite)**
    ```env
    GOOGLE_CLIENT_ID=your-google-client-id
    GOOGLE_CLIENT_SECRET=your-google-client-secret
    GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
    ```
*   **Midtrans Payment Gateway**
    ```env
    MIDTRANS_SERVER_KEY=your-midtrans-server-key
    MIDTRANS_CLIENT_KEY=your-midtrans-client-key
    MIDTRANS_IS_PRODUCTION=false
    ```

### 4. Instalasi dan Setup Project
Proyek ini menyediakan script helper di `composer.json` untuk mempercepat instalasi awal. Cukup jalankan perintah berikut di terminal:
```bash
composer setup
```
Perintah di atas secara otomatis akan menjalankan:
1. `composer install`
2. Pembuatan file `.env` (bila belum ada)
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install`
6. `npm run build`

### 5. Seeding Database
Untuk mengisi data uji awal ke dalam database, jalankan command:
```bash
php artisan db:seed
```

### 6. Menjalankan Server Pengembangan
Anda dapat menjalankan semua service yang diperlukan secara bersamaan (Vite, Local Web Server, Queue Listener, dan Pail Logger) menggunakan satu helper command:
```bash
composer dev
```
Atau jika ingin menjalankannya secara manual di terminal terpisah:
```bash
# Terminal 1: Laravel Server
php artisan serve

# Terminal 2: Vite compiler
npm run dev
```
Buka browser Anda dan akses aplikasi di **`http://localhost:8000`**.

---

## ⚙️ Detail Alur Fitur Khusus

### 1. Pengingat Massal (Mass Reminder)
Fitur **Pengingat Massal** didesain untuk berjalan secara **Synchronous** secara default.
*   **Mengapa Synchronous?** Pada deployment di server kecil atau shared hosting, service queue worker (`php artisan queue:work`) seringkali mati tiba-tiba dan membutuhkan pemantauan proses khusus. Pengiriman secara *sync* menjamin email langsung dikirim saat tombol diklik.
*   **Spam Protection & Timeout Guard:** 
    *   Sistem membatasi pengiriman reminder maksimal **1 kali per 24 jam per anggota**. Log tersimpan di tabel `pembayaran_kas_reminders`.
    *   Pernyataan `@set_time_limit(0)` digunakan sebelum perulangan pengiriman email agar script PHP tidak mengalami timeout saat menangani puluhan email sekaligus.

### 2. Google OAuth & Role Matching
*   Saat pertama kali mendaftar via tombol "Sign in with Google", sistem akan mengarahkan pengguna ke halaman Google.
*   Setelah berhasil diautentikasi oleh Google, jika data pengguna baru pertama kali masuk sistem dan data belum lengkap (seperti role belum ditentukan), sistem akan mengarahkan ke halaman pelengkapan profil (`/auth/google/complete`) untuk memilih role target (`anggota`, `pengurus`, `bendahara`) sebelum dashboard dapat diakses.

### 3. Midtrans Integration Webhook Callback
*   Semua request callback pembayaran online dari Midtrans diterima pada endpoint `/midtrans/callback` (pembayaran kas) dan `/midtrans/callback-keluar` (pembayaran pengeluaran / payouts).
*   Route callback ini telah didaftarkan dalam pengecualian CSRF token di `bootstrap/app.php` untuk memastikan webhook dapat berkomunikasi dengan lancar tanpa error token mismatch.
