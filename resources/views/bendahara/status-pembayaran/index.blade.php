<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Status Pembayaran Anggota - Bendahara</title>
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

<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-8">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
</nav>

@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Status Pembayaran Anggota</h1>
            <p class="text-on-surface-variant font-body mt-1">Pantau status pembayaran kas tiap anggota.</p>
        </div>
        <form action="{{ route('bendahara.status-pembayaran.generate') }}" method="POST">
            @csrf
            <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-primary/90 transition shadow-sm hover:shadow-md">
                <span class="material-symbols-outlined">add_task</span> Generate Tagihan Bulan Ini
            </button>
        </form>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-success-container rounded-xl border border-success/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-success">check_circle</span>
            <p class="text-on-success-container text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-lowest flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form action="{{ route('bendahara.status-pembayaran.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-3 w-full">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota..." class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                </div>
                <div class="w-full md:w-auto">
                    <select name="role" class="w-full md:w-auto rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Role</option>
                        <option value="anggota" {{ request('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                        <option value="pengurus" {{ request('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                        <option value="bendahara" {{ request('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <select name="status" class="w-full md:w-auto rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Status</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
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
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-surface-container border-b border-outline-variant/30 text-on-surface-variant uppercase text-[11px] font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Anggota</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4 text-right">Jumlah (Rp)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Tanggal Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse ($penagihans as $penagihan)
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <td class="px-6 py-4 font-bold text-on-surface">{{ $penagihan->user->name }}</td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium capitalize">{{ $penagihan->user->role }}</td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium">Bulan {{ $penagihan->periode_bulan }} - {{ $penagihan->periode_tahun }}</td>
                            <td class="px-6 py-4 text-right font-bold text-on-surface">Rp {{ number_format($penagihan->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($penagihan->status === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-success-container/70 text-on-success-container border border-success/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-error-container/70 text-on-error-container border border-error/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span>
                                        BELUM LUNAS
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant font-medium">
                                {{ $penagihan->kasMasuk ? \Carbon\Carbon::parse($penagihan->kasMasuk->tanggal)->format('d/m/Y') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-3 text-outline-variant">inbox</span>
                                    <p class="font-medium">Belum ada data tagihan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
