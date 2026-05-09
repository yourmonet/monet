<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Kategori Transaksi - MONET</title>
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
                    "surface-variant": "#e1e2e4", "surface-container-lowest": "#ffffff",
                    "on-surface": "#191c1e", "on-error-container": "#93000a", "primary-container": "#0052cc",
                    "surface": "#f8f9fb", "on-background": "#191c1e", "primary": "#003d9b", "error": "#ba1a1a"
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

{{-- NAVBAR ATAS --}}
<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-8">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mt-0.5">{{ Auth::user()->role ?? 'Bendahara' }}</div>
        </div>
        
        @if(Auth::user()->avatar)
            @if(str_contains(Auth::user()->avatar, 'http'))
                <img src="{{ Auth::user()->avatar }}" alt="Profil" class="w-10 h-10 rounded-full object-cover shadow-sm">
            @else
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profil" class="w-10 h-10 rounded-full object-cover shadow-sm">
            @endif
        @else
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>

@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen">
    <header class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Kategori Transaksi</h1>
            <p class="text-gray-500 font-body mt-1">Kelola kategori untuk klasifikasi keuangan organisasi.</p>
        </div>
        <a href="{{ route('bendahara.kategori.create') }}" class="flex items-center gap-2 px-5 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-blue-800 transition-all shadow-md">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Kategori
        </a>
    </header>

    {{-- KARTU STATISTIK (Fitur Baru) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-2xl">category</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Kategori</p>
                <h3 class="text-2xl font-headline font-black text-on-surface">{{ $totalKategori }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                <span class="material-symbols-outlined text-2xl">trending_up</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori Pemasukan</p>
                <h3 class="text-2xl font-headline font-black text-on-surface">{{ $totalPemasukan }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600">
                <span class="material-symbols-outlined text-2xl">trending_down</span>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kategori Pengeluaran</p>
                <h3 class="text-2xl font-headline font-black text-on-surface">{{ $totalPengeluaran }}</h3>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 rounded-xl border border-green-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-green-700">check_circle</span>
            <p class="text-green-800 text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 font-headline text-sm uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 font-bold">Nama Kategori</th>
                        <th class="px-6 py-4 font-bold">Jenis</th>
                        <th class="px-6 py-4 font-bold">Deskripsi</th>
                        <th class="px-6 py-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kategori as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-bold text-blue-900">{{ $item->nama_kategori }}</td>
                            <td class="px-6 py-4 text-sm capitalize">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $item->jenis == 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->deskripsi ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('bendahara.kategori.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit_square</span>
                                    </a>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('bendahara.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">folder_off</span>
                                    <p class="text-gray-500 font-medium text-sm">Belum ada kategori yang dibuat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
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