<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kategori - MONET</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-[#f8f9fb] font-['Inter']">

@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-['Manrope'] font-extrabold tracking-tight text-[#191c1e]">Kategori Transaksi</h1>
            <p class="text-gray-500 mt-1">Kelola kategori untuk klasifikasi keuangan organisasi.</p>
        </div>
        <a href="{{ route('bendahara.kategori.create') }}" class="flex items-center gap-2 px-5 py-3 bg-[#003d9b] text-white rounded-xl font-bold text-sm hover:bg-blue-800 transition-all shadow-md">
            <span class="material-symbols-outlined text-xl">add</span>
            Tambah Kategori
        </a>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 rounded-xl border border-green-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-green-700">check_circle</span>
            <p class="text-green-800 text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                    <th class="px-6 py-4 font-bold">Nama Kategori</th>
                    <th class="px-6 py-4 font-bold">Jenis</th>
                    <th class="px-6 py-4 font-bold">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kategori as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-blue-900">{{ $item->nama_kategori }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $item->jenis == 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($item->jenis) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->deskripsi ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
</body>
</html>