<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Daftar | Mahasiswa - MONET</title>
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
                    "inverse-primary": "#b2c5ff", "secondary-fixed-dim": "#b4c5fb", "on-secondary-fixed-variant": "#344573",
                    "primary-fixed-dim": "#b2c5ff", "on-secondary": "#ffffff", "on-tertiary-fixed": "#380d00",
                    "error-container": "#ffdad6", "surface-variant": "#e1e2e4", "surface-dim": "#d9dadc",
                    "surface-container": "#edeef0", "surface-container-high": "#e7e8ea", "on-secondary-fixed": "#021945",
                    "on-surface-variant": "#434654", "background": "#f8f9fb", "on-secondary-container": "#415382",
                    "surface-tint": "#0c56d0", "inverse-on-surface": "#f0f1f3", "surface-container-highest": "#e1e2e4",
                    "surface-container-lowest": "#ffffff", "on-primary-fixed-variant": "#0040a2",
                    "secondary-container": "#b6c8fe", "on-primary-fixed": "#001848", "on-primary-container": "#c4d2ff",
                    "tertiary-container": "#a33500", "on-tertiary-container": "#ffc6b2", "on-surface": "#191c1e",
                    "on-error-container": "#93000a", "primary-container": "#0052cc", "surface": "#f8f9fb",
                    "on-background": "#191c1e", "primary": "#003d9b", "primary-fixed": "#dae2ff", "error": "#ba1a1a"
                },
                borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                fontFamily: { "headline": ["Manrope"], "body": ["Inter"], "label": ["Inter"] }
            },
        },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .primary-gradient { background: linear-gradient(135deg, #003d9b 0%, #0052cc 100%); }
</style>
</head>
<body class="bg-surface font-body text-on-surface antialiased overflow-hidden">

<div class="flex h-screen w-full">

    {{-- Left Branding --}}
    <div class="hidden lg:flex lg:w-7/12 relative overflow-hidden bg-primary items-center justify-center">
        <div class="relative z-10 px-16 max-w-2xl">
            <div class="mb-8 flex items-center gap-3">
                <img src="https://cdn-1.yourmonet.web.id/images/monet-2.png" alt="MONET" class="h-10 w-auto object-contain"/>
            </div>
            <h2 class="text-5xl font-headline font-bold text-on-primary leading-tight mb-6">
                Halo Mahasiswa!
            </h2>
            <p class="text-xl text-primary-fixed-dim leading-relaxed">
                Buat akun untuk mengakses dashboard mahasiswa.
            </p>
        </div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[400px] h-[400px] bg-primary-container rounded-full opacity-30 blur-3xl"></div>
    </div>

    {{-- Right Form --}}
    <div class="w-full lg:w-5/12 flex flex-col bg-surface px-8 md:px-16 lg:px-24 overflow-y-auto">
        <div class="max-w-md w-full mx-auto py-12 my-auto">

            <div class="lg:hidden mb-12 flex items-center gap-3">
                <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
                <span class="text-xl font-headline font-black text-primary">MONET</span>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-headline font-bold text-on-surface mb-2">Buat Akun</h2>
                <p class="text-on-surface-variant">Isi data di bawah ini untuk membuat akun mahasiswa.</p>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="mb-5 p-4 bg-error-container rounded-xl border border-error/20">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-2 text-on-error-container text-sm">
                            <span class="material-symbols-outlined text-base text-error">error</span>
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/user/register" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-on-surface-variant" for="name">Nama Lengkap</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">person</span>
                        <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/20 rounded-xl focus:ring-4 focus:ring-primary-fixed focus:border-primary focus:outline-none transition-all placeholder:text-outline/50 @error('name') border-error @enderror"
                            id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus autocomplete="name" type="text"/>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-on-surface-variant" for="email">Alamat Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">mail</span>
                        <input class="w-full pl-10 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/20 rounded-xl focus:ring-4 focus:ring-primary-fixed focus:border-primary focus:outline-none transition-all placeholder:text-outline/50 @error('email') border-error @enderror"
                            id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autocomplete="username" type="email"/>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-on-surface-variant" for="password">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full pl-10 pr-10 py-3 bg-surface-container-lowest border border-outline-variant/20 rounded-xl focus:ring-4 focus:ring-primary-fixed focus:border-primary focus:outline-none transition-all placeholder:text-outline/50 @error('password') border-error @enderror"
                            id="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password" type="password"/>
                        <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-primary transition-colors" tabindex="-1">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-on-surface-variant" for="password_confirmation">Konfirmasi Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">verified_user</span>
                        <input class="w-full pl-10 pr-10 py-3 bg-surface-container-lowest border border-outline-variant/20 rounded-xl focus:ring-4 focus:ring-primary-fixed focus:border-primary focus:outline-none transition-all placeholder:text-outline/50"
                            id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password" type="password"/>
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-primary transition-colors" tabindex="-1">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>

                <button id="btn-register-anggota" type="submit"
                    class="w-full primary-gradient text-on-primary font-bold py-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all mt-2 font-headline uppercase tracking-wider text-sm flex items-center justify-center gap-2">
                    <span class="btn-text">Buat Akun</span>
                    <svg class="hidden animate-spin h-5 w-5 text-white btn-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-4 my-6">
                <div class="flex-1 h-px bg-outline-variant/20"></div>
                <span class="text-xs font-semibold text-outline uppercase tracking-widest">atau</span>
                <div class="flex-1 h-px bg-outline-variant/20"></div>
            </div>

            {{-- Google Register --}}
            <a href="{{ route('auth.google.redirect', 'anggota') }}"
                class="w-full flex items-center justify-center gap-3 py-3.5 px-6 bg-surface-container-lowest border border-outline-variant/30 rounded-xl text-on-surface font-semibold text-sm hover:bg-surface-container-low hover:border-outline/50 hover:shadow-md active:scale-[0.98] transition-all">
                <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5"/>
                <span>Daftar dengan Google</span>
            </a>

            <div class="mt-6 text-center">
                <p class="text-on-surface-variant font-medium text-sm">
                    Sudah punya akun?
                    <a class="text-primary font-bold hover:text-primary-container transition-colors ml-1" href="/user/login">Masuk</a>
                </p>
            </div>

        </div>
    </div>
</div>
<script>
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.querySelector('button[type="submit"]');
        if(!btn) return;
        const text = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.btn-spinner');
        
        btn.disabled = true;
        btn.classList.add('opacity-80', 'cursor-not-allowed');
        if(text) text.textContent = 'Memproses...';
        if(spinner) spinner.classList.remove('hidden');
    });
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility_off';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility';
        }
    }
</script>
</body>
</html>
