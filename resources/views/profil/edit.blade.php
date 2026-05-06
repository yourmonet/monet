<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Profil Saya - MONET</title>
<link rel="icon" type="image/png" href="https://cdn-1.yourmonet.web.id/images/monet.png">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "secondary": "#4c5d8d", "tertiary": "#7b2600", "outline-variant": "#c3c6d6",
                    "surface-container-low": "#f3f4f6", "outline": "#737685", "on-primary": "#ffffff",
                    "secondary-fixed": "#dae2ff", "inverse-surface": "#2e3132", "inverse-primary": "#b2c5ff",
                    "secondary-fixed-dim": "#b4c5fb", "on-secondary-fixed-variant": "#344573",
                    "on-secondary": "#ffffff", "error-container": "#ffdad6", "surface-variant": "#e1e2e4",
                    "surface-dim": "#d9dadc", "surface-container": "#edeef0", "surface-container-high": "#e7e8ea",
                    "on-secondary-fixed": "#021945", "on-surface-variant": "#434654", "background": "#f8f9fb",
                    "on-secondary-container": "#415382", "surface-tint": "#0c56d0", "inverse-on-surface": "#f0f1f3",
                    "surface-container-highest": "#e1e2e4", "surface-container-lowest": "#ffffff",
                    "on-primary-fixed-variant": "#0040a2", "secondary-container": "#b6c8fe", "on-primary-fixed": "#001848",
                    "on-primary-container": "#c4d2ff", "tertiary-container": "#a33500", "on-tertiary-container": "#ffc6b2",
                    "on-surface": "#191c1e", "on-error-container": "#93000a", "primary-container": "#0052cc",
                    "surface": "#f8f9fb", "on-background": "#191c1e", "primary": "#003d9b",
                    "primary-fixed": "#dae2ff", "error": "#ba1a1a"
                },
                borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.75rem", "full": "0.75rem" },
                fontFamily: { "headline": ["Manrope"], "body": ["Inter"], "label": ["Inter"] }
            },
        },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="bg-surface font-body text-on-surface">

<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-8">
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5 capitalize">{{ Auth::user()->role }}</div>
        </div>
        @if(Auth::user()->avatar)
            @php
                $av = Auth::user()->avatar;
                $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
            @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="Profile" referrerpolicy="no-referrer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-10 h-10 rounded-full object-cover shadow-sm bg-surface-container-high border border-outline-variant/30 text-on-surface-variant font-bold" style="display:none; align-items:center; justify-content:center;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @else
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>

@include('components.sidebar-bendahara')

