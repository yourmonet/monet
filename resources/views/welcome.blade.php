<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MONEY ON INTERNET - MONET</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="https://cdn-1.yourmonet.web.id/images/monet.png">
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
<body class="bg-background text-on-background font-body-md text-body-md antialiased selection:bg-primary-fixed selection:text-on-primary-fixed">
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
            <!-- <a class="text-on-surface-variant font-label-md text-label-md hover:text-primary transition-colors duration-200" href="">Harga</a> -->
            <a class="{{ request()->routeIs('contact') ? 'text-primary font-bold' : 'text-on-surface-variant' }} font-label-md text-label-md hover:text-primary transition-colors duration-200" href="{{ route('contact') }}">Kontak</a>
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

<!-- Hero Section -->
<header class="relative min-h-[90vh] flex items-center justify-center overflow-hidden pt-20 pb-16 md:pt-24 md:pb-32">
    <!-- Video Background -->
    <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
        <source src="https://cdn-1.yourmonet.web.id/videos/money-video.mp4" type="video/mp4">
    </video>
    
    <!-- Dark Overlay for text readability -->
    <div class="absolute inset-0 bg-black/60 z-0 pointer-events-none"></div>

    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative z-10 flex flex-col items-center text-center">
        <h1 data-aos="fade-up" class="font-display-lg text-4xl md:text-display-lg text-white font-light leading-tight mb-8">
            Kelola keuangan lebih cerdas dengan <br/><span class="text-primary-container font-semibold">MONET.</span>
        </h1>
        <p data-aos="fade-up" data-aos-delay="100" class="font-body-lg text-body-lg text-gray-200 max-w-2xl leading-relaxed mb-10">
            MONET diciptakan untuk membantu organisasi mengelola keuangan dengan lebih cerdas dan transparan.
        </p>
        <div data-aos="fade-up" data-aos-delay="200" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
            <a class="inline-flex justify-center items-center bg-primary text-white font-label-md text-label-md px-10 py-4 rounded-full hover:bg-blue-800 transition-all duration-300 shadow-lg shadow-primary/30" href="{{ route('register') }}">
                Mulai Sekarang
            </a>
            <a class="inline-flex justify-center items-center group text-white font-label-md text-label-md px-10 py-4 border border-white/30 hover:bg-white/10 rounded-full backdrop-blur-sm transition-all duration-300" href="{{ route('about') }}">
                Tentang Kami <span class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
    </div>
</header>


<!-- <section class="border-t border-outline-variant/30 bg-surface py-20">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <p class="text-center font-label-sm text-label-sm text-on-surface-variant mb-12 uppercase tracking-[0.2em]">Dipercaya oleh instansi terkemuka</p>
        <div class="flex flex-wrap justify-center items-center gap-24 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">

            <span class="font-headline-md text-headline-md font-bold text-outline-variant">GlobalNGO</span>
            <span class="font-headline-md text-headline-md font-bold text-outline-variant">TechCorp Ind</span>
            <span class="font-headline-md text-headline-md font-bold text-outline-variant">Grup Finansial</span>
            <span class="font-headline-md text-headline-md font-bold text-outline-variant">Yayasan Bakti</span>
        </div>
    </div>
</section> -->

