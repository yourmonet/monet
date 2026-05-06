<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Laporan Keuangan - MONET</title>
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
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeInUp 0.4s ease both; }
    .fade-in-1 { animation-delay: 0.05s; }
    .fade-in-2 { animation-delay: 0.1s; }
    .fade-in-3 { animation-delay: 0.15s; }
    .fade-in-4 { animation-delay: 0.2s; }
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
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm" style="display:none;">
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

    {{-- Page Header --}}
    <header class="flex justify-between items-end mb-8 fade-in fade-in-1">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">description</span>
                </div>
                <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Laporan Keuangan</h1>
            </div>
            <p class="text-on-surface-variant font-body mt-1 ml-13">Generate & unduh laporan keuangan organisasi otomatis.</p>
        </div>
    </header>

    @php
        $bulan = (int) $bulan;
        $namaBulanList = [
            1 => 'Januari',  2 => 'Februari', 3 => 'Maret',    4 => 'April',
            5 => 'Mei',      6 => 'Juni',     7 => 'Juli',     8 => 'Agustus',
            9 => 'September',10 => 'Oktober', 11 => 'November',12 => 'Desember',
        ];
    @endphp

    {{-- Top Section: Filter & Actions --}}
    <div class="flex flex-col lg:flex-row gap-6 mb-8 fade-in fade-in-2">
        {{-- Filter Card --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm shadow-primary/5 border border-outline-variant/30 flex-1 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all duration-500 group-hover:bg-primary/10"></div>
            <h2 class="text-base font-headline font-bold text-on-surface mb-5 flex items-center gap-2 relative z-10">
                <div class="w-8 h-8 rounded-xl bg-primary-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">tune</span>
                </div>
                Filter Periode
            </h2>
            <form method="GET" action="{{ route('bendahara.laporan.index') }}" class="flex flex-wrap items-end gap-4 relative z-10">
                <div class="flex flex-col gap-1.5 flex-1 min-w-[140px]">
                    <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Bulan</label>
                    <select name="bulan" id="bulan"
                        class="w-full px-4 py-3 rounded-xl border border-outline-variant/50 bg-surface/50 backdrop-blur-sm text-on-surface font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all hover:bg-surface">
                        @foreach($namaBulanList as $num => $nama)
                            <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5 flex-1 min-w-[100px]">
                    <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Tahun</label>
                    <select name="tahun" id="tahun"
                        class="w-full px-4 py-3 rounded-xl border border-outline-variant/50 bg-surface/50 backdrop-blur-sm text-on-surface font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all hover:bg-surface">
                        @foreach($tahunTersedia as $y)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" id="btn-filter"
                    class="h-[46px] px-6 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md shadow-primary/25 hover:shadow-lg hover:-translate-y-0.5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                    Terapkan
                </button>
            </form>
        </div>

        {{-- Download Card --}}
        <div class="bg-gradient-to-br from-[#1a1c23] to-[#2d303b] rounded-3xl p-6 shadow-xl shadow-gray-900/10 border border-white/10 lg:w-[480px] relative overflow-hidden group text-white">
            <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-primary/30 rounded-full blur-3xl transition-all duration-700 group-hover:bg-primary/40 group-hover:scale-110"></div>
            <h2 class="text-base font-headline font-bold text-white mb-1 flex items-center gap-2 relative z-10">
                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm">
                    <span class="material-symbols-outlined text-lg">download</span>
                </div>
                Unduh Laporan
            </h2>
            <p class="text-[13px] text-gray-300 mb-5 relative z-10 leading-relaxed">
                Periode <strong class="text-white">{{ $namaBulanList[$bulan] }} {{ $tahun }}</strong> siap diunduh.
            </p>
            <div class="flex flex-wrap gap-3 relative z-10">
                {{-- PDF --}}
                <a href="{{ route('bendahara.laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                   class="flex-1 min-w-[160px] inline-flex items-center gap-3 px-4 py-3 bg-white/10 hover:bg-red-500 border border-white/10 hover:border-red-500 rounded-2xl font-bold text-sm transition-all duration-300 hover:shadow-lg hover:shadow-red-500/30 group/btn">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover/btn:scale-110 group-hover/btn:bg-white/20 transition-all">
                        <span class="material-symbols-outlined text-[22px] text-red-400 group-hover/btn:text-white transition-colors">picture_as_pdf</span>
                    </div>
                    <div class="text-left leading-tight">
                        <div class="text-white">PDF</div>
                        <div class="text-[10px] font-medium text-gray-400 group-hover/btn:text-white/80 transition-colors mt-0.5 tracking-wide">Format A4</div>
                    </div>
                </a>

                {{-- Excel --}}
                <a href="{{ route('bendahara.laporan.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                   class="flex-1 min-w-[160px] inline-flex items-center gap-3 px-4 py-3 bg-white/10 hover:bg-emerald-500 border border-white/10 hover:border-emerald-500 rounded-2xl font-bold text-sm transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/30 group/btn">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover/btn:scale-110 group-hover/btn:bg-white/20 transition-all">
                        <span class="material-symbols-outlined text-[22px] text-emerald-400 group-hover/btn:text-white transition-colors">table_view</span>
                    </div>
                    <div class="text-left leading-tight">
                        <div class="text-white">Excel</div>
                        <div class="text-[10px] font-medium text-gray-400 group-hover/btn:text-white/80 transition-colors mt-0.5 tracking-wide">Format .xlsx</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in fade-in-3">
        {{-- Total Masuk --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/20 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl -mr-4 -mt-4 transition-all duration-500 group-hover:bg-emerald-500/10"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Total Pemasukan</p>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100/50">
                    <span class="material-symbols-outlined text-[20px]">south_west</span>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-3xl font-headline font-extrabold text-emerald-600 mb-1 tracking-tight">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                <p class="text-[13px] text-on-surface-variant font-medium flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ $kasMasuk->count() }} transaksi
                </p>
            </div>
        </div>

        {{-- Total Keluar --}}
        <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/20 hover:border-red-300 hover:shadow-lg hover:shadow-red-500/5 transition-all duration-300 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-full blur-2xl -mr-4 -mt-4 transition-all duration-500 group-hover:bg-red-500/10"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Total Pengeluaran</p>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center border border-red-100/50">
                    <span class="material-symbols-outlined text-[20px]">north_east</span>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-3xl font-headline font-extrabold text-red-600 mb-1 tracking-tight">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
                <p class="text-[13px] text-on-surface-variant font-medium flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    {{ $kasKeluar->count() }} transaksi
                </p>
            </div>
        </div>

        {{-- Saldo Bersih --}}
        @php $isPositif = $saldoBersih >= 0; @endphp
        <div class="rounded-3xl p-6 shadow-xl transition-all duration-500 relative overflow-hidden group
            {{ $isPositif ? 'bg-gradient-to-br from-primary to-blue-800 text-white shadow-primary/30 border-blue-600/50' : 'bg-gradient-to-br from-red-600 to-red-800 text-white shadow-red-600/30 border-red-500/50' }} border">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[11px] font-bold uppercase tracking-wider text-white/80">Saldo Bersih</p>
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/20 shadow-inner">
                    <span class="material-symbols-outlined text-[20px]">{{ $isPositif ? 'account_balance_wallet' : 'warning' }}</span>
                </div>
            </div>
            <div class="relative z-10">
                <h3 class="text-3xl font-headline font-extrabold text-white mb-1 tracking-tight drop-shadow-md">
                    {{ $isPositif ? '+' : '-' }} Rp {{ number_format(abs($saldoBersih), 0, ',', '.') }}
                </h3>
                <p class="text-[13px] text-white/80 font-medium flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">{{ $isPositif ? 'trending_up' : 'trending_down' }}</span>
                    {{ $isPositif ? 'Surplus' : 'Defisit' }} periode ini
                </p>
            </div>
        </div>
    </div>

    {{-- Preview Data --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in fade-in-4">

        {{-- Tabel Kas Masuk --}}
        <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/20 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-300 overflow-hidden">
            <div class="bg-green-50 border-b border-green-100 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-700">south_west</span>
                    <h3 class="font-headline font-bold text-green-800 text-sm">Kas Masuk</h3>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full">
                    {{ $kasMasuk->count() }} transaksi
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs text-on-surface-variant uppercase tracking-wider border-b border-outline-variant/20">
                            <th class="px-5 py-3 font-bold">Tanggal</th>
                            <th class="px-5 py-3 font-bold">Keterangan</th>
                            <th class="px-5 py-3 font-bold text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($kasMasuk as $km)
                            <tr class="hover:bg-green-50/50 transition-colors">
                                <td class="px-5 py-3 text-xs text-on-surface-variant whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($km->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3 font-medium max-w-[160px] truncate">{{ $km->keterangan }}</td>
                                <td class="px-5 py-3 text-right font-bold text-green-700 whitespace-nowrap">
                                    Rp {{ number_format($km->jumlah, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-on-surface-variant text-xs">
                                    Tidak ada data kas masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($kasMasuk->isNotEmpty())
                    <tfoot>
                        <tr class="bg-green-50 border-t-2 border-green-200">
                            <td colspan="2" class="px-5 py-3 font-bold text-green-800 text-xs uppercase">Total</td>
                            <td class="px-5 py-3 font-extrabold text-green-700 text-right whitespace-nowrap">
                                Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        {{-- Tabel Kas Keluar --}}
        <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/20 hover:border-red-300 hover:shadow-lg hover:shadow-red-500/5 transition-all duration-300 overflow-hidden">
            <div class="bg-red-50 border-b border-red-100 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-error">north_east</span>
                    <h3 class="font-headline font-bold text-red-800 text-sm">Kas Keluar</h3>
                </div>
                <span class="text-xs font-bold text-error bg-error-container px-3 py-1 rounded-full">
                    {{ $kasKeluar->count() }} transaksi
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs text-on-surface-variant uppercase tracking-wider border-b border-outline-variant/20">
                            <th class="px-5 py-3 font-bold">Tanggal</th>
                            <th class="px-5 py-3 font-bold">Keterangan</th>
                            <th class="px-5 py-3 font-bold text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($kasKeluar as $kk)
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="px-5 py-3 text-xs text-on-surface-variant whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($kk->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-5 py-3 font-medium max-w-[160px] truncate">{{ $kk->keterangan }}</td>
                                <td class="px-5 py-3 text-right font-bold text-error whitespace-nowrap">
                                    Rp {{ number_format($kk->nominal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-on-surface-variant text-xs">
                                    Tidak ada data kas keluar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($kasKeluar->isNotEmpty())
                    <tfoot>
                        <tr class="bg-red-50 border-t-2 border-red-200">
                            <td colspan="2" class="px-5 py-3 font-bold text-red-800 text-xs uppercase">Total</td>
                            <td class="px-5 py-3 font-extrabold text-error text-right whitespace-nowrap">
                                Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
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