<main class="ml-64 pt-20 p-8 min-h-screen flex justify-center">
    <div class="w-full max-w-5xl">
        <header class="mb-10">
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Profil Saya</h1>
            <p class="text-on-surface-variant font-body mt-1">Kelola data personal dan pengaturan akun Anda.</p>
        </header>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 rounded-xl border border-green-200 flex items-center gap-2">
                <span class="material-symbols-outlined text-green-700">check_circle</span>
                <p class="text-green-800 text-sm font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 rounded-xl border border-red-200 flex flex-col gap-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-700">error</span>
                    <p class="text-red-800 text-sm font-bold">Terdapat kesalahan:</p>
                </div>
                <ul class="list-disc list-inside text-red-800 text-sm ml-8">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Form Area -->
            <div class="flex-1 bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-8">
                <form action="{{ route('bendahara.profil.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Avatar Section -->
                    <div class="flex flex-col items-center gap-4 border-b border-outline-variant/30 pb-8">
                        <div class="relative group">
                            @if(Auth::user()->avatar)
                                @php $avatarUrl = Str::startsWith(Auth::user()->avatar, ['http://', 'https://']) ? Auth::user()->avatar : Storage::url(Auth::user()->avatar); @endphp
                                <img src="{{ $avatarUrl }}" id="avatar-preview" class="w-32 h-32 rounded-full object-cover border-4 border-primary-fixed shadow-md">
                            @else
                                <div id="avatar-preview" class="w-32 h-32 rounded-full bg-surface-container-highest border-4 border-primary-fixed shadow-md flex items-center justify-center text-4xl font-bold text-on-surface-variant">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col items-center">
                            <label for="avatar-input" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 border border-outline rounded-full text-sm font-semibold text-on-surface hover:bg-surface-container transition-colors">
                                <span class="material-symbols-outlined text-xl">photo_camera</span>
                                Ubah Foto
                            </label>
                            <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/jpeg, image/png, image/jpg">
                            <p class="text-xs text-outline mt-2">Format: JPG, PNG. Maks 2MB.</p>
                        </div>
                    </div>

                    <!-- Personal Info Section -->
                    <div class="flex flex-col gap-6">
                        <h2 class="text-lg font-headline font-bold text-on-surface">Informasi Personal</h2>
                        
                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Nama Lengkap</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">person</span>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all" required>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Alamat Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">mail</span>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full pl-12 pr-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all" required>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="flex flex-col gap-6 pt-6 border-t border-outline-variant/30">
                        <h2 class="text-lg font-headline font-bold text-on-surface">Keamanan & Sandi</h2>
                        
                        <div class="flex flex-col gap-2 relative">
                            <label class="text-sm font-semibold text-on-surface-variant">Password Saat Ini</label>
                            <div class="relative">
                                <input type="password" name="current_password" class="w-full px-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all pr-12 password-input">
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface toggle-password">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </div>
                            <p class="text-xs text-outline">Wajib diisi jika ingin mengubah password baru.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-2 relative">
                                <label class="text-sm font-semibold text-on-surface-variant">Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="new_password" class="w-full px-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all pr-12 password-input">
                                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface toggle-password">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                </div>
                                <p class="text-xs text-outline">Minimal 8 Karakter.</p>
                            </div>

                            <div class="flex flex-col gap-2 relative">
                                <label class="text-sm font-semibold text-on-surface-variant">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="new_password_confirmation" class="w-full px-4 py-3 bg-surface border border-outline-variant/50 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all pr-12 password-input">
                                    <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface toggle-password">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" class="flex items-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-md">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Simpan Data Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Status Area -->
            <div class="w-full lg:w-72 flex flex-col gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-outline-variant/20 p-6">
                    <h3 class="text-lg font-headline font-bold text-on-surface mb-4">Status Anda</h3>
                    <div class="flex flex-col gap-3">
                        @php
                            $roles = [
                                'Bendahara' => ['value' => 'bendahara', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'account_balance'],
                                'Pengurus' => ['value' => 'pengurus', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'icon' => 'manage_accounts'],
                                'Anggota' => ['value' => 'anggota', 'bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'icon' => 'person']
                            ];
                        @endphp

                        @foreach($roles as $label => $data)
                            <div class="flex items-center gap-3 px-4 py-3 rounded-xl border border-outline-variant/20 transition-all 
                                {{ Auth::user()->role === $data['value'] ? $data['bg'] . ' ring-2 ring-offset-1 ring-primary/30 border-transparent shadow-sm' : 'bg-surface-container opacity-60' }}">
                                <span class="material-symbols-outlined {{ Auth::user()->role === $data['value'] ? $data['text'] : 'text-outline' }}">{{ $data['icon'] }}</span>
                                <span class="font-bold text-sm {{ Auth::user()->role === $data['value'] ? $data['text'] : 'text-on-surface-variant' }}">{{ $label }}</span>
                                @if(Auth::user()->role === $data['value'])
                                    <span class="material-symbols-outlined text-sm ml-auto {{ $data['text'] }}">check_circle</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 p-4 bg-surface-container rounded-xl">
                        <p class="text-xs text-on-surface-variant text-center leading-relaxed">
                            Role Anda menentukan hak akses pada sistem MONET. Hubungi administrator jika terdapat ketidaksesuaian role.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Logout Modal --}}
<div id="logout-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="hideLogoutModal()"></div>
    <div class="bg-surface-container-lowest p-8 rounded-3xl shadow-2xl w-full max-w-sm relative z-10 transform scale-95 transition-transform duration-300">
        <div class="w-16 h-16 bg-error-container border-4 border-white shadow-sm rounded-full flex items-center justify-center text-error mb-4 mx-auto -mt-12">
            <span class="material-symbols-outlined text-3xl">logout</span>
        </div>
        <h2 class="text-2xl font-headline font-extrabold text-center text-on-surface mb-2">Keluar?</h2>
        <p class="text-center text-on-surface-variant text-sm mb-8">Anda harus login kembali untuk mengakses dashboard.</p>
        <div class="flex gap-3">
            <button onclick="hideLogoutModal()" class="flex-1 py-3 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-surface-container transition-colors">
                Batal
            </button>
            <button onclick="document.getElementById('logout-form').submit()" class="flex-1 py-3 px-4 rounded-xl bg-error text-white font-bold text-sm hover:bg-error/90 shadow-lg shadow-error/20 transition-all">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

