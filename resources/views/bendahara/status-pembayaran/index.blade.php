<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status Pembayaran Anggota | MONET</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" type="image/png" href="https://cdn-1.yourmonet.web.id/images/monet.png">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
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
</head>
<body class="bg-surface font-body text-on-surface antialiased">

<nav class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-md shadow-sm flex justify-between items-center px-4 md:px-8 h-16 border-b border-outline-variant/30">
    <div class="flex items-center gap-4 md:gap-8">
        <button onclick="toggleSidebar()" class="md:hidden mr-2 text-on-surface hover:text-primary transition-colors flex items-center"><span class="material-symbols-outlined text-[28px]">menu</span></button>
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

<main class="md:ml-64 p-4 pt-20 md:p-8 md:pt-20 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Status Pembayaran Kas</h1>
            <p class="text-on-surface-variant font-body mt-1">Pantau status pembayaran kas pengurus dan bendahara.</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('bendahara.status-pembayaran.reminder-massal') }}" method="POST" onsubmit="return confirm('Kirim email pengingat kepada seluruh anggota yang belum bayar/ditolak?')">
                @csrf
                <button type="submit" class="bg-secondary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-secondary/90 transition shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined">campaign</span> Kirim Pengingat Massal
                </button>
            </form>
            <button onclick="document.getElementById('modal-generate').classList.remove('hidden')" class="bg-primary text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-primary/90 transition shadow-sm hover:shadow-md">
                <span class="material-symbols-outlined">add_task</span> Generate Tagihan Baru
            </button>
        </div>
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
            <form action="{{ route('bendahara.status-pembayaran.index') }}" method="GET" class="flex flex-nowrap gap-3 w-full overflow-x-auto pb-2 custom-scrollbar">
                <div class="w-full md:w-48 shrink-0">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                </div>
                <div class="w-full md:w-auto shrink-0">
                    <select name="role" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Role (Pengurus & Bendahara)</option>
                        <option value="pengurus" {{ request('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                        <option value="bendahara" {{ request('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                    </select>
                </div>
                <div class="w-full md:w-auto shrink-0">
                    <select name="status" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Status</option>
                        <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Menunggu Verifikasi" {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="Belum Bayar" {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="w-full md:w-auto shrink-0">
                    <select name="bulan" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>Bulan {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="w-full md:w-auto shrink-0">
                    <input type="number" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun" class="w-full md:w-24 rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 text-sm">
                </div>
                <div class="w-full md:w-auto flex items-end shrink-0">
                    <button type="submit" class="w-full bg-surface-container border border-outline-variant/40 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-surface-container-high transition">Filter</button>
                </div>
                <div class="w-full md:w-auto flex items-end shrink-0">
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
                        <th class="px-6 py-4 text-center">Aksi</th>
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
                            <td class="px-6 py-4 text-center">
                                @if($pembayaran->status === 'Menunggu Verifikasi' && $pembayaran->bukti_pembayaran)
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button onclick="openBuktiModal('{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}', '{{ $pembayaran->user->name }}', '{{ Carbon\Carbon::createFromFormat('Y-m', $pembayaran->periode)->translatedFormat('F Y') }}')" class="p-1.5 bg-surface-container hover:bg-surface-container-high rounded-lg text-primary transition-all" title="Lihat Bukti">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </button>
                                        <form action="{{ route('bendahara.status-pembayaran.verify', $pembayaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi pembayaran ini sebagai LUNAS?')">
                                            @csrf
                                            <button type="submit" class="p-1.5 bg-green-100 hover:bg-green-200 rounded-lg text-green-700 transition-all" title="Verifikasi (Lunas)">
                                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                            </button>
                                        </form>
                                        <button type="button" onclick="openRejectModal('{{ $pembayaran->id }}', '{{ $pembayaran->user->name }}')" class="p-1.5 bg-red-100 hover:bg-red-200 rounded-lg text-red-700 transition-all" title="Tolak">
                                            <span class="material-symbols-outlined text-[18px]">cancel</span>
                                        </button>
                                    </div>
                                @elseif($pembayaran->bukti_pembayaran)
                                    <button onclick="openBuktiModal('{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}', '{{ $pembayaran->user->name }}', '{{ Carbon\Carbon::createFromFormat('Y-m', $pembayaran->periode)->translatedFormat('F Y') }}')" class="p-1.5 bg-surface-container hover:bg-surface-container-high rounded-lg text-primary transition-all" title="Lihat Bukti">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </button>
                                @else
                                    @if(in_array($pembayaran->status, ['Belum Bayar', 'Ditolak']))
                                        <form action="{{ route('bendahara.status-pembayaran.ingatkan', $pembayaran->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-secondary-fixed text-on-secondary-fixed-variant rounded-xl text-xs font-bold hover:bg-secondary-fixed-dim transition" title="Kirim Pengingat">
                                                <span class="material-symbols-outlined text-[14px]">campaign</span> Ingatkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-outline">—</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
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
                    <input type="number" name="jumlah" value="5000" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-sm" required>
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

{{-- Modal Lihat Bukti Pembayaran --}}
<div id="bukti-modal" class="fixed inset-0 z-[110] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeBuktiModal()"></div>
    <div id="bukti-modal-content" class="bg-white p-5 rounded-3xl max-w-lg w-full max-h-[85vh] relative z-10 overflow-hidden flex flex-col items-center shadow-2xl mx-4 transform scale-95 transition-transform duration-300">
        <button onclick="closeBuktiModal()" class="absolute top-4 right-4 bg-surface hover:bg-surface-container-high text-on-surface rounded-full p-2 flex items-center justify-center transition-colors border border-outline-variant/20 shadow-sm z-20">
            <span class="material-symbols-outlined text-lg font-bold">close</span>
        </button>
        <div class="w-full overflow-y-auto flex justify-center items-center p-2 mt-8">
            <img id="bukti-img" src="" class="max-w-full max-h-[55vh] object-contain rounded-2xl shadow-inner border border-outline-variant/20" alt="Bukti Pembayaran">
        </div>
        <p id="bukti-caption" class="text-sm font-extrabold mt-4 text-center text-on-surface"></p>
    </div>
</div>

{{-- Modal Reject Pembayaran --}}
<div id="modal-reject" class="fixed inset-0 z-[120] hidden bg-on-surface/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-surface-container-lowest rounded-3xl w-full max-w-md mx-4 overflow-hidden shadow-xl transform transition-all">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-xl font-headline font-bold text-on-surface">Tolak Pembayaran</h3>
            <button onclick="closeRejectModal()" class="text-on-surface-variant hover:text-error transition">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="reject-form" action="" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <p class="text-sm text-on-surface-variant">Tolak pembayaran dari <span id="reject-user-name" class="font-bold"></span>?</p>
                <div>
                    <label class="block text-sm font-bold text-on-surface-variant mb-1 font-headline">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" rows="3" class="w-full rounded-xl border-outline-variant/50 focus:border-primary focus:ring focus:ring-primary/20 bg-surface text-sm" placeholder="Contoh: Bukti transfer tidak jelas / nominal kurang..." required></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" class="px-5 py-2 rounded-xl text-sm font-bold text-on-surface-variant hover:bg-surface-container transition">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl text-sm font-bold text-white bg-error hover:bg-error/90 transition shadow-sm">Tolak Pembayaran</button>
            </div>
        </form>
    </div>
</div>

<script>
    const buktiModal = document.getElementById('bukti-modal');
    const buktiModalContent = document.getElementById('bukti-modal-content');
    const buktiImg = document.getElementById('bukti-img');
    const buktiCaption = document.getElementById('bukti-caption');

    function openBuktiModal(src, nama, periode) {
        buktiImg.src = src;
        buktiCaption.textContent = 'Bukti Transfer — ' + nama + ' (' + periode + ')';
        buktiModal.classList.remove('hidden');
        setTimeout(() => {
            buktiModal.classList.remove('opacity-0');
            buktiModalContent.classList.remove('scale-95');
            buktiModalContent.classList.add('scale-100');
        }, 10);
    }

    // Close Bukti Modal
    function closeBuktiModal() {
        buktiModal.classList.add('opacity-0');
        buktiModalContent.classList.remove('scale-100');
        buktiModalContent.classList.add('scale-95');
        setTimeout(() => {
            buktiModal.classList.add('hidden');
        }, 300);
    }

    function openRejectModal(id, name) {
        const form = document.getElementById('reject-form');
        form.action = `/bendahara/status-pembayaran/${id}/reject`;
        document.getElementById('reject-user-name').textContent = name;
        document.getElementById('modal-reject').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('modal-reject').classList.add('hidden');
    }
</script>

</body>
</html>
