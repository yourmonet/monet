<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Detail Pengajuan Dana — MONET</title>
<link class="icon" type="image/png" href="https://cdn-1.yourmonet.web.id/images/monet.png">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "secondary": "#4c5d8d", "tertiary": "#7b2600", "outline-variant": "#c3c6d6",
                    "surface-container-low": "#f3f4f6", "outline": "#737685", "on-primary": "#ffffff",
                    "secondary-fixed": "#dae2ff", "inverse-surface": "#2e3132", "inverse-primary": "#b2c5ff",
                    "secondary-fixed-dim": "#b4c5fb", "on-secondary-fixed-variant": "#344573",
                    "on-secondary": "#ffffff", "error-container": "#ffdad6", "surface-variant": "#e1e2e4",
                    "surface-dim": "#d9dadc", "surface-container": "#edeef0", "surface-container-high": "#e7e8ea",
                    "on-secondary-fixed": "#021945", "on-surface-variant": "#434654", "background": "#f8f9fb",
                    "on-secondary-container": "#415382", "surface-tint": "#0c56d0", "inverse-on-surface": "#f0f1f3",
                    "surface-container-highest": "#e1e2e4", "surface-container-lowest": "#ffffff",
                    "on-primary-fixed-variant": "#0040a2", "secondary-container": "#b6c8fe", "on-primary-fixed": "#001848",
                    "on-primary-container": "#c4d2ff", "tertiary-container": "#a33500", "on-tertiary-container": "#ffc6b2",
                    "on-surface": "#191c1e", "on-error-container": "#93000a", "primary-container": "#0052cc",
                    "surface": "#f8f9fb", "on-background": "#191c1e", "primary": "#003d9b",
                    "primary-fixed": "#dae2ff", "error": "#ba1a1a"
                },
                borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.75rem", "full": "0.75rem" },
                fontFamily: { "headline": ["Manrope"], "body": ["Inter"], "label": ["Inter"] }
            },
        },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="bg-surface font-body text-on-surface">

<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-4 md:px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-4 md:gap-8">
        <button onclick="toggleSidebar()" class="md:hidden mr-2 text-on-surface hover:text-primary transition-colors flex items-center"><span class="material-symbols-outlined text-[28px]">menu</span></button>
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5">Bendahara</div>
        </div>
        @if(Auth::user()->avatar)
            @php
                $av = Auth::user()->avatar;
                $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
            @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="Profile" referrerpolicy="no-referrer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-10 h-10 rounded-full object-cover shadow-sm bg-surface-container-high border border-outline-variant/30 text-on-surface-variant font-bold" style="display:none; align-items:center; justify-content:center;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @else
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>

{{-- Sidebar component --}}
@include('components.sidebar-bendahara')

