<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Pembayaran Kas — MONET</title>
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

{{-- Navigation --}}
<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-8">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
<div class="flex items-center gap-3">
    @if(Auth::user()->avatar)
        @php
            $av = Auth::user()->avatar;
            $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
        @endphp
        <div class="hidden sm:block text-right">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="Profile" referrerpolicy="no-referrer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="w-10 h-10 rounded-full object-cover bg-surface-container-high border border-outline-variant/30 text-on-surface-variant font-bold flex items-center justify-center hidden" style="display:none;">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    @else
        <div class="hidden sm:block text-right">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    @endif
</div>
</nav>

{{-- Sidebar --}}
@include('components.sidebar-' . Auth::user()->role)

{{-- Main Content --}}
<main class="ml-64 pt-20 p-8 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <div class="flex items-center gap-2 text-sm text-on-surface-variant font-medium mb-1">
                <a href="{{ route(Auth::user()->role === 'anggota' ? 'user.dashboard' : Auth::user()->role . '.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-semibold">Pembayaran Kas</span>
            </div>
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Pembayaran Kas {{ ucfirst(Auth::user()->role) }}</h1>
            <p class="text-on-surface-variant font-body mt-1">Lakukan scan QRIS Bisnis DANA untuk membayar kas bulanan dan unggah bukti transfer.</p>
        </div>
    </header>
    

    {{-- Notification Container --}}
    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container rounded-3xl border border-error/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-error">error</span>
            <p class="text-on-error-container text-sm font-semibold">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 rounded-3xl border border-green-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-green-700">check_circle</span>
            <p class="text-green-800 text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        
        {{-- Left: Billing Periods & Selection --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/30">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-headline font-bold text-on-surface">Status Iuran Bulanan</h2>
                        <p class="text-xs text-on-surface-variant mt-1">Pilih periode yang ingin dibayar pada daftar di bawah.</p>
                    </div>
                    <form method="GET" action="{{ route(Auth::user()->role . '.pembayaran.index') }}" class="flex flex-wrap md:flex-nowrap gap-3 w-full">
                        <select name="billing_tahun" onchange="this.form.submit()" class="rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-xs font-semibold bg-white shadow-sm pr-8">
                            @foreach ($yearsList as $yr)
                                <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                {{-- Dues Grid --}}
                @if(count($billings) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($billings as $billing)
                            <div class="bg-surface rounded-2xl p-4 border border-outline-variant/20 flex flex-col justify-between hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                                <div>
                                    <p class="font-bold text-on-surface text-sm">{{ $billing['periode_label'] }}</p>
                                    <p class="text-xs text-on-surface-variant font-semibold mt-0.5">Rp {{ number_format($billing['nominal'], 0, ',', '.') }}</p>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4 pt-3 border-t border-outline-variant/10">
                                    {{-- Status Badge --}}
                                    @if ($billing['status'] === 'Lunas')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Lunas
                                        </span>
                                    @elseif ($billing['status'] === 'Menunggu Verifikasi')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-850 border border-yellow-250" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: #ffc107"></span> Menunggu Verifikasi
                                        </span>
                                    @elseif ($billing['status'] === 'Ditolak')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-650"></span> Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-150 text-gray-700 border border-gray-250" style="background-color: #e9ecef; border-color: #dee2e6;">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Belum Bayar
                                        </span>
                                    @endif

                                    {{-- Quick Action Button --}}
                                    @if ($billing['status'] === 'Belum Bayar' || $billing['status'] === 'Ditolak')
                                        <button type="button" onclick="selectPeriod('{{ $billing['id'] }}', '{{ $billing['periode_label'] }}')" class="text-primary hover:text-primary-container text-xs font-bold flex items-center gap-0.5 transition-colors">
                                            Bayar <span class="material-symbols-outlined text-sm font-semibold">arrow_forward</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center bg-surface-container-lowest rounded-2xl border border-dashed border-outline-variant/40">
                        <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">check_circle</span>
                        <h3 class="text-lg font-headline font-bold text-on-surface">Belum ada tagihan pembayaran</h3>
                        <p class="text-sm text-on-surface-variant max-w-sm mt-2">Saat ini Anda tidak memiliki tagihan pembayaran kas untuk tahun ini. Silakan cek kembali nanti atau hubungi bendahara.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right: QRIS & Upload Proof Form --}}
        <div class="lg:col-span-1">
            <div id="payment-card" class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-6 sticky top-20">
                <div class="border-b border-outline-variant/20 pb-4">
                    <h2 class="text-xl font-headline font-bold text-on-surface">Form Pembayaran</h2>
                    <p class="text-xs text-on-surface-variant mt-1" id="active-period-desc">Pilih iuran bulanan untuk mulai membayar.</p>
                </div>

                {{-- QRIS Section --}}
                <div class="flex flex-col items-center p-4 bg-surface rounded-2xl border border-outline-variant/20 relative group">
                    <p class="text-xs font-bold text-outline uppercase tracking-wider mb-2">QRIS Bisnis DANA</p>
                    <div class="w-48 h-auto overflow-hidden rounded-xl border border-outline-variant/30 shadow-inner bg-white p-2">
                        <img src="{{ asset('images/qris.jpg') }}" alt="QRIS DANA" class="w-full h-auto object-contain cursor-zoom-in" onclick="openImageModal('{{ asset('images/qris.jpg') }}', 'QRIS Bisnis DANA Monet')"/>
                    </div>
                    <p class="text-[10px] text-on-surface-variant font-medium text-center mt-3">Silakan scan kode QRIS diatas dengan nominal pembayaran <span class="font-bold text-primary">Rp 5.000</span></p>
                </div>

                {{-- Upload Form --}}
                <form id="form-upload-pembayaran" action="{{ route(Auth::user()->role . '.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    
                    {{-- Selected Period --}}
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase tracking-wider">Periode Kas</label>
                        <select name="pembayaran_id" id="input-periode" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm font-semibold bg-surface shadow-sm">
                            <option value="">-- Pilih Tagihan --</option>
                            @foreach ($billings as $billing)
                                @if ($billing['status'] === 'Belum Bayar' || $billing['status'] === 'Ditolak')
                                    <option value="{{ $billing['id'] }}">{{ $billing['periode_label'] }} (Rp {{ number_format($billing['nominal'], 0, ',', '.') }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Proof file --}}
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase tracking-wider">Bukti Pembayaran (Screenshot)</label>
                        <div id="drop-area" class="border-2 border-dashed border-outline-variant/50 hover:border-primary rounded-xl p-4 flex flex-col items-center justify-center bg-surface cursor-pointer transition-all">
                            <input type="file" name="bukti_pembayaran" id="input-file" accept="image/png, image/jpeg, image/jpg" class="hidden">
                            <span class="material-symbols-outlined text-4xl text-outline mb-1">upload_file</span>
                            <p class="text-xs font-bold text-on-surface-variant text-center" id="file-label-text">Tarik & lepas gambar atau klik disini</p>
                            <p class="text-[10px] text-outline text-center mt-1">PNG, JPG, JPEG (Maks. 2MB)</p>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase tracking-wider">Catatan Pembayaran (Opsional)</label>
                        <textarea name="catatan" id="input-catatan" rows="3" placeholder="Masukkan catatan tambahan jika diperlukan..." class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm bg-surface shadow-sm"></textarea>
                    </div>

                    {{-- Upload Progress --}}
                    <div id="upload-progress-container" class="hidden">
                        <div class="flex justify-between items-center text-xs font-semibold text-on-surface-variant mb-1">
                            <span>Mengunggah...</span>
                            <span id="progress-percent">0%</span>
                        </div>
                        <div class="w-full bg-surface-container-high rounded-full h-2 overflow-hidden shadow-inner">
                            <div id="progress-bar" class="bg-primary h-2 rounded-full transition-all duration-100" style="width: 0%"></div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="btn-submit" class="w-full py-3 px-4 bg-primary hover:bg-primary-container text-white font-bold text-sm rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">cloud_upload</span>
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bottom: History list --}}
    <div class="bg-surface-container-lowest rounded-3xl p-6 shadow-sm border border-outline-variant/30">
        <div class="flex flex-col gap-6">
            <div class="border-b border-outline-variant/20 pb-4">
                <h2 class="text-xl font-headline font-bold text-on-surface">Riwayat Pembayaran Kas Anda</h2>
                <p class="text-xs text-on-surface-variant mt-1">Berikut adalah daftar seluruh bukti pembayaran yang telah Anda unggah.</p>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route(Auth::user()->role . '.pembayaran.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 p-4 bg-surface rounded-2xl border border-outline-variant/20">
                {{-- Preserve billing year --}}
                <input type="hidden" name="billing_tahun" value="{{ $selectedYear }}"/>
                
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase tracking-wider">Filter Bulan</label>
                    <select name="bulan" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-xs font-semibold bg-white shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Bulan</option>
                        @foreach ($monthsList as $num => $name)
                            <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase tracking-wider">Filter Tahun</label>
                    <select name="tahun" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-xs font-semibold bg-white shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach ($yearsList as $yr)
                            <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant mb-1 uppercase tracking-wider">Filter Status</label>
                    <select name="status" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-xs font-semibold bg-white shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Verifikasi" {{ request('status') === 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <a href="{{ route(Auth::user()->role . '.pembayaran.index', ['billing_tahun' => $selectedYear]) }}" class="w-full py-2.5 px-4 bg-surface-container hover:bg-surface-container-high border border-outline-variant/40 text-on-surface text-xs font-bold rounded-xl transition-all text-center flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-sm font-semibold">restart_alt</span>
                        Reset Filter
                    </a>
                </div>
            </form>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-outline-variant/30 text-xs font-bold text-on-surface-variant uppercase tracking-wider">
                            <th class="pb-3 pl-4">Tanggal Pembayaran</th>
                            <th class="pb-3">Periode Kas</th>
                            <th class="pb-3">Nominal</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Catatan Pembayaran</th>
                            <th class="pb-3 text-center pr-4">Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($riwayat as $item)
                            <tr class="border-b border-outline-variant/10 hover:bg-surface transition-colors">
                                <td class="py-4 pl-4 font-medium text-on-surface">
                                    {{ $item->created_at->translatedFormat('d F Y H:i') }}
                                </td>
                                <td class="py-4 font-semibold text-primary">
                                    @php
                                        $pParts = explode('-', $item->periode);
                                        $pYear = $pParts[0];
                                        $pMonthNum = (int)$pParts[1];
                                        $pMonthName = $monthsList[$pMonthNum] ?? '';
                                    @endphp
                                    {{ $pMonthName }} {{ $pYear }}
                                </td>
                                <td class="py-4 font-bold">
                                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                </td>
                                <td class="py-4">
                                    @if ($item->status === 'Lunas')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Lunas
                                        </span>
                                    @elseif ($item->status === 'Menunggu Verifikasi')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-850 border border-yellow-250" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: #ffc107"></span> Menunggu Verifikasi
                                        </span>
                                    @elseif ($item->status === 'Ditolak')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-655"></span> Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-800 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> {{ $item->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-xs max-w-xs truncate text-on-surface-variant font-medium" title="{{ $item->catatan }}">
                                    {{ $item->catatan ?? '-' }}
                                </td>
                                <td class="py-4 text-center pr-4">
                                    <button onclick="openImageModal('{{ asset('storage/' . $item->bukti_pembayaran) }}', 'Bukti Transfer Periode {{ $pMonthName }} {{ $pYear }}')" class="p-2 bg-surface-container hover:bg-surface-container-high rounded-xl text-primary transition-all inline-flex items-center justify-center shadow-inner">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-on-surface-variant font-medium">
                                    Belum ada riwayat pembayaran yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $riwayat->appends(request()->query())->links() }}
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