{{-- Crop Modal --}}
<div id="crop-modal" class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-6 hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="hideCropModal()"></div>
    <div class="bg-surface-container-lowest p-5 md:p-8 rounded-3xl shadow-2xl w-full max-w-lg max-h-full flex flex-col relative z-10 transform scale-95 transition-transform duration-300 gap-5">
        <div class="flex justify-between items-center shrink-0">
            <h2 class="text-xl font-headline font-extrabold text-on-surface">Sesuaikan Foto</h2>
            <button type="button" onclick="hideCropModal()" class="text-outline hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <div class="w-full flex-1 min-h-[300px] bg-surface-container-high rounded-xl overflow-hidden border border-outline-variant/30 relative">
            <img id="crop-image" src="" class="max-w-full max-h-full block">
        </div>
        
        <div class="flex gap-3 pt-2">
            <button type="button" onclick="hideCropModal()" class="flex-1 py-3 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-surface-container transition-colors">
                Batal
            </button>
            <button type="button" id="save-crop-btn" class="flex-1 py-3 px-4 rounded-xl bg-primary text-white font-bold text-sm hover:bg-primary/90 shadow-md shadow-primary/20 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">crop</span>
                Simpan Potongan
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    // Logout Modal Logic
    const modal = document.getElementById('logout-modal');
    const modalContent = modal.querySelector('div.bg-surface-container-lowest');

    function showLogoutModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function hideLogoutModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Toggle Password Visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        });
    });

    // Avatar Preview & Cropper
    const avatarInput = document.getElementById('avatar-input');
    const avatarPreview = document.getElementById('avatar-preview');
    const cropModal = document.getElementById('crop-modal');
    const cropModalContent = cropModal.querySelector('div.bg-surface-container-lowest');
    const cropImage = document.getElementById('crop-image');
    const saveCropBtn = document.getElementById('save-crop-btn');
    let cropper = null;

    function showCropModal() {
        cropModal.classList.remove('hidden');
        setTimeout(() => {
            cropModal.classList.remove('opacity-0');
            cropModalContent.classList.remove('scale-95');
            cropModalContent.classList.add('scale-100');
        }, 10);
    }

    function hideCropModal() {
        cropModal.classList.add('opacity-0');
        cropModalContent.classList.remove('scale-100');
        cropModalContent.classList.add('scale-95');
        setTimeout(() => {
            cropModal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            // If they cancel without saving, clear the input so they can select the same file again
            if (avatarInput.dataset.cropped !== 'true') {
                avatarInput.value = '';
            }
        }, 300);
    }

    avatarInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            // Check if it's the file we just cropped to avoid loop
            if (this.dataset.cropped === 'true') {
                this.dataset.cropped = 'false';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                cropImage.src = e.target.result;
                showCropModal();
                
                if (cropper) {
                    cropper.destroy();
                }
                
                // Initialize Cropper after modal is fully visible
                setTimeout(() => {
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                }, 350);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    saveCropBtn.addEventListener('click', function() {
        if (!cropper) return;
        
        const originalText = this.innerHTML;
        this.innerHTML = '<span class="material-symbols-outlined animate-spin" style="animation: spin 1s linear infinite;">progress_activity</span> Memproses...';
        this.disabled = true;

        cropper.getCroppedCanvas({
            width: 500, // max width resolution for output
            height: 500,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        }).toBlob((blob) => {
            // Update preview
            const croppedUrl = URL.createObjectURL(blob);
            if (avatarPreview.tagName === 'IMG') {
                avatarPreview.src = croppedUrl;
            } else {
                const img = document.createElement('img');
                img.id = 'avatar-preview';
                img.src = croppedUrl;
                img.className = 'w-32 h-32 rounded-full object-cover border-4 border-primary-fixed shadow-md';
                avatarPreview.parentNode.replaceChild(img, avatarPreview);
            }

            // Create File object and set it to input
            const file = new File([blob], 'avatar_cropped.png', { type: 'image/png' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            
            // Mark input so it doesn't trigger change event logic again
            avatarInput.dataset.cropped = 'true';
            avatarInput.files = dataTransfer.files;

            // Reset button and close
            this.innerHTML = originalText;
            this.disabled = false;
            hideCropModal();
        }, 'image/png', 0.9);
    });
</script>
</body>
</html>
