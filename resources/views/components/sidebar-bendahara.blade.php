<aside class="h-screen w-64 fixed left-0 top-0 bg-gray-100 flex flex-col p-4 pt-20 z-40">
    <nav class="flex flex-col gap-1 flex-1">
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('*.dashboard') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ Auth::user()->getDashboardRoute() }}">
            <span class="material-symbols-outlined">dashboard</span> Dashboard
        </a>
        @if(Auth::user()->isBendahara())
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('bendahara.kas-masuk.*') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('bendahara.kas-masuk.index') }}">
            <span class="material-symbols-outlined">account_balance_wallet</span> Kas Masuk
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('bendahara.kas-keluar.*') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('bendahara.kas-keluar.index') }}">
            <span class="material-symbols-outlined">payments</span> Kas Keluar
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('bendahara.laporan.*') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('bendahara.laporan.index') }}">
            <span class="material-symbols-outlined">description</span> Laporan Keuangan
        </a>
        @endif
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('bendahara.profil.*') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('bendahara.profil.edit') }}">
            <span class="material-symbols-outlined">person</span> Profil Saya
        </a>
        @if(Auth::user()->isBendahara())
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('bendahara.manajemen-data-anggota.*') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('bendahara.manajemen-data-anggota.index') }}">
            <span class="material-symbols-outlined">manage_accounts</span> Manajemen Anggota
        </a>
        @endif
    </nav>

    <div class="mt-auto flex flex-col gap-1 border-t border-outline-variant/10 pt-4">
        @php
            $logoutPrefix = Auth::user()->role === 'anggota' ? 'user' : Auth::user()->role;
        @endphp
        <form id="logout-form" method="POST" action="/{{ $logoutPrefix }}/logout">
            @csrf
            <button type="button" onclick="showLogoutModal()" id="btn-logout"
                class="w-full flex items-center gap-3 px-4 py-3 text-error hover:bg-error-container/20 transition-all font-headline font-medium text-sm">
                <span class="material-symbols-outlined">logout</span> Keluar
            </button>
        </form>
    </div>
</aside>
