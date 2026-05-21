<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Kategori - MONET</title>
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
                    "primary": "#003d9b", "surface": "#f8f9fb", "outline-variant": "#c3c6d6",
                    "on-surface": "#191c1e", "on-surface-variant": "#434654", "background": "#f8f9fb",
                    "surface-container-lowest": "#ffffff", "error-container": "#ffdad6", "error": "#ba1a1a"
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

<main class="ml-64 pt-20 p-8 min-h-screen flex justify-center">
    <div class="w-full max-w-2xl">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Edit Kategori</h1>
                <p class="text-on-surface-variant font-body mt-1 text-sm">Perbarui informasi kategori transaksi.</p>
            </div>
            <a href="{{ route('bendahara.kategori.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-outline-variant/50 text-on-surface-variant rounded-xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-8">
            {{-- Form mengarah ke route UPDATE dan menggunakan method PUT --}}
            <form action="{{ route('bendahara.kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama_kategori" class="block text-sm font-bold text-on-surface mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required
                        class="w-full rounded-xl border-outline-variant/40 bg-surface/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary focus:bg-white transition-all">
                    @error('nama_kategori')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis" class="block text-sm font-bold text-on-surface mb-2">Jenis Kategori <span class="text-red-500">*</span></label>
                    <select name="jenis" id="jenis" required
                        class="w-full rounded-xl border-outline-variant/40 bg-surface/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary focus:bg-white transition-all">
                        <option value="pemasukan" {{ old('jenis', $kategori->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                        <option value="pengeluaran" {{ old('jenis', $kategori->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                    </select>
                    @error('jenis')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-bold text-on-surface mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="w-full rounded-xl border-outline-variant/40 bg-surface/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary focus:bg-white transition-all">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md">
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