<!-- Features Section -->
<section class="py-16 md:py-32 bg-surface-container-lowest" id="features">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="text-center max-w-3xl mx-auto mb-16 md:mb-32" data-aos="fade-up">
            <h2 class="font-display-lg text-4xl md:text-display-lg text-on-surface mb-stack-md font-light">Mengapa harus MONET?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">Kami memiliki fitur unggulan yang dapat digunakan untuk keperluan organisasi Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-24 gap-y-32">
            <!-- Feature 1 -->
            <div class="flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-24 h-24 rounded-full bg-primary-fixed/20 flex items-center justify-center text-primary mb-stack-lg group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-[48px] font-light">donut_large</span>
                </div>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-stack-md font-medium">Laporan Keuangan Real-time</h3>
                <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed max-w-md">Pantau laporan keuangan secara realtime dimanapun dan kapanpun.</p>
            </div>
            <!-- Feature 2 -->
            <div class="flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-24 h-24 rounded-full bg-surface-variant/50 flex items-center justify-center text-on-surface-variant mb-stack-lg group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-[48px] font-light">timeline</span>
                </div>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-stack-md font-medium">Transparansi First</h3>
                <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed max-w-md">Bukan hanya bendahara saja, pengurus biasa dapat memantau laporan keuangan organisasi.</p>
            </div>
            <!-- Feature 3 -->
            <div class="flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-24 h-24 rounded-full bg-surface-variant/50 flex items-center justify-center text-on-surface-variant mb-stack-lg group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-[48px] font-light">account_balance</span>
                </div>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-stack-md font-medium">Pencairan Mudah</h3>
                <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed max-w-md">Terhubung dengan banyak Bank besar di Indonesia yang dapat memudahkan pencairan dana organisasi Anda.</p>
            </div>
            <!-- Feature 4 -->
            <div class="flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="400">
                <div class="w-24 h-24 rounded-full bg-primary-fixed/20 flex items-center justify-center text-primary mb-stack-lg group-hover:scale-110 transition-transform duration-500 p-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="w-full h-full object-contain">
                </div>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-stack-md font-medium">Pembayaran Mudah & Cepat</h3>
                <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed max-w-md">Sistem kami menggunakan QRIS sebagai metode pembayaran untuk kemudahan transaksi.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 md:py-32 bg-surface" id="team">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="mb-16 md:mb-24 text-center" data-aos="fade-up">
            <h2 class="font-display-lg text-4xl md:text-display-lg text-on-surface mb-stack-md font-light">Tim Kami</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">Ini adalah orang-orang dibalik layar MONET.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
            <!-- Member 1 -->
            <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                    <img src="https://cdn-1.yourmonet.web.id/images/team/sidiq.jpeg" alt="Aldy Alfiansyah" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Achmad Assidiq L</h3>
                <p class="font-body-md text-body-md text-primary font-medium mb-3">Product Owner</p>
                <!-- <p class="font-body-sm text-body-sm text-on-surface-variant">Mengarahkan visi produk dan memastikan setiap modul memenuhi standar tertinggi.</p> -->
            </div>
            <!-- Member 2 -->
            <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                    <img src="https://cdn-1.yourmonet.web.id/images/team/aldilah.jpeg" alt="Fahri" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Aldilah Rihadatul'ais</h3>
                <p class="font-body-md text-body-md text-primary font-medium mb-3">Scrum Master</p>
                <!-- <p class="font-body-sm text-body-sm text-on-surface-variant">Arsitek utama sistem keuangan dan pengembangan fitur inti.</p> -->
            </div>
            <!-- Member 3 -->
            <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                    <img src="https://cdn-1.yourmonet.web.id/images/team/aldy.JPG" alt="Siti Nurhaliza" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Aldy Alfiansyah</h3>
                <p class="font-body-md text-body-md text-primary font-medium mb-3">Developer 1</p>
                <!-- <p class="font-body-sm text-body-sm text-on-surface-variant">Merancang antarmuka pengguna yang intuitif dan profesional untuk sistem MONET.</p> -->
            </div>
            <!-- Member 4 -->
            <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="w-40 h-40 rounded-full overflow-hidden mb-6 border-4 border-primary/10 hover:border-primary/30 transition-colors shadow-lg shadow-outline-variant/20">
                    <img src="https://cdn-1.yourmonet.web.id/images/team/fahri.jpeg" alt="Budi Santoso" class="w-full h-full object-cover select-none" oncontextmenu="return false;" draggable="false">
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-1">Fahri Bintang M</h3>
                <p class="font-body-md text-body-md text-primary font-medium mb-3">Developer 2</p>
                <!-- <p class="font-body-sm text-body-sm text-on-surface-variant">Memastikan tidak ada celah dalam keamanan dan akurasi fungsional sistem.</p> -->
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<!-- <section class="py-32 bg-primary-fixed/5 relative overflow-hidden">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            <span class="material-symbols-outlined text-primary/20 text-[80px] mb-stack-lg block font-light">format_quote</span>
            <p class="font-display-lg text-[40px] leading-tight text-on-surface mb-20 font-light">
                "Sebelum menggunakan Monet, rekonsiliasi bulanan kami memakan waktu berminggu-minggu dengan risiko kesalahan yang tinggi. Kini, visibilitas anggaran dan jejak audit yang presisi memberikan dewan direksi kami ketenangan pikiran mutlak."
            </p>
            <div class="flex flex-col items-center justify-center">
                <div class="font-label-md text-label-md uppercase tracking-widest text-on-surface mb-2">Budi Santoso</div>
                <div class="font-body-md text-body-md text-on-surface-variant">Chief Financial Officer, Global Cipta Nusantara</div>
            </div>
        </div>
    </div>
</section> -->

