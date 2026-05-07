<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Data Anggota - MONET</title>
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
        <span class="text-on-surface">Edit Data Anggota</span>
    </div>

    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Edit Data Anggota</h1>
            <p class="text-on-surface-variant font-body mt-1">Perbarui informasi personal, peran, dan status kepatuhan.</p>
        </div>
    </header>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 rounded-xl border border-red-200 flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-red-700">error</span>
                <p class="text-red-800 text-sm font-bold">Terdapat kesalahan pengisian form:</p>
            </div>
            <ul class="list-disc list-inside text-red-800 text-sm ml-8">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Panel Kiri: Identitas -->
        <div class="w-full lg:w-1/3 flex flex-col gap-6">
            <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30 text-center flex flex-col items-center">
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
                    <div class="absolute bottom-0 right-0 w-8 h-8 {{ $user->role === 'anggota' ? 'bg-surface-variant' : ($user->belum_lunas_count == 0 ? 'bg-green-500' : 'bg-red-500') }} border-4 border-white rounded-full"></div>
                </div>

                <h3 class="text-xl font-headline font-extrabold text-on-surface">{{ $user->name }}</h3>
                <p class="text-sm text-on-surface-variant mb-6">{{ $user->email }}</p>

                <div class="w-full h-px bg-outline-variant/30 my-4"></div>

                <div class="w-full flex flex-col gap-4 text-left">
                    <div class="flex justify-between items-center bg-surface-container/40 p-3 rounded-xl border border-outline-variant/20">
                        <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Status Peran</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                            {{ $user->role === 'bendahara' ? 'bg-blue-100 text-blue-800' : ($user->role === 'pengurus' ? 'bg-emerald-100 text-emerald-800' : 'bg-purple-100 text-purple-800') }}">
                            {{ $user->role }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center bg-surface-container/40 p-3 rounded-xl border border-outline-variant/20">
                        <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Kepatuhan Kas</span>
                        @if($user->role === 'anggota')
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-variant text-on-surface-variant text-xs font-bold">
                                <span class="material-symbols-outlined text-[14px]">block</span> Bebas Kas
                            </div>
                        @elseif($user->belum_lunas_count == 0)
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-600"></div> Lunas
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold tooltip-trigger" title="{{ $user->belum_lunas_count }} tagihan belum lunas">
                                <div class="w-1.5 h-1.5 rounded-full bg-red-600"></div> Tunggakan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Form Edit -->
        <div class="flex-1">
            <form action="{{ route('bendahara.manajemen-data-anggota.update', $user->id) }}" method="POST" class="bg-surface-container-lowest rounded-3xl p-8 shadow-sm border border-outline-variant/30 flex flex-col gap-8">
                @csrf
                @method('PUT')

                <div>
                    <h2 class="text-lg font-headline font-bold text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">person_edit</span>
                        Data Personal
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2 relative col-span-2">
                            <label class="text-sm font-semibold text-on-surface-variant">Nama Lengkap</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">person</span>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all" required>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Alamat Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">mail</span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all" required>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Nomor Telepon</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">call</span>
                                <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all" placeholder="Misal: 08123456789">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full h-px bg-outline-variant/30 my-2"></div>

                <div>
                    <h2 class="text-lg font-headline font-bold text-on-surface mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">admin_panel_settings</span>
                        Pengaturan Sistem
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Peran Akses</label>
                            <div class="relative">
                                <select name="role" class="w-full pl-4 pr-10 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all appearance-none cursor-pointer">
                                    <option value="anggota" {{ $user->role === 'anggota' ? 'selected' : '' }}>Anggota</option>
                                    <option value="pengurus" {{ $user->role === 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                    <option value="bendahara" {{ $user->role === 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Status Kepatuhan Kas</label>
                            <div class="relative p-3 bg-surface-container border border-outline-variant/30 rounded-xl flex items-center gap-2">
                                @if($user->role === 'anggota')
                                    <span class="material-symbols-outlined text-on-surface-variant">block</span>
                                    <span class="text-sm font-bold text-on-surface-variant">Bebas Kas (Otomatis)</span>
                                @elseif($user->belum_lunas_count == 0)
                                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                                    <span class="text-sm font-bold text-green-800">Lunas (Otomatis)</span>
                                @else
                                    <span class="material-symbols-outlined text-red-600">warning</span>
                                    <span class="text-sm font-bold text-red-800">Tunggakan ({{ $user->belum_lunas_count }} Tagihan)</span>
                                @endif
                            </div>
                            <p class="text-xs text-on-surface-variant mt-1">Status diperbarui otomatis berdasarkan data pembayaran.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3 pt-6 border-t border-outline-variant/30 mt-4">
                    <a href="{{ route('bendahara.manajemen-data-anggota.index') }}" class="px-6 py-3 rounded-xl border border-outline-variant/40 text-on-surface-variant font-bold text-sm hover:bg-surface-container transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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
