<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Dashboard Pengurus - MONET</title>
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
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5">Pengurus</div>
        </div>
        @if(Auth::user()->avatar)
            @php $avatarUrl = Str::startsWith(Auth::user()->avatar, ['http://', 'https://']) ? Auth::user()->avatar : Storage::url(Auth::user()->avatar); @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="Profile">
        @else
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>

<aside class="h-screen w-64 fixed left-0 top-0 bg-gray-100 flex flex-col p-4 pt-20 z-40">


    <nav class="flex flex-col gap-1 flex-1">
        <a class="flex items-center gap-3 px-4 py-3 bg-white text-blue-700 rounded-lg scale-95 transition-all font-headline font-medium text-sm" href="#">
            <span class="material-symbols-outlined">dashboard</span> Dashboard
        </a>
    </nav>

    <div class="mt-auto flex flex-col gap-1 border-t border-outline-variant/10 pt-4">
        <form id="logout-form" method="POST" action="/pengurus/logout">
            @csrf
            <button type="button" onclick="showLogoutModal()" id="btn-logout-pengurus"
                class="w-full flex items-center gap-3 px-4 py-3 text-error hover:bg-error-container/20 transition-all font-headline font-medium text-sm">
                <span class="material-symbols-outlined">logout</span> Keluar
            </button>
        </form>
    </div>
</aside>

<main class="ml-64 pt-20 p-8 min-h-screen">

    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Dashboard Pengurus</h1>
            <p class="text-on-surface-variant font-body mt-1">Ringkasan operasional dan keuangan organisasi.</p>
        </div>
    </header>

    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container rounded-xl border border-error/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-error">error</span>
            <p class="text-on-error-container text-sm">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Saldo Card --}}
        <div class="bg-primary text-on-primary rounded-3xl p-6 shadow-lg shadow-primary/30 relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-colors duration-500"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div>
                    <p class="text-on-primary/80 text-sm font-semibold uppercase tracking-wider mb-1">Total Saldo Kas</p>
                    <h3 class="text-3xl font-headline font-bold">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm shadow-inner">
                    <span class="material-symbols-outlined text-white">account_balance_wallet</span>
                </div>
            </div>
        </div>

        {{-- Kas Masuk Card --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/30 hover:border-primary/30 hover:shadow-md transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-on-surface-variant text-sm font-semibold uppercase tracking-wider mb-1">Pemasukan Bulan Ini</p>
                    <h3 class="text-3xl font-headline font-bold text-on-surface">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-primary-container/40 text-primary rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined">south_west</span>
                </div>
            </div>
        </div>

        {{-- Kas Keluar Card --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/30 hover:border-error/30 hover:shadow-md transition-all duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-on-surface-variant text-sm font-semibold uppercase tracking-wider mb-1">Pengeluaran Bulan Ini</p>
                    <h3 class="text-3xl font-headline font-bold text-on-surface">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 bg-error-container/60 text-error rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined">north_east</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Transactions List --}}
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-headline font-bold text-on-surface">Transaksi Terbaru</h3>
                <a href="#" class="text-primary font-bold text-sm hover:text-primary/80 transition-colors flex items-center gap-1 group">
                    Lihat Semua
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
            <div class="space-y-3">
                @forelse ($transaksiTerbaru as $transaksi)
                    <div class="flex items-center justify-between p-4 hover:bg-surface-container rounded-2xl transition-all duration-200 cursor-pointer border border-transparent hover:border-outline-variant/30">
                        <div class="flex items-center gap-4">
                            @if ($transaksi->type === 'masuk')
                                <div class="w-12 h-12 rounded-full bg-primary-container/40 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined">south_west</span>
                                </div>
                            @else
                                <div class="w-12 h-12 rounded-full bg-error-container/60 text-error flex items-center justify-center">
                                    <span class="material-symbols-outlined">north_east</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-on-surface text-base">{{ $transaksi->keterangan }}</p>
                                <p class="text-sm text-on-surface-variant mt-0.5">{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if ($transaksi->type === 'masuk')
                                <p class="font-extrabold text-primary text-lg">+ Rp {{ number_format($transaksi->nominal_transaksi, 0, ',', '.') }}</p>
                                <p class="text-[11px] font-bold tracking-wide uppercase text-on-surface-variant mt-1 border border-outline-variant/40 rounded-lg px-2.5 py-1 inline-block bg-surface-container-lowest">Kas Masuk</p>
                            @else
                                <p class="font-extrabold text-error text-lg">- Rp {{ number_format($transaksi->nominal_transaksi, 0, ',', '.') }}</p>
                                <p class="text-[11px] font-bold tracking-wide uppercase text-on-surface-variant mt-1 border border-outline-variant/40 rounded-lg px-2.5 py-1 inline-block bg-surface-container-lowest">Kas Keluar</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-on-surface-variant">
                        <p>Belum ada transaksi terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-col gap-6">


            <div class="bg-gradient-to-br from-secondary-container to-secondary-fixed rounded-3xl p-8 shadow-sm border border-secondary-fixed/50 relative overflow-hidden flex-1 group">
                <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-primary/10 rounded-full blur-3xl group-hover:bg-primary/20 transition-colors duration-500"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-headline font-extrabold text-on-secondary-container mb-2">Butuh Bantuan?</h3>
                    <p class="text-sm text-on-secondary-container/80 mb-6 font-medium leading-relaxed">Pelajari cara mengelola kas dengan lebih efektif menggunakan sistem MONET.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-on-secondary-container text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-on-secondary-container/90 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-lg">menu_book</span>
                        Baca Panduan
                    </a>
                </div>
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
