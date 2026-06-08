<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Buat Pengajuan Dana — MONET</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#003d9b", "on-surface": "#191c1e", "surface": "#f8f9fb", "outline-variant": "#c3c6d6",
                    "surface-container-lowest": "#ffffff", "surface-container": "#edeef0", "error": "#ba1a1a",
                    "error-container": "#ffdad6", "on-error-container": "#93000a", "surface-container-high": "#e7e8ea",
                    "success": "#198754", "success-container": "#d1e7dd", "on-success-container": "#0f5132",
                },
                fontFamily: { "headline": ["Manrope"], "body": ["Inter"] }
            },
        },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="bg-surface font-body text-on-surface">

<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased border-b border-outline-variant/30">
    <div class="flex items-center gap-8">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="hidden sm:block text-right">
            <div class="text-sm font-black text-primary leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold mt-0.5">{{ Auth::user()->role }}</div>
        </div>
        @if(Auth::user()->avatar)
            @php
                $av = Auth::user()->avatar;
                $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
            @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm border border-outline-variant/30" alt="Profile" referrerpolicy="no-referrer">
        @else
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>

@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <div class="flex items-center gap-2 text-sm text-on-surface-variant font-medium mb-1">
                <a href="{{ route('bendahara.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <a href="{{ route('bendahara.pengajuan-dana.index') }}" class="hover:text-primary transition-colors">Pengajuan Dana</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-semibold">Buat Pengajuan</span>
            </div>
            <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Buat Pengajuan Dana</h1>
            <p class="text-on-surface-variant font-body mt-1">Lengkapi formulir di bawah ini dengan informasi yang valid.</p>
        </div>
    </header>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-error-container rounded-3xl border border-error/20">
            <div class="flex items-center gap-2 text-error mb-2">
                <span class="material-symbols-outlined">error</span>
                <span class="font-bold text-sm">Terjadi Kesalahan Pengisian:</span>
            </div>
            <ul class="list-disc list-inside text-on-error-container text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 max-w-2xl overflow-hidden">
        <form action="{{ route('bendahara.pengajuan-dana.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <div>
                <label for="jenis_pengajuan" class="block text-sm font-bold text-on-surface-variant mb-2">Jenis Pengajuan</label>
                <select id="jenis_pengajuan" name="jenis_pengajuan" required class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 px-4">
                    <option value="">-- Pilih Jenis Pengajuan --</option>
                    <option value="Kebutuhan Mendesak" {{ old('jenis_pengajuan') == 'Kebutuhan Mendesak' ? 'selected' : '' }}>Kebutuhan Mendesak</option>
                    <option value="Bantuan Sosial" {{ old('jenis_pengajuan') == 'Bantuan Sosial' ? 'selected' : '' }}>Bantuan Sosial</option>
                    <option value="Kegiatan Organisasi" {{ old('jenis_pengajuan') == 'Kegiatan Organisasi' ? 'selected' : '' }}>Kegiatan Organisasi</option>
                    <option value="Lainnya" {{ old('jenis_pengajuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label for="jumlah_dana" class="block text-sm font-bold text-on-surface-variant mb-2">Jumlah Dana (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-sm">Rp</span>
                    <input type="number" id="jumlah_dana" name="jumlah_dana" value="{{ old('jumlah_dana') }}" required min="1" placeholder="Contoh: 50000" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 pl-12 pr-4 font-bold text-primary">
                </div>
            </div>

            <div>
                <label for="no_telp" class="block text-sm font-bold text-on-surface-variant mb-2">Nomor Telepon</label>
                <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', Auth::user()->phone_number) }}" required placeholder="Contoh: 08123456789" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 px-4">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nama_bank" class="block text-sm font-bold text-on-surface-variant mb-2">Nama Bank</label>
                    <input type="text" id="nama_bank" name="nama_bank" value="{{ old('nama_bank') }}" required placeholder="Contoh: BCA" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 px-4">
                </div>
                <div>
                    <label for="no_rekening" class="block text-sm font-bold text-on-surface-variant mb-2">Nomor Rekening</label>
                    <input type="text" id="no_rekening" name="no_rekening" value="{{ old('no_rekening') }}" required placeholder="Contoh: 1234567890" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 px-4">
                </div>
                <div>
                    <label for="nama_rekening" class="block text-sm font-bold text-on-surface-variant mb-2">Nama Pemilik Rekening</label>
                    <input type="text" id="nama_rekening" name="nama_rekening" value="{{ old('nama_rekening') }}" required placeholder="Contoh: Ahmad" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 px-4">
                </div>
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-bold text-on-surface-variant mb-2">Keterangan / Alasan Pengajuan</label>
                <textarea id="keterangan" name="keterangan" rows="4" required placeholder="Jelaskan kebutuhan pengajuan secara detail..." class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm py-3 px-4">{{ old('keterangan') }}</textarea>
            </div>

            <div>
                <label for="file_pendukung" class="block text-sm font-bold text-on-surface-variant mb-2">Dokumen / File Pendukung (Opsional)</label>
                <input type="file" id="file_pendukung" name="file_pendukung" class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/25 border border-outline-variant/40 rounded-2xl p-2 bg-surface-container/20">
                <p class="text-[11px] text-on-surface-variant mt-2">Format: PDF, JPG, JPEG, PNG. Maksimal 5MB.</p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/20">
                <a href="{{ route('bendahara.pengajuan-dana.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-surface-container transition">
                    Batal
                </a>
                <button type="submit" class="py-3 px-6 rounded-2xl bg-primary text-white font-bold text-sm hover:bg-primary/90 shadow-lg shadow-primary/20 transition">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
