<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | Mahasiswa - MONET</title>
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
                Selamat Datang <br/><span class="text-primary">Mahasiswa!</span>
            </h1>
            <p class="text-on-surface-variant max-w-sm leading-relaxed">
                Silahkan masuk ke akun Anda untuk mengakses dashboard mahasiswa.
            </p>
        </div>
    </section>

    {{-- Right Side: Login Form --}}
    <section class="flex flex-col justify-center p-8 md:p-16">
        <div class="w-full max-w-md mx-auto">
            <div class="lg:hidden flex items-center gap-2 mb-8">
                <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
                <span class="font-headline font-bold text-primary">MONET</span>
            </div>

            <header class="mb-8">
                <h2 class="font-headline text-2xl font-bold text-on-surface mb-2">Masuk ke Akun</h2>
                <p class="text-on-surface-variant text-sm">Masukkan kredensial Anda untuk masuk ke akun.</p>
            </header>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-error-container rounded-xl border border-error/20">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2 text-on-error-container text-sm">
                            <span class="material-symbols-outlined text-base text-error">error</span>
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-200">
                    <p class="text-green-700 text-sm">{{ session('status') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="/user/login" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant" for="email">Alamat Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">mail</span>
                        </div>
                        <input
                            class="w-full pl-11 pr-4 py-3.5 bg-surface-container-low rounded-xl border border-transparent focus:border-primary focus:ring-4 focus:ring-primary-fixed/30 outline-none transition-all text-on-surface placeholder:text-outline font-medium text-sm @error('email') border-error ring-4 ring-error/10 @enderror"
                            id="email" name="email" placeholder="nama@email.com"
                            value="{{ old('email') }}" required autofocus autocomplete="username" type="email"/>
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant" for="password">Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-outline group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[20px]">lock</span>
                        </div>
                        <input
                            class="w-full pl-11 pr-4 py-3.5 bg-surface-container-low rounded-xl border border-transparent focus:border-primary focus:ring-4 focus:ring-primary-fixed/30 outline-none transition-all text-on-surface placeholder:text-outline font-medium text-sm"
                            id="password" name="password" placeholder="••••••••" required autocomplete="current-password" type="password"/>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center">
                        <input id="remember" type="checkbox" name="remember" class="w-5 h-5 rounded border-outline text-primary bg-surface-container-low focus:ring-primary focus:ring-offset-0 focus:ring-2 cursor-pointer transition-all hover:border-primary">
                    </div>
                    <label for="remember" class="text-sm font-medium text-on-surface-variant cursor-pointer select-none">
                        Ingat saya
                    </label>
                </div>

                {{-- Submit --}}
                <button id="btn-login-anggota"
                    class="w-full py-4 px-6 bg-gradient-to-r from-primary to-primary-container text-on-primary font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
                    type="submit">
                    <span class="btn-text">Masuk</span>
                    <span class="material-symbols-outlined text-base btn-icon">arrow_forward</span>
                    <svg class="hidden animate-spin h-5 w-5 text-white btn-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>

            <footer class="mt-10 text-center">
                <p class="text-sm text-on-surface-variant">
                    Belum punya akun?
                    <a class="font-bold text-primary hover:underline underline-offset-4 ml-1" href="/user/register">Buat akun</a> sekarang!
                </p>
            </footer>
        </div>
    </section>
</main>

<script>
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.querySelector('button[type="submit"]');
        if(!btn) return;
        const text = btn.querySelector('.btn-text');
        const icon = btn.querySelector('.btn-icon');
        const spinner = btn.querySelector('.btn-spinner');
        
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
        if(text) text.textContent = 'Memproses...';
        if(icon) icon.classList.add('hidden');
        if(spinner) spinner.classList.remove('hidden');
    });
</script>
</body>
</html>
