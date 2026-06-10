<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Register | MONET</title>
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
                    "secondary-fixed": "#dae2ff", "surface-bright": "#f8f9fb", "inverse-surface": "#2e3132",
                    "inverse-primary": "#b2c5ff", "on-secondary": "#ffffff", "error-container": "#ffdad6",
                    "surface-variant": "#e1e2e4", "surface-dim": "#d9dadc", "surface-container": "#edeef0",
                    "surface-container-high": "#e7e8ea", "on-surface-variant": "#434654", "background": "#f8f9fb",
                    "on-secondary-container": "#415382", "surface-tint": "#0c56d0", "inverse-on-surface": "#f0f1f3",
                    "surface-container-highest": "#e1e2e4", "surface-container-lowest": "#ffffff",
                    "on-primary-fixed-variant": "#0040a2", "secondary-container": "#b6c8fe", "on-primary-fixed": "#001848",
                    "on-primary-container": "#c4d2ff", "tertiary-container": "#a33500", "on-surface": "#191c1e",
                    "on-error-container": "#93000a", "primary-container": "#0052cc", "surface": "#f8f9fb",
                    "on-background": "#191c1e", "primary": "#003d9b", "primary-fixed": "#dae2ff", "error": "#ba1a1a"
                },
                borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.75rem", "full": "0.75rem" },
                fontFamily: { "headline": ["Manrope"], "body": ["Inter"], "label": ["Inter"] }
            },
        },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .bg-gradient-architectural { background: radial-gradient(circle at top right, #dae2ff 0%, #f8f9fb 50%); }
</style>
</head>
<body class="font-body bg-background text-on-background min-h-screen flex items-center justify-center p-6 bg-gradient-architectural">

<main class="w-full max-w-[1100px] grid lg:grid-cols-2 bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0px_12px_32px_rgba(25,28,30,0.04)] ring-1 ring-outline-variant/10">

    {{-- Left Side: Brand Visual --}}
    <section class="hidden lg:flex flex-col justify-between p-12 bg-surface-container-low relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-12">
                <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-10 w-auto object-contain"/>
            </div>
            <h1 class="font-headline text-4xl font-bold text-on-surface leading-tight mb-6">
                Selamat Datang di <br/><span class="text-primary">MONET!</span>
            </h1>
            <p class="text-on-surface-variant max-w-sm leading-relaxed">
                Platform sistem informasi manajemen keuangan terbaik untuk organisasi Anda.
            </p>
        </div>
    </section>

    {{-- Right Side: Role Selection --}}
    <section class="flex flex-col justify-center p-6 sm:p-8 md:p-12 lg:p-16">
        <div class="w-full max-w-md mx-auto">
            <div class="lg:hidden flex items-center justify-center gap-2 mb-8">
                <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
                <span class="font-headline font-bold text-primary text-xl"></span>
            </div>

            <header class="mb-10 text-center lg:text-left">
                <h2 class="font-headline text-2xl font-bold text-on-surface mb-2">
                    Buat Akun Baru
                </h2>
                <p class="text-on-surface-variant text-sm">Pilih peran Anda untuk melanjutkan.</p>
            </header>

            <div class="space-y-4">
                <!-- Role: Mahasiswa/Anggota -->
                <a href="{{ url('/user/register') }}" class="flex items-center gap-4 p-4 border border-outline-variant/50 rounded-xl hover:border-primary hover:bg-primary-fixed/20 hover:shadow-md active:scale-[0.98] transition-all group">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed/30 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">school</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-headline font-bold text-on-surface">Mahasiswa</h3>
                        <p class="text-xs text-on-surface-variant mt-0.5">Anggota biasa / Mahasiswa</p>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span>
                </a>

                <!-- Role: Pengurus -->
                <a href="{{ url('/pengurus/register') }}" class="flex items-center gap-4 p-4 border border-outline-variant/50 rounded-xl hover:border-primary hover:bg-primary-fixed/20 hover:shadow-md active:scale-[0.98] transition-all group">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed/30 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">manage_accounts</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-headline font-bold text-on-surface">Pengurus</h3>
                        <p class="text-xs text-on-surface-variant mt-0.5">Pengurus harian organisasi</p>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span>
                </a>

                <!-- Role: Bendahara -->
                <a href="{{ url('/bendahara/register') }}" class="flex items-center gap-4 p-4 border border-outline-variant/50 rounded-xl hover:border-primary hover:bg-primary-fixed/20 hover:shadow-md active:scale-[0.98] transition-all group">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed/30 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-headline font-bold text-on-surface">Bendahara</h3>
                        <p class="text-xs text-on-surface-variant mt-0.5">Pengelola keuangan organisasi</p>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">chevron_right</span>
                </a>
            </div>

            <footer class="mt-10 text-center">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-primary hover:underline flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali ke Beranda
                </a>
            </footer>
        </div>
    </section>
</main>

</body>
</html>
