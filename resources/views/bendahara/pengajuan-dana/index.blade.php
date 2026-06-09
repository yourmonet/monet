<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Persetujuan Pengajuan Dana - MONET</title>
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
                    "primary-fixed": "#dae2ff", "error": "#ba1a1a",
                    "success": "#198754", "success-container": "#d1e7dd", "on-success-container": "#0f5132"
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

<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-4 md:px-8 h-16 font-headline antialiased border-b border-outline-variant/30">
    <div class="flex items-center gap-4 md:gap-8">
        <button onclick="toggleSidebar()" class="md:hidden mr-2 text-on-surface hover:text-primary transition-colors flex items-center"><span class="material-symbols-outlined text-[28px]">menu</span></button>
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-primary leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5">{{ Auth::user()->role ?? 'Bendahara' }}</div>
        </div>
        @if(Auth::user()->avatar)
            @php
                $av = Auth::user()->avatar;
                $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
            @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm border border-outline-variant/30" alt="Profile" referrerpolicy="no-referrer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
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

<main class="md:ml-64 p-4 pt-20 md:p-8 md:pt-20 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Persetujuan Pengajuan Dana</h1>
            <p class="text-on-surface-variant font-body mt-1">Verifikasi, tinjau, dan setujui pengajuan bantuan/dana organisasi secara transparan.</p>
        </div>
        <div>
            <a href="{{ route('bendahara.pengajuan-dana.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-2xl text-sm font-bold hover:bg-primary/95 transition shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-lg">add</span>
                Buat Pengajuan Saya
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-success-container rounded-3xl border border-success/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-success">check_circle</span>
            <p class="text-on-success-container text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container rounded-3xl border border-error/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-error">error</span>
            <p class="text-on-error-container text-sm font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    {{-- 1. DASHBOARD APPROVAL --}}
    @if(Auth::user()->role === 'bendahara')
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/30 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">description</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant font-medium">Total Pengajuan</p>
                <h4 class="text-lg font-bold text-on-surface">{{ $totalPengajuan }}</h4>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/30 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #fff3cd; color: #856404;">
                <span class="material-symbols-outlined text-xl">hourglass_empty</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant font-medium">Pending</p>
                <h4 class="text-lg font-bold" style="color: #856404;">{{ $pendingCount }}</h4>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/30 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #d1e7dd; color: #0f5132;">
                <span class="material-symbols-outlined text-xl">check_circle</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant font-medium">Disetujui</p>
                <h4 class="text-lg font-bold" style="color: #0f5132;">{{ $approvedCount }}</h4>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/30 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #ffdad6; color: #93000a;">
                <span class="material-symbols-outlined text-xl">cancel</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant font-medium">Ditolak</p>
                <h4 class="text-lg font-bold" style="color: #93000a;">{{ $rejectedCount }}</h4>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/30 flex items-center gap-3">
            <div class="w-10 h-10 bg-primary/20 text-primary rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">payments</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant font-medium">Dana Disetujui</p>
                <h4 class="text-lg font-bold text-primary">Rp {{ number_format($totalDanaDisetujui, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    @endif

    {{-- Tabs --}}
    <div class="flex border-b border-outline-variant/30 mb-6 gap-6">
        @if(Auth::user()->role === 'bendahara')
        <button onclick="switchTab('all')" id="tab-all-btn" class="py-3 px-1 border-b-2 border-primary text-primary font-bold text-sm transition-all">
            Semua Pengajuan Anggota
        </button>
        <button onclick="switchTab('my')" id="tab-my-btn" class="py-3 px-1 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-semibold text-sm transition-all">
            Pengajuan Saya
        </button>
        @else
        <button id="tab-my-btn" class="py-3 px-1 border-b-2 border-primary text-primary font-bold text-sm transition-all">
            Pengajuan Saya
        </button>
        @endif
    </div>

    {{-- 2. DAFTAR PENGAJUAN (Tab content 1: Semua Pengajuan) --}}
    @if(Auth::user()->role === 'bendahara')
    <div id="tab-all" class="space-y-6">
        {{-- Filters & Export --}}
        <div class="bg-surface-container-lowest p-6 rounded-3xl border border-outline-variant/30 shadow-sm">
            <form action="{{ route('bendahara.pengajuan-dana.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="search" class="block text-xs font-bold text-on-surface-variant mb-2">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ $search }}" placeholder="Nama pemohon atau jenis..." class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary/20 text-sm py-2 px-3">
                </div>
                <div>
                    <label for="status" class="block text-xs font-bold text-on-surface-variant mb-2">Status</label>
                    <select name="status" id="status" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary/20 text-sm py-2 px-3">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ $status === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ $status === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal_mulai" class="block text-xs font-bold text-on-surface-variant mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ $tglMulai }}" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary/20 text-sm py-2 px-3">
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-xs font-bold text-on-surface-variant mb-2">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ $tglSelesai }}" class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary/20 text-sm py-2 px-3">
                </div>
                <div class="md:col-span-4 flex justify-between items-center mt-2">
                    <div class="flex gap-2">
                        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-primary/90 transition shadow-sm">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('bendahara.pengajuan-dana.index') }}" class="bg-surface-container text-on-surface px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-surface-container-high transition">
                            Reset
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('bendahara.pengajuan-dana.pdf', request()->query()) }}" class="inline-flex items-center gap-1.5 bg-error/10 text-error px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-error hover:text-white transition">
                            <span class="material-symbols-outlined text-sm">picture_as_pdf</span> PDF
                        </a>
                        <a href="{{ route('bendahara.pengajuan-dana.excel', request()->query()) }}" class="inline-flex items-center gap-1.5 bg-success/10 text-success px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-success hover:text-white transition">
                            <span class="material-symbols-outlined text-sm">table_view</span> Excel
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-surface-container border-b border-outline-variant/30 text-on-surface-variant uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Pemohon</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Tgl Pengajuan</th>
                            <th class="px-6 py-4">Jenis Pengajuan</th>
                            <th class="px-6 py-4 text-right">Nominal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Approval By</th>
                            <th class="px-6 py-4">Approval Date</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse ($allPengajuan as $item)
                            <tr class="hover:bg-surface/50 transition-colors cursor-pointer" onclick="openDetailModal('{{ $item->id }}')">
                                <td class="px-6 py-4 font-bold text-on-surface">
                                    <div class="flex items-center gap-3">
                                        @if($item->user->avatar)
                                            @php
                                                $av = $item->user->avatar;
                                                $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
                                            @endphp
                                            <img src="{{ $avatarUrl }}" class="w-8 h-8 rounded-full object-cover" alt="Avatar">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="leading-none">{{ $item->user->name }}</p>
                                            <span class="text-[10px] text-outline-variant font-medium lowercase">{{ $item->user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-on-surface-variant capitalize">
                                    {{ $item->user->role }}
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant font-medium">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-on-surface">
                                    {{ $item->jenis_pengajuan }}
                                </td>
                                <td class="px-6 py-4 text-right font-extrabold text-primary">
                                    Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                                    @if ($item->status === 'Disetujui')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-success-container/70 text-on-success-container border border-success/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                            APPROVED
                                        </span>
                                    @elseif ($item->status === 'Ditolak')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-error-container/70 text-on-error-container border border-error/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                            REJECTED
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-850 border border-yellow-250" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: #ffc107"></span>
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant">
                                    @if($item->status === 'Disetujui')
                                        {{ $item->approvedBy ? $item->approvedBy->name : '-' }}
                                    @elseif($item->status === 'Ditolak')
                                        {{ $item->rejectedBy ? $item->rejectedBy->name : '-' }}
                                    @else
                                        <span class="text-outline-variant">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant">
                                    @if($item->status === 'Disetujui')
                                        {{ $item->approved_at ? \Carbon\Carbon::parse($item->approved_at)->format('d/m/Y H:i') : '-' }}
                                    @elseif($item->status === 'Ditolak')
                                        {{ $item->rejected_at ? \Carbon\Carbon::parse($item->rejected_at)->format('d/m/Y H:i') : '-' }}
                                    @else
                                        <span class="text-outline-variant">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                                    @if ($item->status === 'Pending')
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="triggerApprove('{{ $item->id }}', '{{ $item->user->name }}', '{{ number_format($item->jumlah_dana, 0, ',', '.') }}', '{{ $item->jenis_pengajuan }}')" class="px-3 py-1.5 bg-success/10 hover:bg-success text-success hover:text-white rounded-lg text-xs font-bold transition">
                                                Setujui
                                            </button>
                                            <button onclick="triggerReject('{{ $item->id }}')" class="px-3 py-1.5 bg-error/10 hover:bg-error text-error hover:text-white rounded-lg text-xs font-bold transition">
                                                Tolak
                                            </button>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-surface-container text-on-surface-variant border border-outline-variant/20">
                                            Sudah Diproses
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl mb-3 text-outline-variant">inbox</span>
                                        <p class="font-medium">Belum ada pengajuan dana dari anggota.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-outline-variant/30">
                {{ $allPengajuan->appends(request()->except('page_all'))->links() }}
            </div>
        </div>
    </div>
    @endif

    {{-- Tab content 2: Pengajuan Saya --}}
    <div id="tab-my" class="space-y-6 {{ Auth::user()->role === 'bendahara' ? 'hidden' : '' }}">
        <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-surface-container border-b border-outline-variant/30 text-on-surface-variant uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Tgl Pengajuan</th>
                            <th class="px-6 py-4">Jenis Pengajuan</th>
                            <th class="px-6 py-4 text-right">Jumlah Dana</th>
                            <th class="px-6 py-4">Kontak & Rekening</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Catatan / Alasan</th>
                            <th class="px-6 py-4 text-center">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse ($myPengajuan as $item)
                            <tr class="hover:bg-surface/50 transition-colors cursor-pointer" onclick="openDetailModal('{{ $item->id }}')">
                                <td class="px-6 py-4 font-medium text-on-surface-variant">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-on-surface">
                                    {{ $item->jenis_pengajuan }}
                                </td>
                                <td class="px-6 py-4 text-right font-extrabold text-primary">
                                    Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <div class="font-bold text-on-surface">{{ $item->no_telp }}</div>
                                    <div class="text-on-surface-variant mt-0.5">{{ $item->nama_bank }} - {{ $item->no_rekening }}</div>
                                    <div class="text-outline text-[10px] italic">a.n. {{ $item->nama_rekening }}</div>
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant max-w-xs truncate" title="{{ $item->keterangan }}">
                                    {{ $item->keterangan }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($item->status === 'Disetujui')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-success-container/70 text-on-success-container border border-success/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                            APPROVED
                                        </span>
                                    @elseif ($item->status === 'Ditolak')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-error-container/70 text-on-error-container border border-error/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                            REJECTED
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-850 border border-yellow-250" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: #ffc107"></span>
                                            PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-on-surface-variant italic max-w-xs truncate">
                                    @if($item->status === 'Disetujui')
                                        {{ $item->approval_note ?: 'Disetujui oleh Bendahara' }}
                                    @elseif($item->status === 'Ditolak')
                                        {{ $item->rejection_reason }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                                    @if ($item->file_pendukung)
                                        <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-primary font-bold hover:underline">
                                            <span class="material-symbols-outlined text-sm">download</span> Unduh
                                        </a>
                                    @else
                                        <span class="text-xs text-outline">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl mb-3 text-outline-variant">inbox</span>
                                        <p class="font-medium">Belum ada pengajuan dana dari Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-outline-variant/30">
                {{ $myPengajuan->appends(request()->except('page_my'))->links() }}
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

{{-- 3. DETAIL PENGAJUAN MODAL --}}
<div id="detail-modal" class="fixed inset-0 z-50 hidden bg-on-surface/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-surface-container-lowest rounded-3xl w-full max-w-2xl mx-4 overflow-hidden shadow-xl transform transition-all flex flex-col max-h-[85vh]">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-xl font-headline font-bold text-on-surface">Detail Pengajuan Dana</h3>
            <button onclick="closeDetailModal()" class="text-on-surface-variant hover:text-error transition">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 space-y-6 overflow-y-auto flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- DATA PEMOHON -->
                <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                    <h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-lg">person</span> DATA PEMOHON
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-on-surface-variant font-medium">Nama Pemohon:</span>
                            <p id="det-nama" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Email:</span>
                            <p id="det-email" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Nomor HP / Kontak:</span>
                            <p id="det-telp" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                    </div>
                </div>

                <!-- DATA REKENING -->
                <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                    <h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-lg">account_balance</span> DATA REKENING
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-on-surface-variant font-medium">Nama Bank:</span>
                            <p id="det-bank" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Nomor Rekening:</span>
                            <p id="det-norek" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Nama Pemilik Rekening:</span>
                            <p id="det-pemilik" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA PENGAJUAN -->
            <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                <h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">payments</span> DATA PENGAJUAN
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-on-surface-variant font-medium">Kategori / Jenis Pengajuan:</span>
                        <p id="det-kategori" class="font-bold text-on-surface mt-0.5">-</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant font-medium">Nominal Pengajuan:</span>
                        <p id="det-nominal" class="text-sm font-black text-primary mt-0.5">Rp -</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-on-surface-variant font-medium">Keterangan:</span>
                        <p id="det-keterangan" class="font-medium text-on-surface mt-0.5 whitespace-pre-line bg-white p-3 rounded-xl border border-outline-variant/10">-</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant font-medium">Tanggal Pengajuan:</span>
                        <p id="det-tanggal" class="font-bold text-on-surface mt-0.5">-</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant font-medium">Lampiran / Dokumen Pendukung:</span>
                        <div id="det-lampiran" class="mt-1">
                            <!-- JS will inject link -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMELINE STATUS -->
            <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                <h4 class="text-sm font-bold text-primary mb-4 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">route</span> TIMELINE STATUS
                </h4>
                <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant/30" id="det-timeline">
                    <!-- Dynamic timeline rows injected by JS -->
                </div>
            </div>
        </div>

        <!-- Action panel at bottom of modal -->
        <div class="px-6 py-4 border-t border-outline-variant/30 flex justify-between items-center bg-surface-container/20">
            <div>
                <span id="det-action-lock-badge" class="hidden inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-surface-container text-on-surface-variant border border-outline-variant/20">
                    Sudah Diproses
                </span>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeDetailModal()" class="py-2 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-xs hover:bg-surface-container transition">
                    Tutup
                </button>
                <div id="det-action-buttons" class="hidden flex gap-2">
                    <button type="button" id="det-btn-approve" class="py-2 px-4 rounded-xl bg-success text-white font-bold text-xs hover:bg-success/90 shadow-md shadow-success/10 transition">
                        Setujui
                    </button>
                    <button type="button" id="det-btn-reject" class="py-2 px-4 rounded-xl bg-error text-white font-bold text-xs hover:bg-error/90 shadow-md shadow-error/10 transition">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 5. MODAL KONFIRMASI APPROVE --}}
<div id="approve-confirm-modal" class="fixed inset-0 z-[60] hidden bg-on-surface/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-surface-container-lowest rounded-3xl w-full max-w-md mx-4 overflow-hidden shadow-xl transform transition-all">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-lg font-headline font-bold text-on-surface">Konfirmasi Persetujuan</h3>
            <button onclick="closeApproveModal()" class="text-on-surface-variant hover:text-error transition">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="approve-form" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div class="p-4 bg-success-container/30 rounded-2xl border border-success/10 text-xs space-y-1.5">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Pemohon:</span>
                        <strong id="app-modal-pemohon" class="text-on-surface">-</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Nominal:</span>
                        <strong id="app-modal-nominal" class="text-success text-sm font-black">-</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Jenis Pengajuan:</span>
                        <strong id="app-modal-jenis" class="text-on-surface">-</strong>
                    </div>
                </div>

                <div>
                    <label for="catatan_approval" class="block text-xs font-bold text-on-surface-variant mb-2">Catatan Approval (Opsional)</label>
                    <textarea id="catatan_approval" name="catatan_pengurus" rows="3" placeholder="Masukkan catatan persetujuan jika diperlukan..." class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary/20 text-xs py-2 px-3"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-outline-variant/30 flex justify-end gap-3 bg-surface-container/20">
                <button type="button" onclick="closeApproveModal()" class="py-2.5 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-xs hover:bg-surface-container transition">
                    Batalkan
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-success text-white font-bold text-xs hover:bg-success/90 shadow-md shadow-success/15 transition">
                    Setujui Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 6. MODAL PENOLAKAN --}}
<div id="reject-reason-modal" class="fixed inset-0 z-[60] hidden bg-on-surface/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-surface-container-lowest rounded-3xl w-full max-w-md mx-4 overflow-hidden shadow-xl transform transition-all">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-lg font-headline font-bold text-on-surface">Alasan Penolakan</h3>
            <button onclick="closeRejectModal()" class="text-on-surface-variant hover:text-error transition">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="reject-form" method="POST" onsubmit="return validateRejectionForm()">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="alasan_penolakan" class="block text-xs font-bold text-on-surface-variant mb-2">Alasan Penolakan (Wajib Diisi)</label>
                    <textarea id="alasan_penolakan" name="catatan_pengurus" rows="4" placeholder="Tulis alasan penolakan secara jelas..." class="w-full rounded-2xl border-outline-variant/50 focus:border-primary focus:ring-primary/20 text-xs py-2 px-3"></textarea>
                    <p id="rejection-error" class="hidden text-error text-[10px] font-bold mt-1">Alasan penolakan tidak boleh kosong!</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-outline-variant/30 flex justify-end gap-3 bg-surface-container/20">
                <button type="button" onclick="closeRejectModal()" class="py-2.5 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-xs hover:bg-surface-container transition">
                    Batal
                </button>
                <button type="submit" class="py-2.5 px-4 rounded-xl bg-error text-white font-bold text-xs hover:bg-error/90 shadow-md shadow-error/15 transition">
                    Tolak Pengajuan
                </button>
            </div>
        </form>
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

    function switchTab(tab) {
        const tabAll = document.getElementById('tab-all');
        const tabMy = document.getElementById('tab-my');
        const tabAllBtn = document.getElementById('tab-all-btn');
        const tabMyBtn = document.getElementById('tab-my-btn');

        if (tab === 'all') {
            tabAll.classList.remove('hidden');
            tabMy.classList.add('hidden');
            tabAllBtn.className = "py-3 px-1 border-b-2 border-primary text-primary font-bold text-sm transition-all";
            tabMyBtn.className = "py-3 px-1 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-semibold text-sm transition-all";
        } else {
            tabAll.classList.add('hidden');
            tabMy.classList.remove('hidden');
            tabAllBtn.className = "py-3 px-1 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-semibold text-sm transition-all";
            tabMyBtn.className = "py-3 px-1 border-b-2 border-primary text-primary font-bold text-sm transition-all";
        }
    }

    // Load and Open Detail Modal
    function openDetailModal(id) {
        fetch('/bendahara/pengajuan-dana/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('det-nama').innerText = data.user.name;
                document.getElementById('det-email').innerText = data.user.email;
                document.getElementById('det-telp').innerText = data.no_telp || data.user.phone_number || '—';

                document.getElementById('det-bank').innerText = data.nama_bank || '—';
                document.getElementById('det-norek').innerText = data.no_rekening || '—';
                document.getElementById('det-pemilik').innerText = data.nama_rekening || '—';

                document.getElementById('det-kategori').innerText = data.jenis_pengajuan;
                
                const formattedNominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.jumlah_dana);
                document.getElementById('det-nominal').innerText = formattedNominal;
                document.getElementById('det-keterangan').innerText = data.keterangan;

                const date = new Date(data.created_at);
                const options = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
                document.getElementById('det-tanggal').innerText = date.toLocaleDateString('id-ID', options) + ' WIB';

                // Lampiran Link
                const lampiranContainer = document.getElementById('det-lampiran');
                if (data.file_pendukung) {
                    lampiranContainer.innerHTML = `
                        <a href="/storage/${data.file_pendukung}" target="_blank" class="inline-flex items-center gap-1 text-xs text-primary font-bold hover:underline">
                            <span class="material-symbols-outlined text-sm">download</span> Unduh Dokumen Pendukung
                        </a>
                    `;
                } else {
                    lampiranContainer.innerHTML = '<span class="text-outline-variant">—</span>';
                }

                // Timeline Status rendering
                const timelineContainer = document.getElementById('det-timeline');
                timelineContainer.innerHTML = '';

                // Step 1: Created
                let timelineHtml = `
                    <div class="relative flex gap-3">
                        <div class="absolute -left-6 mt-1 w-4 h-4 rounded-full bg-success flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-on-surface">Pengajuan Dibuat</h5>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">${date.toLocaleDateString('id-ID', options)} WIB</p>
                            <p class="text-[11px] text-outline-variant mt-1">Pengajuan berhasil dikirimkan ke sistem.</p>
                        </div>
                    </div>
                `;

                // Step 2: Waiting Approval
                let statusClass = data.status === 'Pending' ? 'bg-yellow-400' : 'bg-success';
                timelineHtml += `
                    <div class="relative flex gap-3">
                        <div class="absolute -left-6 mt-1 w-4 h-4 rounded-full ${statusClass} flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-on-surface">Menunggu Persetujuan</h5>
                            <p class="text-[11px] text-outline-variant mt-1">Menunggu verifikasi dan keputusan dari Bendahara.</p>
                        </div>
                    </div>
                `;

                // Step 3: Approved or Rejected
                if (data.status !== 'Pending') {
                    let finalStatusTitle = data.status === 'Disetujui' ? 'Disetujui' : 'Ditolak';
                    let finalColorClass = data.status === 'Disetujui' ? 'bg-success' : 'bg-error';
                    let finalNote = data.status === 'Disetujui' ? (data.approval_note || 'Disetujui oleh Bendahara.') : (data.rejection_reason || 'Ditolak oleh Bendahara.');
                    let approverName = data.status === 'Disetujui' ? (data.approved_by ? data.approved_by.name : 'Bendahara') : (data.rejected_by ? data.rejected_by.name : 'Bendahara');
                    let approvalDateStr = '';
                    
                    if (data.status === 'Disetujui' && data.approved_at) {
                        approvalDateStr = new Date(data.approved_at).toLocaleDateString('id-ID', options) + ' WIB';
                    } else if (data.status === 'Ditolak' && data.rejected_at) {
                        approvalDateStr = new Date(data.rejected_at).toLocaleDateString('id-ID', options) + ' WIB';
                    }

                    timelineHtml += `
                        <div class="relative flex gap-3">
                            <div class="absolute -left-6 mt-1 w-4 h-4 rounded-full ${finalColorClass} flex items-center justify-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">${finalStatusTitle}</h5>
                                <p class="text-[10px] text-on-surface-variant mt-0.5">${approvalDateStr}</p>
                                <p class="text-[11px] text-outline mt-1 font-semibold">Oleh: ${approverName}</p>
                                <p class="text-[11px] text-on-surface italic mt-1 bg-white p-2 rounded-lg border border-outline-variant/20 mt-2 font-medium">"${finalNote}"</p>
                            </div>
                        </div>
                    `;
                }

                timelineContainer.innerHTML = timelineHtml;

                // Action Locking & Buttons
                const actionButtons = document.getElementById('det-action-buttons');
                const lockBadge = document.getElementById('det-action-lock-badge');

                if (data.status === 'Pending') {
                    actionButtons.classList.remove('hidden');
                    lockBadge.classList.add('hidden');
                    
                    // Wire up confirmation buttons in modal
                    document.getElementById('det-btn-approve').onclick = function() {
                        triggerApprove(data.id, data.user.name, formattedNominal, data.jenis_pengajuan);
                    };
                    document.getElementById('det-btn-reject').onclick = function() {
                        triggerReject(data.id);
                    };
                } else {
                    actionButtons.classList.add('hidden');
                    lockBadge.classList.remove('hidden');
                }

                document.getElementById('detail-modal').classList.remove('hidden');
            });
    }

    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }

    // Approve Confirm Modal
    function triggerApprove(id, name, amount, jenis) {
        document.getElementById('app-modal-pemohon').innerText = name;
        document.getElementById('app-modal-nominal').innerText = amount;
        document.getElementById('app-modal-jenis').innerText = jenis;
        
        document.getElementById('approve-form').action = "/bendahara/pengajuan-dana/" + id + "/approve";
        document.getElementById('approve-confirm-modal').classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approve-confirm-modal').classList.add('hidden');
    }

    // Rejection Reason Modal
    function triggerReject(id) {
        document.getElementById('reject-form').action = "/bendahara/pengajuan-dana/" + id + "/reject";
        document.getElementById('alasan_penolakan').value = '';
        document.getElementById('rejection-error').classList.add('hidden');
        document.getElementById('reject-reason-modal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('reject-reason-modal').classList.add('hidden');
    }

    function validateRejectionForm() {
        const value = document.getElementById('alasan_penolakan').value.trim();
        if (!value) {
            document.getElementById('rejection-error').classList.remove('hidden');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