<!-- Pricing Preview -->
<!-- <section class="py-32 bg-surface" id="pricing">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
        <div class="text-center max-w-3xl mx-auto mb-32">
            <h2 class="font-display-lg text-display-lg text-on-surface mb-stack-md font-light">Investasi yang Rasional</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">Struktur harga yang dirancang transparan, terintegrasi mulus dengan pertumbuhan Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl mx-auto divide-y md:divide-y-0 md:divide-x divide-outline-variant/30">

            <div class="p-16 flex flex-col items-center text-center hover:bg-surface-container-lowest transition-colors duration-500">
                <h3 class="font-label-md text-label-md uppercase tracking-[0.2em] text-on-surface-variant mb-stack-lg">Profesional</h3>
                <div class="mb-stack-md flex items-baseline justify-center">
                    <span class="font-display-lg text-[64px] font-light text-on-surface">Rp 2.5M</span>
                    <span class="font-body-lg text-body-lg text-on-surface-variant ml-2">/bulan</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mb-16 max-w-sm">Ideal untuk UKM yang membutuhkan kontrol anggaran dan pelaporan rutin.</p>
                <ul class="space-y-stack-md mb-16 text-left w-full max-w-xs mx-auto">
                    <li class="flex items-center font-body-md text-body-md text-on-surface"><span class="material-symbols-outlined text-primary text-[24px] mr-4 font-light">check</span> Hingga 5 Pengguna Akses Penuh</li>
                    <li class="flex items-center font-body-md text-body-md text-on-surface"><span class="material-symbols-outlined text-primary text-[24px] mr-4 font-light">check</span> Manajemen Anggaran Dasar</li>
                    <li class="flex items-center font-body-md text-body-md text-on-surface"><span class="material-symbols-outlined text-primary text-[24px] mr-4 font-light">check</span> Ekspor Data Standar</li>
                </ul>
                <a class="block text-center w-full max-w-xs mx-auto bg-surface border border-outline-variant text-on-surface font-label-md text-label-md py-4 rounded-full hover:bg-surface-container transition-colors" href="#">Pilih Profesional</a>
            </div>

            <div class="p-16 flex flex-col items-center text-center bg-primary-fixed/5 hover:bg-primary-fixed/10 transition-colors duration-500 relative">
                <div class="absolute top-8 right-8 text-primary font-label-sm text-label-sm uppercase tracking-widest">Paling Populer</div>
                <h3 class="font-label-md text-label-md uppercase tracking-[0.2em] text-primary mb-stack-lg">Enterprise</h3>
                <div class="mb-stack-md flex items-baseline justify-center">
                    <span class="font-display-lg text-[64px] font-light text-on-surface">Khusus</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mb-16 max-w-sm">Solusi kustom untuk entitas dengan struktur departemen kompleks.</p>
                <ul class="space-y-stack-md mb-16 text-left w-full max-w-xs mx-auto">
                    <li class="flex items-center font-body-md text-body-md text-on-surface"><span class="material-symbols-outlined text-primary text-[24px] mr-4 font-light">check</span> Pengguna Tak Terbatas (RBAC)</li>
                    <li class="flex items-center font-body-md text-body-md text-on-surface"><span class="material-symbols-outlined text-primary text-[24px] mr-4 font-light">check</span> Audit Trail Immutable</li>
                    <li class="flex items-center font-body-md text-body-md text-on-surface"><span class="material-symbols-outlined text-primary text-[24px] mr-4 font-light">check</span> Dukungan SLA 99.9% Prioritas</li>
                </ul>
                <a class="block text-center w-full max-w-xs mx-auto bg-primary text-on-primary font-label-md text-label-md py-4 rounded-full hover:bg-on-primary-fixed-variant transition-colors" href="#">Hubungi Penjualan</a>
            </div>
        </div>
    </div>
</section> -->

<!-- CTA Section -->
<section class="py-16 md:py-32 bg-surface text-center border-t border-outline-variant/30">
    <div class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop" data-aos="fade-up">
        <h2 class="font-display-lg text-4xl md:text-display-lg text-on-surface mb-stack-lg font-light">Siap Mengatur Keuangan Organisasi Anda?</h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-16 leading-relaxed">Tingkatkan presisi akuntansi dan kurangi risiko finansial dengan Monet hari ini.</p>
        <a class="inline-flex justify-center items-center bg-primary text-on-primary font-label-md text-label-md px-12 py-5 rounded-full hover:bg-on-primary-fixed-variant transition-all duration-200" href="{{ route('register') }}">
            Mulai Sekarang
        </a>
    </div>
</section>

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