{{-- Main Content --}}
<main class="md:ml-64 p-4 pt-20 md:p-8 md:pt-20 min-h-screen">
    <header class="mb-10">
        <a href="{{ route('bendahara.pengajuan-dana.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-outline hover:text-primary transition-colors mb-3 group">
            <span class="material-symbols-outlined text-base group-hover:-translate-x-1 transition-transform">arrow_back</span>
            Kembali ke Daftar
        </a>
        <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Detail Pengajuan Dana</h1>
        <p class="text-on-surface-variant font-body mt-1">Tinjau detail permohonan dana dari anggota sebelum memproses status persetujuan.</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Detail Information --}}
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30 space-y-6">
            <div>
                <h3 class="text-lg font-headline font-bold border-b border-outline-variant/20 pb-2 mb-4 text-on-surface">Informasi Anggota</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-outline font-semibold uppercase tracking-wider">Nama Anggota</p>
                        <p class="font-bold text-on-surface text-base">{{ $pengajuan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-outline font-semibold uppercase tracking-wider">Email</p>
                        <p class="font-bold text-on-surface text-base">{{ $pengajuan->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-outline font-semibold uppercase tracking-wider">No. Telepon / WA</p>
                        <p class="font-bold text-on-surface text-base">{{ $pengajuan->user->phone_number ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-outline font-semibold uppercase tracking-wider">Tanggal Pengajuan</p>
                        <p class="font-bold text-on-surface text-base">{{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-headline font-bold border-b border-outline-variant/20 pb-2 mb-4 text-on-surface">Informasi Pengajuan</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-outline font-semibold uppercase tracking-wider">Jenis Pengajuan</p>
                            <span class="inline-block mt-1 px-3 py-1 bg-surface-container rounded-full text-xs font-semibold text-on-surface-variant">
                                {{ $pengajuan->jenis_pengajuan }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-outline font-semibold uppercase tracking-wider">Jumlah Dana Diajukan</p>
                            <p class="font-extrabold text-primary text-xl mt-1">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-outline font-semibold uppercase tracking-wider">Keterangan / Alasan</p>
                        <div class="bg-surface-container-low rounded-2xl p-4 mt-1 border border-outline-variant/20 text-sm text-on-surface leading-relaxed whitespace-pre-line">
                            {{ $pengajuan->keterangan }}
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-outline font-semibold uppercase tracking-wider mb-2">Berkas / File Pendukung</p>
                        @if ($pengajuan->file_pendukung)
                            <div class="flex items-center gap-3 bg-surface-container-low rounded-2xl p-4 border border-outline-variant/20">
        <button onclick="toggleSidebar()" class="md:hidden mr-2 text-on-surface hover:text-primary transition-colors flex items-center"><span class="material-symbols-outlined text-[28px]">menu</span></button>
                                <span class="material-symbols-outlined text-3xl text-primary">description</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-on-surface truncate">{{ basename($pengajuan->file_pendukung) }}</p>
                                    <p class="text-[10px] text-outline">Format Berkas Pendukung</p>
                                </div>
                                <a href="{{ $pengajuan->file_url }}" target="_blank"
                                    class="inline-flex items-center gap-1 bg-primary text-on-primary px-4 py-2 rounded-xl text-xs font-bold hover:bg-primary/95 transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-xs">download</span> Unduh / Lihat
                                </a>
                            </div>
                        @else
                            <p class="text-sm text-outline italic">Tidak ada berkas pendukung yang diunggah.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Process Form / Status --}}
        <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30 space-y-6">
            <h3 class="text-lg font-headline font-bold border-b border-outline-variant/20 pb-2 text-on-surface">Tindakan Persetujuan</h3>

            {{-- Info Status Saat Ini --}}
            <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-2xl border border-outline-variant/20">
                <span class="text-sm font-semibold text-on-surface-variant">Status Saat Ini:</span>
                @if ($pengajuan->status === 'pending')
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                        Pending
                    </span>
                @elseif ($pengajuan->status === 'disetujui')
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span>
                        Disetujui
                    </span>
                @elseif ($pengajuan->status === 'ditolak')
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                        Ditolak
                    </span>
                @endif
            </div>

            @if ($pengajuan->status === 'pending')
                <form action="{{ route('bendahara.pengajuan-dana.proses', $pengajuan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-on-surface mb-2">Tentukan Keputusan <span class="text-error">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex flex-col items-center justify-center p-4 border border-outline-variant/40 rounded-2xl cursor-pointer hover:bg-surface-container/30 transition-all [&:has(input:checked)]:border-green-600 [&:has(input:checked)]:bg-green-50/50">
                                <input type="radio" name="status" value="disetujui" required class="sr-only">
                                <span class="material-symbols-outlined text-2xl text-green-600 mb-1">check_circle</span>
                                <span class="text-xs font-bold text-green-800">Setujui</span>
                            </label>
                            <label class="flex flex-col items-center justify-center p-4 border border-outline-variant/40 rounded-2xl cursor-pointer hover:bg-surface-container/30 transition-all [&:has(input:checked)]:border-red-600 [&:has(input:checked)]:bg-red-50/50">
                                <input type="radio" name="status" value="ditolak" required class="sr-only">
                                <span class="material-symbols-outlined text-2xl text-red-600 mb-1">cancel</span>
                                <span class="text-xs font-bold text-red-800">Tolak</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-error text-xs font-bold mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan_pengurus" class="block text-sm font-bold text-on-surface mb-2">Catatan Bendahara (Opsional)</label>
                        <textarea id="catatan_pengurus" name="catatan_pengurus" rows="4" placeholder="Berikan catatan persetujuan atau alasan penolakan pengajuan..."
                            class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary shadow-sm bg-surface-container-lowest text-sm text-on-surface transition-all"></textarea>
                        @error('catatan_pengurus')
                            <p class="text-error text-xs font-bold mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-primary text-on-primary py-3 rounded-2xl text-sm font-bold hover:bg-primary/95 transition-all shadow-md hover:shadow-lg">
                        <span class="material-symbols-outlined text-lg">fact_check</span>
                        Proses Keputusan
                    </button>
                </form>
            @else
                <div class="bg-surface-container-low rounded-2xl p-4 border border-outline-variant/20 text-sm">
                    <p class="text-xs text-outline font-semibold uppercase tracking-wider">Catatan Pengurus/Bendahara</p>
                    <p class="mt-1 font-medium text-on-surface italic">{{ $pengajuan->catatan_pengurus ?: 'Tidak ada catatan.' }}</p>
                </div>
            @endif
        </div>
    </div>
</main>

{{-- Logout Modal --}}
<div id="logout-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="hideLogoutModal()"></div>
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-sm relative z-10 transform scale-95 transition-transform duration-300">
        <div class="w-16 h-16 bg-error-container border-4 border-white shadow-sm rounded-full flex items-center justify-center text-error mb-4 mx-auto -mt-12">
            <span class="material-symbols-outlined text-3xl">logout</span>
        </div>
        <h2 class="text-2xl font-headline font-extrabold text-center text-on-surface mb-2">Keluar?</h2>
        <p class="text-center text-on-surface-variant text-sm mb-8">Anda harus login kembali untuk mengakses dashboard.</p>
        <div class="flex gap-3">
            <button onclick="hideLogoutModal()" class="flex-1 py-3 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-surface-container transition-colors">
                Batal
            </button>
            <button onclick="document.getElementById('logout-form').submit()" class="flex-1 py-3 px-4 rounded-xl bg-error text-white font-bold text-sm hover:bg-error/90 shadow-lg shadow-error/20 transition-all">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('logout-modal');
    const modalContent = modal.querySelector('div.bg-surface-container-lowest');

    function showLogoutModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function hideLogoutModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
</body>
</html>
