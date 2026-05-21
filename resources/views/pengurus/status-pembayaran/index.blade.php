<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Status Pembayaran Kas - Pengurus | MONET</title>
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

@include('components.sidebar-pengurus')

<main class="ml-64 pt-20 p-8 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Status Pembayaran Kas</h1>
            <p class="text-on-surface-variant font-body mt-1">Pantau status pembayaran kas pengurus dan bendahara.</p>
        </div>
    </header>

    <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-lowest flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form action="{{ route('pengurus.status-pembayaran.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-3 w-full">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                </div>
                <div class="w-full md:w-auto">
                    <select name="role" class="w-full md:w-auto rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Role (Pengurus & Bendahara)</option>
                        <option value="pengurus" {{ request('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                        <option value="bendahara" {{ request('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <select name="status" class="w-full md:w-auto rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Status</option>
                        <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Menunggu Verifikasi" {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="Belum Bayar" {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <select name="bulan" class="w-full md:w-auto rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>Bulan {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <input type="number" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun" class="w-full md:w-24 rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                </div>
                <div class="w-full md:w-auto flex items-end">
                    <button type="submit" class="w-full bg-surface-container border border-outline-variant/40 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-surface-container-high transition">Filter</button>
                </div>
                <div class="w-full md:w-auto flex items-end">
                    <a href="{{ route('pengurus.status-pembayaran.index') }}" class="w-full text-center text-primary bg-primary-container/30 border border-primary/20 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-container/50 transition">Reset</a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto overflow-y-auto max-h-[520px]">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-surface-container border-b border-outline-variant/30 text-on-surface-variant uppercase text-[11px] font-bold tracking-wider sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4 text-right">Nominal (Rp)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Tgl Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse ($pembayarans as $pembayaran)
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <td class="px-6 py-4 font-bold text-on-surface">
                                <div class="flex items-center gap-3">
                                    @if($pembayaran->user->avatar)
                                        @php
                                            $av = $pembayaran->user->avatar;
                                            $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
                                        @endphp
                                        <img src="{{ $avatarUrl }}" class="w-8 h-8 rounded-full object-cover" alt="Avatar">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                            {{ strtoupper(substr($pembayaran->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    {{ $pembayaran->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium capitalize">{{ $pembayaran->user->role }}</td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium">{{ Carbon\Carbon::createFromFormat('Y-m', $pembayaran->periode)->translatedFormat('F Y') }}</td>
                            <td class="px-6 py-4 text-right font-bold text-on-surface">Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($pembayaran->status === 'Lunas')
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-success-container/70 text-on-success-container border border-success/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        LUNAS
                                    </span>
                                @elseif($pembayaran->status === 'Menunggu Verifikasi')
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-850 border border-yellow-250" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #ffc107"></span>
                                        MENUNGGU
                                    </span>
                                @elseif($pembayaran->status === 'Ditolak')
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-error-container/70 text-on-error-container border border-error/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        DITOLAK
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-surface-container-high text-on-surface-variant border border-outline-variant/30">
                                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                        BELUM BAYAR
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium">
                                {{ $pembayaran->bukti_pembayaran ? \Carbon\Carbon::parse($pembayaran->updated_at)->format('d/m/Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-3 text-outline-variant">inbox</span>
                                    <p class="font-medium">Belum ada data tagihan atau pembayaran.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-outline-variant/30">
            {{ $pembayarans->appends(request()->query())->links() }}
        </div>
    </div>
</main>
</body>
</html>
