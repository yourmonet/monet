<aside class="h-screen w-64 fixed left-0 top-0 bg-gray-100 flex flex-col p-4 pt-20 z-40">
    <nav class="flex flex-col gap-1 flex-1">
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.dashboard') ? 'bg-white text-blue-700 rounded-lg scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-all font-headline font-medium text-sm" href="{{ route('pengurus.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span> Dashboard
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.status-pembayaran.*') ? 'bg-white text-blue-700 rounded-lg scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-all font-headline font-medium text-sm" href="{{ route('pengurus.status-pembayaran.index') }}">
            <span class="material-symbols-outlined">fact_check</span> Status Pembayaran
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ Request::routeIs('pengurus.pembayaran.index') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('pengurus.pembayaran.index') }}">
            <span class="material-symbols-outlined">payments</span> Pembayaran Kas
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.pengajuan-dana.*') ? 'bg-white text-blue-700 rounded-lg scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-all font-headline font-medium text-sm" href="{{ route('pengurus.pengajuan-dana.index') }}">
            <span class="material-symbols-outlined">volunteer_activism</span> Pengajuan Dana
        </a>
    </nav>

    <div class="mt-auto flex flex-col gap-1 border-t border-outline-variant/10 pt-4">
        <form id="logout-form" method="POST" action="/pengurus/logout">
            @csrf
            <button type="button" onclick="showLogoutModal()" id="btn-logout-pengurus"
                class="w-full flex items-center gap-3 px-4 py-3 text-error hover:bg-error-container/20 transition-all font-headline font-medium text-sm">
                <span class="material-symbols-outlined">logout</span> Keluar
            </button>
        </form>
    </div>
</aside>
