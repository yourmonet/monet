<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Detail Anggota & Riwayat Kas - MONET</title>
<link rel="icon" type="image/png" href="https://cdn-1.yourmonet.web.id/images/monet.png">
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

<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-8">
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

@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen">
    <div class="flex items-center gap-2 text-sm font-semibold text-on-surface-variant mb-6">
        <a href="{{ route('bendahara.manajemen-data-anggota.index') }}" class="hover:text-primary transition-colors">Manajemen Anggota</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-on-surface">Detail Anggota</span>
    </div>

    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Detail Anggota</h1>
            <p class="text-on-surface-variant font-body mt-1">Informasi identitas dan riwayat pembayaran kas.</p>
        </div>
        <div>
            <a href="{{ route('bendahara.manajemen-data-anggota.edit', $user->id) }}" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">edit</span> Edit Data
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profil Ringkas -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30 flex flex-col items-center text-center">
                <div class="relative mb-6">
                    @if($user->avatar)
                        @php
                $loopAv = $user->avatar;
                $loopAvatarUrl = (str_starts_with($loopAv, 'http://') || str_starts_with($loopAv, 'https://')) ? $loopAv : '/storage/' . $loopAv;
            @endphp
            <img src="{{ $loopAvatarUrl }}" class="w-32 h-32 rounded-full object-cover border-4 border-primary-fixed shadow-md" alt="Avatar" referrerpolicy="no-referrer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-32 h-32 rounded-full object-cover border-4 border-primary-fixed shadow-md bg-surface-container-high border border-outline-variant/30 text-on-surface-variant font-bold" style="display:none; align-items:center; justify-content:center;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
                    @else
                        <div class="w-32 h-32 rounded-full bg-surface-container-high border-4 border-primary-fixed shadow-md flex items-center justify-center text-4xl font-bold text-on-surface-variant">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0 w-8 h-8 {{ $user->status_kepatuhan_kas === 'lunas' ? 'bg-green-500' : 'bg-red-500' }} border-4 border-white rounded-full"></div>
                </div>

                <h3 class="text-2xl font-headline font-extrabold text-on-surface mb-1">{{ $user->name }}</h3>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 
                    {{ $user->role === 'bendahara' ? 'bg-blue-100 text-blue-800' : ($user->role === 'pengurus' ? 'bg-emerald-100 text-emerald-800' : 'bg-purple-100 text-purple-800') }}">
                    {{ $user->role }}
                </span>

                <div class="w-full h-px bg-outline-variant/30 my-4"></div>

                <div class="w-full flex flex-col gap-4 text-left text-sm">
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px] text-outline">mail</span>
                        <span class="font-medium break-all">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px] text-outline">call</span>
                        <span class="font-medium">{{ $user->phone_number ?? '-' }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px] text-outline">calendar_today</span>
                        <span class="font-medium">Bergabung {{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                </div>

                <div class="w-full h-px bg-outline-variant/30 my-4"></div>

                <div class="w-full text-left">
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-2">Kepatuhan Kas</p>
                    @if($user->status_kepatuhan_kas === 'lunas')
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-green-50 border border-green-200">
                            <span class="material-symbols-outlined text-green-600">check_circle</span>
                            <span class="text-green-800 font-bold text-sm">Kas Lunas</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 p-3 rounded-xl bg-red-50 border border-red-200">
                            <span class="material-symbols-outlined text-red-600">warning</span>
                            <span class="text-red-800 font-bold text-sm">Terdapat Tunggakan</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="lg:col-span-2">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30 h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-headline font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">receipt_long</span>
                        Riwayat Pembayaran Kas
                    </h3>
                </div>

                @if($user->kasMasuks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-20 h-20 bg-surface-container rounded-full flex items-center justify-center text-outline-variant mb-4">
                            <span class="material-symbols-outlined text-4xl">inventory_2</span>
                        </div>
                        <h4 class="text-lg font-bold text-on-surface mb-1">Belum Ada Riwayat</h4>
                        <p class="text-sm text-on-surface-variant">Anggota ini belum pernah tercatat melakukan pembayaran kas.</p>
                    </div>
                @else
                    <div class="relative border-l-2 border-outline-variant/30 ml-3 md:ml-4 space-y-6">
                        @foreach($user->kasMasuks->sortByDesc('tanggal') as $kas)
                            <div class="relative pl-6 md:pl-8">
                                <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-primary shadow-[0_0_0_4px_white]"></div>
                                <div class="bg-surface-container/30 border border-outline-variant/20 rounded-2xl p-5 hover:bg-surface-container/50 transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                        <div>
                                            <p class="text-xs font-bold text-primary mb-1 uppercase tracking-wider">{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d F Y') }}</p>
                                            <p class="font-bold text-on-surface text-base mb-1">{{ $kas->keterangan }}</p>
                                            <p class="text-xs text-on-surface-variant flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">account_balance_wallet</span>
                                                Sumber Dana: {{ $kas->sumber }}
                                            </p>
                                        </div>
                                        <div class="bg-primary/10 text-primary px-4 py-2 rounded-xl text-center sm:text-right shrink-0">
                                            <p class="text-xs font-bold uppercase tracking-wider opacity-80 mb-0.5">Nominal</p>
                                            <p class="font-extrabold text-lg">Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
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
