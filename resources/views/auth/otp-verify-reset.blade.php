<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Verifikasi Kode Reset | MONET</title>
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

<main class="w-full max-w-md bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0px_12px_32px_rgba(25,28,30,0.04)] ring-1 ring-outline-variant/10 p-8 md:p-12">
    <div class="flex items-center gap-2 mb-8 justify-center">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>

    <header class="mb-8 text-center">
        <h2 class="font-headline text-2xl font-bold text-on-surface mb-2">Verifikasi Kode Reset</h2>
        <p class="text-on-surface-variant text-sm">Masukkan 6 digit kode OTP yang telah kami kirimkan ke email Anda untuk mereset password.</p>
    </header>

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

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 rounded-xl border border-green-200">
            <p class="text-green-700 text-sm">{{ session('status') }}</p>
        </div>
    @endif

    <form id="verify-form" method="POST" action="{{ route('password.verify_otp') }}" class="space-y-5" onsubmit="showLoading()">
        @csrf
        <div class="space-y-2">
            <label class="block text-xs font-semibold uppercase tracking-wider text-on-surface-variant text-center" for="code">Kode Verifikasi</label>
            <input
                class="w-full text-center tracking-[0.5em] font-headline text-2xl py-3.5 bg-surface-container-low rounded-xl border border-transparent focus:border-primary focus:ring-4 focus:ring-primary-fixed/30 outline-none transition-all text-on-surface placeholder:text-outline/50 @error('code') border-error ring-4 ring-error/10 @enderror"
                id="code" name="code" placeholder="------" maxlength="6"
                required autofocus type="text" autocomplete="off"/>
        </div>

        <button id="btn-verify"
            class="w-full py-4 px-6 bg-gradient-to-r from-primary to-primary-container text-on-primary font-headline font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
            type="submit">
            <span id="btn-text">Verifikasi Kode</span>
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-on-surface-variant">
            Tidak menerima kode? 
            <a href="{{ route('password.request') }}" class="font-bold text-primary hover:underline underline-offset-4 ml-1">Minta kode baru</a>
        </p>
    </div>
</main>
<script>
    function showLoading() {
        const btn = document.getElementById('btn-verify');
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin">autorenew</span><span class="ml-2">Memproses...</span>';
        btn.classList.add('opacity-80', 'cursor-not-allowed');
    }
</script>
</body>
</html>