{{-- Lightbox Image Modal --}}
<div id="image-modal" class="fixed inset-0 z-[110] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeImageModal()"></div>
    <div class="bg-white p-4 rounded-3xl max-w-lg w-full max-h-[85vh] relative z-10 overflow-hidden flex flex-col items-center shadow-2xl mx-4 transform scale-95 transition-transform duration-300">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 bg-surface hover:bg-surface-container-high text-on-surface rounded-full p-2 flex items-center justify-center transition-colors border border-outline-variant/20 shadow-sm z-20">
            <span class="material-symbols-outlined text-lg font-bold">close</span>
        </button>
        <div class="w-full overflow-y-auto flex justify-center items-center p-2 mt-8">
            <img id="modal-img" src="" class="max-w-full max-h-[60vh] object-contain rounded-2xl shadow-inner border border-outline-variant/20" alt="Bukti Transfer">
        </div>
        <p id="modal-caption" class="text-sm font-extrabold mt-4 text-center text-on-surface"></p>
    </div>
</div>

{{-- Live Toast notification --}}
<div id="toast-container" class="fixed bottom-6 right-6 z-[200] flex flex-col gap-3 max-w-sm w-full pointer-events-none"></div>

<script>
    // Logout Modal Logic
    const logoutModal = document.getElementById('logout-modal');
    const logoutModalContent = logoutModal.querySelector('div.bg-surface-container-lowest');

    function showLogoutModal() {
        logoutModal.classList.remove('hidden');
        setTimeout(() => {
            logoutModal.classList.remove('opacity-0');
            logoutModalContent.classList.remove('scale-95');
            logoutModalContent.classList.add('scale-100');
        }, 10);
    }

    function hideLogoutModal() {
        logoutModal.classList.add('opacity-0');
        logoutModalContent.classList.remove('scale-100');
        logoutModalContent.classList.add('scale-95');
        setTimeout(() => {
            logoutModal.classList.add('hidden');
        }, 300);
    }

    // Lightbox Image Modal Logic
    const imageModal = document.getElementById('image-modal');
    const imageModalContent = imageModal.querySelector('div.bg-white');
    const modalImg = document.getElementById('modal-img');
    const modalCaption = document.getElementById('modal-caption');

    function openImageModal(imgSrc, captionText) {
        modalImg.src = imgSrc;
        modalCaption.textContent = captionText;
        imageModal.classList.remove('hidden');
        setTimeout(() => {
            imageModal.classList.remove('opacity-0');
            imageModalContent.classList.remove('scale-95');
            imageModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeImageModal() {
        imageModal.classList.add('opacity-0');
        imageModalContent.classList.remove('scale-100');
        imageModalContent.classList.add('scale-95');
        setTimeout(() => {
            imageModal.classList.add('hidden');
        }, 300);
    }

    // Toast Notification system
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 p-4 rounded-2xl shadow-xl border text-sm font-semibold pointer-events-auto transform translate-y-2 opacity-0 transition-all duration-350 bg-white ${
            type === 'success' 
            ? 'text-green-800 border-green-200 shadow-green-150/10' 
            : 'text-error border-error-container shadow-error/10'
        }`;
        
        const iconName = type === 'success' ? 'check_circle' : 'error';
        const iconColor = type === 'success' ? 'text-green-600' : 'text-error';

        toast.innerHTML = `
            <span class="material-symbols-outlined ${iconColor}">${iconName}</span>
            <div class="flex-1">${message}</div>
        `;
        
        container.appendChild(toast);
        
        // Trigger show animation
        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-1');
            setTimeout(() => {
                toast.remove();
            }, 350);
        }, 4000);
    }

    // Quick selection of period from the grid list
    function selectPeriod(periodCode, periodLabel) {
        const periodSelect = document.getElementById('input-periode');
        
        // Try finding the option
        let found = false;
        for (let i = 0; i < periodSelect.options.length; i++) {
            if (periodSelect.options[i].value === periodCode) {
                periodSelect.selectedIndex = i;
                found = true;
                break;
            }
        }
        
        if (!found) {
            showToast('Periode ini sudah lunas atau dalam proses verifikasi.', 'error');
            return;
        }

        // Highlight payment card and scroll to it
        const card = document.getElementById('payment-card');
        card.classList.add('ring-4', 'ring-primary/20', 'transition-all');
        setTimeout(() => {
            card.classList.remove('ring-4', 'ring-primary/20');
        }, 1500);

        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        const desc = document.getElementById('active-period-desc');
        desc.innerHTML = `Periode yang dipilih: <span class="font-extrabold text-primary">${periodLabel}</span>`;
    }

    // Sync select period description text
    document.getElementById('input-periode').addEventListener('change', function() {
        const desc = document.getElementById('active-period-desc');
        if (this.value) {
            const selectedText = this.options[this.selectedIndex].text.split(' (')[0];
            desc.innerHTML = `Periode yang dipilih: <span class="font-extrabold text-primary">${selectedText}</span>`;
        } else {
            desc.textContent = 'Pilih iuran bulanan untuk mulai membayar.';
        }
    });

    // Drag and Drop & File Input Setup
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('input-file');
    const fileLabelText = document.getElementById('file-label-text');

    dropArea.addEventListener('click', () => fileInput.click());

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('border-primary', 'bg-primary-container/10');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('border-primary', 'bg-primary-container/10');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('border-primary', 'bg-primary-container/10');
        
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            updateFileLabel();
        }
    });

    fileInput.addEventListener('change', updateFileLabel);

    function updateFileLabel() {
        if (fileInput.files.length) {
            const file = fileInput.files[0];
            fileLabelText.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
            dropArea.classList.add('border-primary', 'bg-primary-container/5');
        } else {
            fileLabelText.textContent = 'Tarik & lepas gambar atau klik disini';
            dropArea.classList.remove('border-primary', 'bg-primary-container/5');
        }
    }

    // AJAX Form Upload with Progress Bar and Loading Spinner
    const form = document.getElementById('form-upload-pembayaran');
    const progressContainer = document.getElementById('upload-progress-container');
    const progressBar = document.getElementById('progress-bar');
    const progressPercent = document.getElementById('progress-percent');
    const btnSubmit = document.getElementById('btn-submit');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const periodVal = document.getElementById('input-periode').value;
        const fileVal = fileInput.files[0];

        // Validations
        if (!periodVal) {
            showToast('Silakan pilih periode kas terlebih dahulu.', 'error');
            return;
        }
        if (!fileVal) {
            showToast('Silakan unggah screenshot bukti pembayaran.', 'error');
            return;
        }

        // File validation (jpg/png/jpeg, max 2MB)
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(fileVal.type)) {
            showToast('Format bukti pembayaran harus berupa JPG, JPEG, atau PNG.', 'error');
            return;
        }
        if (fileVal.size > 2 * 1024 * 1024) {
            showToast('Ukuran file maksimal adalah 2MB.', 'error');
            return;
        }

        // Prepare AJAX request
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        // Disable button & show progress
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Mengirim Data...
        `;
        progressContainer.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressPercent.textContent = '0%';

        // Track upload progress
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressPercent.textContent = percent + '%';
            }
        });

        // Response handling
        xhr.onload = function() {
            let res = {};
            try {
                res = JSON.parse(xhr.responseText);
            } catch (e) {
                res = { success: false, message: 'Terjadi kesalahan sistem.' };
            }

            if (xhr.status >= 200 && xhr.status < 300 && res.success) {
                showToast(res.message || 'Bukti pembayaran berhasil diunggah.', 'success');
                form.reset();
                updateFileLabel();
                progressContainer.classList.add('hidden');
                
                // Reload page after a delay to reflect update
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showToast(res.message || 'Gagal mengunggah bukti pembayaran.', 'error');
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = `
                    <span class="material-symbols-outlined text-lg">cloud_upload</span>
                    Kirim Bukti Pembayaran
                `;
                progressContainer.classList.add('hidden');
            }
        };

        xhr.onerror = function() {
            showToast('Terjadi kesalahan jaringan.', 'error');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = `
                <span class="material-symbols-outlined text-lg">cloud_upload</span>
                Kirim Bukti Pembayaran
            `;
            progressContainer.classList.add('hidden');
        };

        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
</script>
</body>
</html>
