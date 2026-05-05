<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Manajemen Data Anggota - MONET</title>
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
            @php $avatarUrl = Str::startsWith(Auth::user()->avatar, ['http://', 'https://']) ? Auth::user()->avatar : Storage::url(Auth::user()->avatar); @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="Profile">
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
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Manajemen Data Anggota</h1>
            <p class="text-on-surface-variant font-body mt-1">Kelola data seluruh anggota, pengurus, dan status kepatuhan kas secara terpusat.</p>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 rounded-xl border border-green-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-green-700">check_circle</span>
            <p class="text-green-800 text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/30 text-sm font-bold text-on-surface-variant uppercase tracking-wider">
                        <th class="pb-4 pl-4">Profil</th>
                        <th class="pb-4">Peran</th>
                        <th class="pb-4">Status Kas</th>
                        <th class="pb-4 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($users as $u)
                        <tr class="border-b border-outline-variant/10 hover:bg-surface-container/30 transition-colors">
                            <td class="py-4 pl-4">
                                <div class="flex items-center gap-3">
                                    @if($u->avatar)
                                        @php $avatarUrl = Str::startsWith($u->avatar, ['http://', 'https://']) ? $u->avatar : Storage::url($u->avatar); @endphp
                                        <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant/30" alt="Avatar">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-surface-container-high border border-outline-variant/30 flex items-center justify-center font-bold text-on-surface-variant">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-on-surface">{{ $u->name }}</p>
                                        <p class="text-xs text-on-surface-variant">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                                    {{ $u->role === 'bendahara' ? 'bg-blue-100 text-blue-800' : ($u->role === 'pengurus' ? 'bg-emerald-100 text-emerald-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="py-4">
                                @if($u->status_kepatuhan_kas === 'lunas')
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green-600"></div> Lunas
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold">
                                        <div class="w-1.5 h-1.5 rounded-full bg-red-600"></div> Tunggakan
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 text-right pr-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('bendahara.manajemen-data-anggota.show', $u->id) }}" class="p-2 rounded-xl text-primary hover:bg-primary-container/40 transition-colors tooltip-trigger" title="Lihat Detail & Riwayat Kas">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    <a href="{{ route('bendahara.manajemen-data-anggota.edit', $u->id) }}" class="p-2 rounded-xl text-on-surface-variant hover:bg-surface-container transition-colors tooltip-trigger" title="Edit Data & Status">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
