<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data & Kelola Anggota | MONET</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #ffffff;
            --sidebar-bg: #f8faff;
            --sidebar-border: #e2e8f0;
            --blue-dark: #1e3a8a;
            --blue-corporate: #2563eb;
            --blue-light: #eff6ff;
            --blue-bright: #dbeafe;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --danger-bg: #fee2e2;
            --danger-text: #991b1b;
            --font-family: 'Inter', sans-serif;
            --transition: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-family);
        }

        body {
            background-color: var(--primary-bg);
            color: var(--gray-800);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 10;
        }

        .sidebar-header {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header svg {
            width: 32px;
            height: 32px;
            color: var(--blue-dark);
        }

        .sidebar-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--blue-dark);
            letter-spacing: -0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0 16px;
            overflow-y: auto;
            margin-top: 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            margin-bottom: 8px;
            transition: var(--transition);
        }

        .nav-item:hover {
            color: var(--blue-dark);
            background-color: rgba(255, 255, 255, 0.5);
        }

        .nav-item.active {
            background-color: #ffffff;
            color: var(--blue-dark);
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid var(--gray-200);
        }

        .nav-item svg {
            width: 20px;
            height: 20px;
            color: inherit;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--sidebar-border);
            background-color: var(--sidebar-bg);
        }

        .user-profile-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile-link:hover {
            background-color: var(--blue-light);
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--blue-dark);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info-small {
            display: flex;
            flex-direction: column;
        }

        .user-name-small {
            font-size: 14px;
            font-weight: 600;
            color: var(--gray-800);
        }
        
        .user-role-small {
            font-size: 12px;
            color: var(--gray-500);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            background-color: var(--primary-bg);
            padding: 32px 48px;
            min-height: 100vh;
        }

        .breadcrumb {
            font-size: 13px;
            color: var(--gray-500);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .breadcrumb a {
            color: var(--blue-corporate);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--gray-200);
        }

        .page-title h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--blue-dark);
            color: white;
        }

        .btn-primary:hover {
            background-color: #152c6b;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.15);
        }

        .btn-secondary {
            background-color: var(--gray-200);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background-color: var(--gray-300);
        }

        .content-layout {
            display: flex;
            gap: 32px;
            align-items: flex-start;
        }

        /* Panel 1 (35%) */
        .panel-left {
            width: 35%;
            background-color: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 32px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--gray-200);
            color: var(--gray-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 20px;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        
        .avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-change-photo {
            background-color: var(--blue-light);
            color: var(--blue-corporate);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 24px;
            cursor: pointer;
            border: none;
            transition: var(--transition);
        }

        .btn-change-photo:hover {
            background-color: var(--blue-bright);
        }

        .divider {
            width: 100%;
            height: 1px;
            background-color: var(--gray-200);
            margin: 20px 0;
        }

        .status-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
        }

        .status-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-500);
        }

        .badge-active {
            background-color: var(--success-bg);
            color: var(--success-text);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .badge-active::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--success-text);
        }

        #finance-status-display {
            font-size: 14px;
            font-weight: 700;
        }

        .status-lunas {
            color: var(--success-text);
        }

        .status-tunggakan {
            color: var(--danger-text);
        }

        .member-date {
            margin-top: 24px;
            font-size: 13px;
            color: var(--gray-500);
        }

        /* Panel 2 (65%) */
        .panel-right {
            width: 65%;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .form-section {
            background-color: white;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-700);
        }

        .form-control {
            padding: 12px 16px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 14px;
            color: var(--gray-800);
            background-color: var(--primary-bg);
            transition: var(--transition);
            outline: none;
            width: 100%;
        }

        .form-control:hover {
            border-color: var(--gray-400);
        }

        .form-control:focus {
            border-color: var(--blue-corporate);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px;
            padding-right: 40px;
            cursor: pointer;
        }

        .role-wrapper {
            position: relative;
        }

        .role-badge {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--blue-bright);
            color: var(--blue-dark);
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            pointer-events: none;
        }

        /* Micro-animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .panel-left, .panel-right {
            animation: fadeIn 0.4s ease-out forwards;
        }
        
        .panel-right {
            animation-delay: 0.1s;
            opacity: 0;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-layout {
                flex-direction: column;
            }
            .panel-left, .panel-right {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <!-- Globe Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
            </svg>
            <h1>monet</h1>
        </div>

        <nav class="sidebar-nav">
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                Dashboard
            </a>
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                Kas Masuk
            </a>
            <a href="#" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                Kas Keluar
            </a>
            <a href="#" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                Kelola Pengguna
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="#" class="user-profile-link" title="Pengaturan Profil">
                <div class="user-avatar-small">BU</div>
                <div class="user-info-small">
                    <span class="user-name-small">Ahmad Fulan</span>
                    <span class="user-role-small">Bendahara Utama</span>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="breadcrumb">
            <a href="#">Dashboard</a>
            <span>/</span>
            <a href="#">Kelola Pengguna</a>
            <span>/</span>
            <span style="color: var(--gray-800); font-weight: 500;">Edit Data</span>
        </div>

        <div class="page-header">
            <div class="page-title">
                <h2>Edit Data & Kelola Anggota</h2>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">Batal</button>
                <button class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </div>

        <div class="content-layout">
            <!-- Panel 1: Identitas & Kepatuhan -->
            <div class="panel-left">
                <div class="avatar-large">
                    AF
                </div>
                <button class="btn-change-photo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg>
                    Ubah Foto Profil
                </button>

                <div class="divider"></div>

                <div class="status-container">
                    <div class="status-item">
                        <span class="status-label">Status Anggota</span>
                        <div class="badge-active">Aktif</div>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Kepatuhan Kas</span>
                        <div id="finance-status-display" class="status-lunas">Lunas</div>
                    </div>
                </div>

                <p class="member-date">Anggota sejak: 12 Jan 2024</p>
            </div>

            <!-- Panel 2: Formulir Data Interaktif -->
            <div class="panel-right">
                <!-- Data Personal -->
                <div class="form-section">
                    <h3 class="section-title">Form Input Data Personal</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="Ahmad Fulan" placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" value="ahmad@email.com" placeholder="nama@email.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telepon/WhatsApp</label>
                            <input type="tel" class="form-control" value="081234567890" placeholder="08...">
                        </div>
                    </div>
                </div>

                <!-- Pengaturan Hak Akses -->
                <div class="form-section">
                    <h3 class="section-title">Form Dropdown Pengaturan Hak Akses</h3>
                    <div class="form-grid">
                        <div class="form-group role-wrapper">
                            <label class="form-label">Peran Akses Sistem</label>
                            <select class="form-control">
                                <option value="bendahara" selected>Bendahara</option>
                                <option value="pengurus">Pengurus</option>
                                <option value="anggota">Anggota</option>
                            </select>
                            <div class="role-badge">Bendahara</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Kepatuhan Kas</label>
                            <select class="form-control" id="finance-status-select">
                                <option value="lunas" selected>Lunas</option>
                                <option value="tunggakan">Tunggakan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Javascript to handle visual interaction between dropdown and status panel
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('finance-status-select');
            const statusDisplay = document.getElementById('finance-status-display');

            statusSelect.addEventListener('change', function() {
                if (this.value === 'lunas') {
                    statusDisplay.textContent = 'Lunas';
                    statusDisplay.className = 'status-lunas';
                } else if (this.value === 'tunggakan') {
                    statusDisplay.textContent = 'Rp 100.000 (Tunggakan)';
                    statusDisplay.className = 'status-tunggakan';
                }
            });
        });
    </script>
</body>
</html>
