<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status Pembayaran Anggota | MONET</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: "#006492",
                    "primary-container": "#cae6ff",
                    "on-primary-container": "#001e2f",
                    secondary: "#50606e",
                    "secondary-container": "#d3e5f5",
                    "on-secondary-container": "#0b1d29",
                    surface: "#f7f9fc",
                    "surface-container": "#e1e7ec",
                    "surface-container-low": "#f1f4f9",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-high": "#cbe0f1",
                    "on-surface": "#191c1e",
                    "on-surface-variant": "#42474e",
                    outline: "#72777f",
                    "outline-variant": "#c2c7cf",
                    error: "#ba1a1a",
                    "error-container": "#ffdad6",
                    "on-error-container": "#410002",
                    success: "#146c2e",
                    "success-container": "#a0f5a7",
                    "on-success-container": "#002106"
                },
                fontFamily: {
                    headline: ["Manrope", "sans-serif"],
                    body: ["Inter", "sans-serif"],
                }
            }
        }
    }
</script>
</head>
<body class="bg-surface font-body text-on-surface antialiased">

<nav class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 border-b border-outline-variant/30">
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
            <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Status Pembayaran Kas</h1>
            <p class="text-on-surface-variant font-body mt-1">Pantau status pembayaran kas pengurus dan bendahara.</p>
        </div>
        <button onclick="document.getElementById('modal-generate').classList.remove('hidden')" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-primary/90 transition shadow-sm hover:shadow-md">
            <span class="material-symbols-outlined">add_task</span> Generate Tagihan Baru
        </button>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-success-container rounded-xl border border-success/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-success">check_circle</span>
            <p class="text-on-success-container text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container rounded-xl border border-error/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-error">error</span>
            <p class="text-on-error-container text-sm font-semibold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="p-6 border-b border-outline-variant/30 bg-surface-container-lowest flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form action="{{ route('bendahara.status-pembayaran.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-3 w-full">
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
                    <a href="{{ route('bendahara.status-pembayaran.index') }}" class="w-full text-center text-primary bg-primary-container/30 border border-primary/20 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-container/50 transition">Reset</a>
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

{{-- Modal Generate Tagihan --}}
<div id="modal-generate" class="fixed inset-0 z-50 hidden bg-on-surface/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-surface-container-lowest rounded-3xl w-full max-w-md mx-4 overflow-hidden shadow-xl transform transition-all">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-xl font-headline font-bold text-on-surface">Generate Tagihan Baru</h3>
            <button onclick="document.getElementById('modal-generate').classList.add('hidden')" class="text-on-surface-variant hover:text-error transition">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('bendahara.status-pembayaran.generate') }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-on-surface-variant mb-1">Bulan</label>
                    <select name="generate_bulan" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-sm" required>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ \Carbon\Carbon::now()->month == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface-variant mb-1">Tahun</label>
                    <input type="number" name="generate_tahun" value="{{ \Carbon\Carbon::now()->year }}" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface-variant mb-1">Nominal (Rp)</label>
                    <input type="number" name="jumlah" value="25000" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-sm" required>
                </div>
                <p class="text-xs text-on-surface-variant mt-2">
                    Tagihan ini hanya akan di-generate untuk role <b>Bendahara</b> dan <b>Pengurus</b>. Anggota tidak memiliki kewajiban kas.
                </p>
            </div>
            <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-generate').classList.add('hidden')" class="px-5 py-2 rounded-xl text-sm font-bold text-on-surface-variant hover:bg-surface-container transition">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary/90 transition shadow-sm">Generate Tagihan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
