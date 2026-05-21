<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tambah Kategori - MONET</title>
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
                        "primary": "#003d9b",
                        "surface": "#f8f9fb",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#434654",
                        "outline-variant": "#c3c6d6",
                    },
                    fontFamily: { "headline": ["Manrope"], "body": ["Inter"] }
                },
            },
        }
    </script>
</head>
<body class="bg-surface font-body text-on-surface">

{{-- Navbar Atas --}}
<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-8">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline-variant font-bold mt-0.5">{{ Auth::user()->role ?? 'Bendahara' }}</div>
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

{{-- Panggil Sidebar --}}
@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen flex justify-center">
    <div class="w-full max-w-2xl">
        {{-- Header --}}
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-headline font-extrabold tracking-tight text-on-surface">Tambah Kategori</h1>
                <p class="text-on-surface-variant font-body mt-1 text-sm">Buat kategori baru untuk transaksi keuangan.</p>
            </div>
            <a href="{{ route('bendahara.kategori.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-outline-variant/50 text-on-surface-variant rounded-xl font-bold text-sm hover:bg-gray-50 transition-all shadow-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </header>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-8">
            <form action="{{ route('bendahara.kategori.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Input Nama Kategori --}}
                <div>
                    <label for="nama_kategori" class="block text-sm font-bold text-on-surface mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" required placeholder="Contoh: Konsumsi Rapat, Iuran Anggota, dll."
                        class="w-full rounded-xl border-outline-variant/40 bg-surface/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary focus:bg-white transition-all placeholder:text-gray-400">
                    @error('nama_kategori')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Jenis --}}
                <div>
                    <label for="jenis" class="block text-sm font-bold text-on-surface mb-2">Jenis Kategori <span class="text-red-500">*</span></label>
                    <select name="jenis" id="jenis" required
                        class="w-full rounded-xl border-outline-variant/40 bg-surface/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary focus:bg-white transition-all">
                        <option value="" disabled selected>-- Pilih Jenis --</option>
                        <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                        <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                    </select>
                    @error('jenis')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-bold text-on-surface mb-2">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Tambahkan keterangan singkat mengenai kategori ini..."
                        class="w-full rounded-xl border-outline-variant/40 bg-surface/50 px-4 py-3 text-sm focus:border-primary focus:ring-primary focus:bg-white transition-all placeholder:text-gray-400">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>