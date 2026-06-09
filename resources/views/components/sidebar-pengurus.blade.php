<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity opacity-0" onclick="toggleSidebar()"></div>

<aside id="mobile-sidebar" class="h-screen w-64 fixed left-0 top-0 bg-gray-100 flex flex-col p-4 pt-20 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <nav class="flex flex-col gap-1 flex-1">
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.dashboard') ? 'bg-white text-blue-700 rounded-lg scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-all font-headline font-medium text-sm" href="{{ route('pengurus.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span> Dashboard
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.kas-masuk.*') ? 'bg-white text-blue-700 rounded-lg scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-all font-headline font-medium text-sm" href="{{ route('pengurus.kas-masuk.index') }}">
            <span class="material-symbols-outlined">account_balance_wallet</span> Kas Masuk
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.kas-keluar.*') ? 'bg-white text-blue-700 rounded-lg scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} transition-all font-headline font-medium text-sm" href="{{ route('pengurus.kas-keluar.index') }}">
            <span class="material-symbols-outlined">payments</span> Kas Keluar
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ Request::routeIs('pengurus.pembayaran.index') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('pengurus.pembayaran.index') }}">
            <span class="material-symbols-outlined">payments</span> Pembayaran Kas
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.pengajuan-dana.*') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('pengurus.pengajuan-dana.index') }}">
            <span class="material-symbols-outlined">handshake</span> Pengajuan Dana
        </a>
        <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengurus.profil.edit') ? 'bg-white text-blue-700 scale-95 shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} rounded-lg transition-all font-headline font-medium text-sm" href="{{ route('pengurus.profil.edit') }}">
            <span class="material-symbols-outlined">person</span> Profil Saya
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

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10);
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
    }
</script>
