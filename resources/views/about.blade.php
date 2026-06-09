<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tentang Kami - MONET</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <link rel="favicon" href="https://cdn-1.yourmonet.web.id/images/monet.png" type="image/x-icon">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Tailwind Config -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "outline": "#727784",
                        "on-secondary-fixed-variant": "#454747",
                        "on-tertiary-fixed-variant": "#43474a",
                        "on-primary-fixed": "#001a40",
                        "surface-bright": "#f7f9ff",
                        "on-primary": "#ffffff",
                        "secondary-fixed-dim": "#c6c6c7",
                        "tertiary": "#3e4244",
                        "tertiary-fixed-dim": "#c4c7ca",
                        "on-tertiary-fixed": "#181c1e",
                        "background": "#f7f9ff",
                        "on-secondary-fixed": "#1a1c1c",
                        "inverse-surface": "#2d3135",
                        "on-background": "#181c20",
                        "on-tertiary": "#ffffff",
                        "on-surface": "#181c20",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#e0e3e6",
                        "error-container": "#ffdad6",
                        "secondary-container": "#dfe0e0",
                        "on-surface-variant": "#424752",
                        "outline-variant": "#c2c6d4",
                        "surface-container-low": "#f1f4f9",
                        "surface-container": "#ebeef3",
                        "surface-variant": "#e0e3e8",
                        "tertiary-container": "#55595c",
                        "surface-container-high": "#e5e8ee",
                        "on-secondary": "#ffffff",
                        "secondary": "#5d5f5f",
                        "surface-dim": "#d7dadf",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#eef1f6",
                        "on-primary-container": "#bbd0ff",
                        "surface-tint": "#115cb9",
                        "on-primary-fixed-variant": "#004491",
                        "primary-fixed": "#d7e2ff",
                        "secondary-fixed": "#e2e2e2",
                        "inverse-primary": "#acc7ff",
                        "on-error-container": "#93000a",
                        "primary-container": "#0056b3",
                        "surface-container-highest": "#e0e3e8",
                        "primary": "#003f87",
                        "on-tertiary-container": "#ccd0d3",
                        "on-secondary-container": "#616363",
                        "surface": "#f7f9ff",
                        "primary-fixed-dim": "#acc7ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "stack-md": "16px",
                        "stack-sm": "8px",
                        "container-max": "1280px",
                        "margin-mobile": "16px",
                        "stack-lg": "32px",
                        "margin-desktop": "64px",
                        "base": "8px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-sm": ["JetBrains Mono"],
                        "headline-lg-mobile": ["Inter"],
                        "body-md": ["Inter"],
                        "display-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "500"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "500"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 48;
        }
        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1;
        }
        
        /* Corporate Grid Background Pattern */
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #e0e3e8 1px, transparent 1px),
                              linear-gradient(to bottom, #e0e3e8 1px, transparent 1px);
            background-size: 48px 48px;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md text-body-md antialiased selection:bg-primary-fixed selection:text-on-primary-fixed flex flex-col min-h-screen">
<!-- TopNavBar (Shared Component) -->
<nav class="bg-surface/80 backdrop-blur-md docked full-width top-0 border-b border-outline-variant/30 sticky z-50">
    <div class="flex justify-between items-center w-full h-24 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
        <!-- Brand Logo -->
        <a href="/" class="flex items-center">
            <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="Monet Logo" class="h-8 w-auto object-contain">
        </a>
        <!-- Navigation Links (Desktop) -->
        <div class="hidden md:flex space-x-margin-desktop">
            <a class="{{ request()->routeIs('home') ? 'text-primary' : 'text-on-surface-variant' }} font-label-md text-label-md hover:text-primary transition-colors duration-200" href="{{ route('home') }}">Beranda</a>
            <a class="{{ request()->routeIs('about') ? 'text-primary' : 'text-on-surface-variant' }} font-label-md text-label-md hover:text-primary transition-colors duration-200" href="{{ route('about') }}">Tentang Kami</a>
            <a class="{{ request()->routeIs('contact') ? 'text-primary' : 'text-on-surface-variant' }} font-label-md text-label-md hover:text-primary transition-colors duration-200" href="{{ route('contact') }}">Kontak</a>
        </div>
        <!-- Actions -->
        <div class="flex items-center space-x-4 md:space-x-gutter">
            <a class="hidden md:inline-block text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors duration-200" href="{{ route('login') }}">Masuk</a>
            <a class="bg-primary text-on-primary font-label-md text-label-md px-6 py-2 rounded-full hover:bg-on-primary-fixed-variant transition-colors duration-200" href="{{ route('register') }}">Daftar</a>
            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-btn" class="md:hidden flex items-center justify-center text-on-surface hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[32px]">menu</span>
            </button>
        </div>
    </div>
    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-surface border-b border-outline-variant/30 shadow-lg">
        <div class="flex flex-col px-margin-mobile py-4 space-y-4">
            <a class="{{ request()->routeIs('home') ? 'text-primary' : 'text-on-surface-variant' }} font-label-md text-label-md" href="{{ route('home') }}">Beranda</a>
            <a class="{{ request()->routeIs('about') ? 'text-primary' : 'text-on-surface-variant' }} font-label-md text-label-md" href="{{ route('about') }}">Tentang Kami</a>
            <a class="{{ request()->routeIs('contact') ? 'text-primary font-bold' : 'text-on-surface-variant' }} font-label-md text-label-md" href="{{ route('contact') }}">Kontak</a>
            <div class="border-t border-outline-variant/30 pt-4">
                <a class="block text-on-surface-variant font-label-md text-label-md hover:text-primary" href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow">
    <!-- Header -->
    <header class="relative pt-28 pb-16 md:pt-40 md:pb-32 text-center overflow-hidden">
        <!-- Video Background -->
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="https://cdn-1.yourmonet.web.id/videos/money-coin.mp4" type="video/mp4">
        </video>
        
        <!-- Dark Overlay for text readability -->
        <div class="absolute inset-0 bg-black/60 z-0 pointer-events-none"></div>
        
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
            <h1 class="font-display-lg text-4xl md:text-display-lg text-white font-light mb-4" data-aos="fade-up">Tentang Kami</h1>
            <p class="font-body-lg text-body-lg text-primary-fixed-dim max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Mengenal lebih dekat tentang MONET dan tim di baliknya.
            </p>
        </div>
    </header>

    <!-- About Content -->
    <section class="py-16 md:py-24 bg-surface">
        <div class="max-w-3xl mx-auto px-margin-mobile md:px-margin-desktop text-center">
            <!-- <h2 class="font-headline-lg text-headline-lg text-on-surface mb-8 font-medium">Visi & Misi Kami</h2> -->
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed mb-6" data-aos="fade-up">
                Money on Internet (MONET) adalah sistem informasi manajemen keuangan yang dirancang secara khusus untuk mengoptimalkan tata kelola dana di dalam sebuah organisasi. Kami hadir sebagai solusi digital atas tantangan administrasi konvensional, berfokus pada efisiensi pencatatan, transparansi arus kas, dan pengarsipan data yang terpusat.
            </p>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                Sebagai platform berbasis cloud, MONET memastikan setiap bukti transaksi dan laporan tercatat dengan presisi, aman, dan dapat dipantau secara real-time sesuai dengan hierarki wewenang pengguna. Tujuan utama sistem ini adalah memfasilitasi organisasi untuk mencapai standar akuntabilitas yang tinggi, sehingga pengurus dapat mengalihkan fokus dari kerumitan administratif menuju pelaksanaan dan inovasi program kerja.
            </p>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 md:py-32 bg-surface-container-lowest" id="team">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
            <div class="mb-16 md:mb-24 text-center" data-aos="fade-up">
                <h2 class="font-display-lg text-4xl md:text-display-lg text-on-surface mb-stack-md font-light">Tim Kami</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">Ini adalah orang-orang dibalik layar MONET.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                <!-- Member 1 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                        <img src="https://cdn-1.yourmonet.web.id/images/team/sidiq.jpeg" alt="Achmad Assidiq L" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Achmad Assidiq L</h3>
                    <p class="font-body-md text-body-md text-primary font-medium mb-3">Product Owner</p>
                </div>
                <!-- Member 2 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                        <img src="https://cdn-1.yourmonet.web.id/images/team/aldilah.jpeg" alt="Aldilah Rihadatul'ais" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Aldilah Rihadatul'ais</h3>
                    <p class="font-body-md text-body-md text-primary font-medium mb-3">Scrum Master</p>
                </div>
                <!-- Member 3 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                        <img src="https://cdn-1.yourmonet.web.id/images/team/aldy.JPG" alt="Aldy Alfiansyah" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Aldy Alfiansyah</h3>
                    <p class="font-body-md text-body-md text-primary font-medium mb-3">Developer 1</p>
                </div>
                <!-- Member 4 -->
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                        <img src="https://cdn-1.yourmonet.web.id/images/team/fahri.jpeg" alt="Fahri Bintang M" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                    </div>
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Fahri Bintang M</h3>
                    <p class="font-body-md text-body-md text-primary font-medium mb-3">Developer 2</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-32 bg-surface text-center border-t border-outline-variant/30">
        <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop" data-aos="fade-up">
            <h2 class="font-display-lg text-4xl md:text-display-lg text-on-surface mb-stack-lg font-light">Siap Mengatur Keuangan Organisasi Anda?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-16 leading-relaxed">Tingkatkan presisi akuntansi dan kurangi risiko finansial dengan Monet hari ini.</p>
            <a class="inline-flex justify-center items-center bg-primary text-on-primary font-label-md text-label-md px-12 py-5 rounded-full hover:bg-on-primary-fixed-variant transition-all duration-200" href="{{ route('user.register') }}">
                Mulai Sekarang
            </a>
        </div>
    </section>
</main>

<!-- Footer (Shared Component) -->
<footer class="bg-surface border-t border-outline-variant/30 full-width mt-auto">
    <div class="flex flex-col md:flex-row justify-between items-center px-margin-mobile md:px-margin-desktop py-8 max-w-container-max mx-auto gap-4">
        <!-- Brand Logo -->
        <a href="/" class="inline-block">
            <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="Monet Logo" class="h-8 w-auto object-contain">
        </a>
        <!-- Copyright Text -->
        <p class="text-body-sm font-body-sm text-on-surface-variant text-center md:text-right">
            &copy; <script>document.write( new Date().getFullYear() );</script> Money On Internet (MONET). All rights reserved.
        </p>
    </div>
</footer>
<!-- AOS Animation Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100,
    });

    // Mobile Menu Toggle
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            menu.classList.add('flex');
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
        }
    });
</script>
</body>
</html>
