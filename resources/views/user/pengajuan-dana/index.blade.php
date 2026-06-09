<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Pengajuan Dana/Bantuan — MONET</title>
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
                    "primary-fixed": "#dae2ff", "error": "#ba1a1a",
                    "success": "#198754", "success-container": "#d1e7dd", "on-success-container": "#0f5132",
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

{{-- Navigation --}}
<nav class="fixed top-0 w-full z-50 bg-gray-50/85 backdrop-blur-md shadow-sm flex justify-between items-center px-4 md:px-8 h-16 font-headline antialiased">
    <div class="flex items-center gap-4 md:gap-8">
        <button onclick="toggleSidebar()" class="md:hidden mr-2 text-on-surface hover:text-primary transition-colors flex items-center"><span class="material-symbols-outlined text-[28px]">menu</span></button>
        <img src="https://cdn-1.yourmonet.web.id/images/monet2.png" alt="MONET" class="h-8 w-auto object-contain"/>
    </div>
    <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
            <div class="text-sm font-black text-blue-900 leading-tight">{{ Auth::user()->name }}</div>
            <div class="text-[10px] uppercase tracking-widest text-outline font-bold mt-0.5">{{ ucfirst(Auth::user()->role) }}</div>
        </div>
        @if(Auth::user()->avatar)
            @php
                $av = Auth::user()->avatar;
                $avatarUrl = (str_starts_with($av, 'http://') || str_starts_with($av, 'https://')) ? $av : '/storage/' . $av;
            @endphp
            <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full object-cover shadow-sm" alt="Profile" referrerpolicy="no-referrer" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-10 h-10 rounded-full object-cover bg-surface-container-high border border-outline-variant/30 text-on-surface-variant font-bold flex items-center justify-center hidden" style="display:none;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @else
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white text-sm font-bold shadow-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </div>
</nav>

{{-- Sidebar --}}
@include('components.sidebar-anggota')

{{-- Main Content --}}
<main class="md:ml-64 pt-20 p-4 pt-20 md:p-8 md:pt-20 min-h-screen">
    <header class="flex justify-between items-end mb-10">
        <div>
            <div class="flex items-center gap-2 text-sm text-on-surface-variant font-medium mb-1">
                <a href="{{ route('user.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
                <span class="text-primary font-semibold">Pengajuan Dana</span>
            </div>
            <h1 class="text-4xl font-headline font-extrabold tracking-tight text-on-surface">Riwayat Pengajuan Dana</h1>
            <p class="text-on-surface-variant font-body mt-1">Ajukan permohonan dana atau bantuan sosial untuk kebutuhan mendesak.</p>
        </div>
        <div>
            <a href="{{ route('user.pengajuan-dana.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-2xl text-sm font-bold hover:bg-primary/95 transition shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-lg">add</span>
                Buat Pengajuan
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-success-container rounded-3xl border border-success/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-success">check_circle</span>
            <p class="text-on-success-container text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-surface-container border-b border-outline-variant/30 text-on-surface-variant uppercase text-[11px] font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Tgl Pengajuan</th>
                        <th class="px-6 py-4">Jenis Pengajuan</th>
                        <th class="px-6 py-4 text-right">Jumlah Dana</th>
                        <th class="px-6 py-4">Kontak & Rekening</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Catatan Pengurus</th>
                        <th class="px-6 py-4 text-center">Dokumen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse ($myPengajuan as $item)
                        <tr class="hover:bg-surface/50 transition-colors cursor-pointer" onclick="openDetailModal('{{ $item->id }}')">
                            <td class="px-6 py-4 font-medium text-on-surface-variant">
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-on-surface">
                                {{ $item->jenis_pengajuan }}
                            </td>
                            <td class="px-6 py-4 text-right font-extrabold text-primary">
                                Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div class="font-bold text-on-surface">{{ $item->no_telp }}</div>
                                <div class="text-on-surface-variant mt-0.5">{{ $item->nama_bank }} - {{ $item->no_rekening }}</div>
                                <div class="text-outline text-[10px] italic">a.n. {{ $item->nama_rekening }}</div>
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant max-w-xs truncate" title="{{ $item->keterangan }}">
                                {{ $item->keterangan }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status === 'Disetujui')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-success-container/70 text-on-success-container border border-success/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                                        DISETUJUI
                                    </span>
                                @elseif ($item->status === 'Ditolak')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-error-container/70 text-on-error-container border border-error/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                        DITOLAK
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-bold bg-yellow-100 text-yellow-850 border border-yellow-250" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #ffc107"></span>
                                        PENDING
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-on-surface-variant italic max-w-xs truncate" title="{{ $item->catatan_pengurus }}">
                                @if($item->status === 'Disetujui')
                                    {{ $item->approval_note ?: 'Disetujui oleh Bendahara' }}
                                @elseif($item->status === 'Ditolak')
                                    {{ $item->rejection_reason }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                                @if ($item->file_pendukung)
                                    <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-primary font-bold hover:underline">
                                        <span class="material-symbols-outlined text-sm">download</span> Unduh
                                    </a>
                                @else
                                    <span class="text-xs text-outline">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-3 text-outline-variant">inbox</span>
                                    <p class="font-medium">Belum ada pengajuan dana.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-outline-variant/30">
            {{ $myPengajuan->links() }}
        </div>
    </div>
</main>

{{-- DETAIL PENGAJUAN MODAL --}}
<div id="detail-modal" class="fixed inset-0 z-50 hidden bg-on-surface/50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-surface-container-lowest rounded-3xl w-full max-w-2xl mx-4 overflow-hidden shadow-xl transform transition-all flex flex-col max-h-[85vh]">
        <div class="px-6 py-5 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-xl font-headline font-bold text-on-surface">Detail Pengajuan Dana</h3>
            <button onclick="closeDetailModal()" class="text-on-surface-variant hover:text-error transition">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 space-y-6 overflow-y-auto flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- DATA PEMOHON -->
                <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                    <h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-lg">person</span> DATA PEMOHON
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-on-surface-variant font-medium">Nama Pemohon:</span>
                            <p id="det-nama" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Email:</span>
                            <p id="det-email" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Nomor HP / Kontak:</span>
                            <p id="det-telp" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                    </div>
                </div>

                <!-- DATA REKENING -->
                <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                    <h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-lg">account_balance</span> DATA REKENING
                    </h4>
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-on-surface-variant font-medium">Nama Bank:</span>
                            <p id="det-bank" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Nomor Rekening:</span>
                            <p id="det-norek" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                        <div>
                            <span class="text-on-surface-variant font-medium">Nama Pemilik Rekening:</span>
                            <p id="det-pemilik" class="font-bold text-on-surface mt-0.5">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA PENGAJUAN -->
            <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                <h4 class="text-sm font-bold text-primary mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">payments</span> DATA PENGAJUAN
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-on-surface-variant font-medium">Kategori / Jenis Pengajuan:</span>
                        <p id="det-kategori" class="font-bold text-on-surface mt-0.5">-</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant font-medium">Nominal Pengajuan:</span>
                        <p id="det-nominal" class="text-sm font-black text-primary mt-0.5">Rp -</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-on-surface-variant font-medium">Keterangan:</span>
                        <p id="det-keterangan" class="font-medium text-on-surface mt-0.5 whitespace-pre-line bg-white p-3 rounded-xl border border-outline-variant/10">-</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant font-medium">Tanggal Pengajuan:</span>
                        <p id="det-tanggal" class="font-bold text-on-surface mt-0.5">-</p>
                    </div>
                    <div>
                        <span class="text-on-surface-variant font-medium">Lampiran / Dokumen Pendukung:</span>
                        <div id="det-lampiran" class="mt-1">
                            <!-- JS will inject link -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMELINE STATUS -->
            <div class="bg-surface-container/30 p-5 rounded-2xl border border-outline-variant/20">
                <h4 class="text-sm font-bold text-primary mb-4 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">route</span> TIMELINE STATUS
                </h4>
                <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-outline-variant/30" id="det-timeline">
                    <!-- Dynamic timeline rows injected by JS -->
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-outline-variant/30 flex justify-end items-center bg-surface-container/20">
            <button type="button" onclick="closeDetailModal()" class="py-2 px-4 rounded-xl border border-outline-variant/30 text-on-surface-variant font-bold text-xs hover:bg-surface-container transition">
                Tutup
            </button>
        </div>
    </div>
</div>

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

<script>
    const logoutModal = document.getElementById('logout-modal');
    const modalContent = logoutModal.querySelector('div.bg-surface-container-lowest');

    function showLogoutModal() {
        logoutModal.classList.remove('hidden');
        setTimeout(() => {
            logoutModal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function hideLogoutModal() {
        logoutModal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            logoutModal.classList.add('hidden');
        }, 300);
    }

    // Load and Open Detail Modal
    function openDetailModal(id) {
        fetch('/user/pengajuan-dana/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('det-nama').innerText = data.user.name;
                document.getElementById('det-email').innerText = data.user.email;
                document.getElementById('det-telp').innerText = data.no_telp || data.user.phone_number || '—';

                document.getElementById('det-bank').innerText = data.nama_bank || '—';
                document.getElementById('det-norek').innerText = data.no_rekening || '—';
                document.getElementById('det-pemilik').innerText = data.nama_rekening || '—';

                document.getElementById('det-kategori').innerText = data.jenis_pengajuan;
                
                const formattedNominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.jumlah_dana);
                document.getElementById('det-nominal').innerText = formattedNominal;
                document.getElementById('det-keterangan').innerText = data.keterangan;

                const date = new Date(data.created_at);
                const options = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
                document.getElementById('det-tanggal').innerText = date.toLocaleDateString('id-ID', options) + ' WIB';

                // Lampiran Link
                const lampiranContainer = document.getElementById('det-lampiran');
                if (data.file_pendukung) {
                    lampiranContainer.innerHTML = `
                        <a href="/storage/${data.file_pendukung}" target="_blank" class="inline-flex items-center gap-1 text-xs text-primary font-bold hover:underline">
                            <span class="material-symbols-outlined text-sm">download</span> Unduh Dokumen Pendukung
                        </a>
                    `;
                } else {
                    lampiranContainer.innerHTML = '<span class="text-outline-variant">—</span>';
                }

                // Timeline Status rendering
                const timelineContainer = document.getElementById('det-timeline');
                timelineContainer.innerHTML = '';

                // Step 1: Created
                let timelineHtml = `
                    <div class="relative flex gap-3">
                        <div class="absolute -left-6 mt-1 w-4 h-4 rounded-full bg-success flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-on-surface">Pengajuan Dibuat</h5>
                            <p class="text-[10px] text-on-surface-variant mt-0.5">${date.toLocaleDateString('id-ID', options)} WIB</p>
                            <p class="text-[11px] text-outline-variant mt-1">Pengajuan berhasil dikirimkan ke sistem.</p>
                        </div>
                    </div>
                `;

                // Step 2: Waiting Approval
                let statusClass = data.status === 'Pending' ? 'bg-yellow-400' : 'bg-success';
                timelineHtml += `
                    <div class="relative flex gap-3">
                        <div class="absolute -left-6 mt-1 w-4 h-4 rounded-full ${statusClass} flex items-center justify-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-on-surface">Menunggu Persetujuan</h5>
                            <p class="text-[11px] text-outline-variant mt-1">Menunggu verifikasi dan keputusan dari Bendahara.</p>
                        </div>
                    </div>
                `;

                // Step 3: Approved or Rejected
                if (data.status !== 'Pending') {
                    let finalStatusTitle = data.status === 'Disetujui' ? 'Disetujui' : 'Ditolak';
                    let finalColorClass = data.status === 'Disetujui' ? 'bg-success' : 'bg-error';
                    let finalNote = data.status === 'Disetujui' ? (data.approval_note || 'Disetujui oleh Bendahara.') : (data.rejection_reason || 'Ditolak oleh Bendahara.');
                    let approverName = data.status === 'Disetujui' ? (data.approved_by ? data.approved_by.name : 'Bendahara') : (data.rejected_by ? data.rejected_by.name : 'Bendahara');
                    let approvalDateStr = '';
                    
                    if (data.status === 'Disetujui' && data.approved_at) {
                        approvalDateStr = new Date(data.approved_at).toLocaleDateString('id-ID', options) + ' WIB';
                    } else if (data.status === 'Ditolak' && data.rejected_at) {
                        approvalDateStr = new Date(data.rejected_at).toLocaleDateString('id-ID', options) + ' WIB';
                    }

                    timelineHtml += `
                        <div class="relative flex gap-3">
                            <div class="absolute -left-6 mt-1 w-4 h-4 rounded-full ${finalColorClass} flex items-center justify-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-on-surface">${finalStatusTitle}</h5>
                                <p class="text-[10px] text-on-surface-variant mt-0.5">${approvalDateStr}</p>
                                <p class="text-[11px] text-outline mt-1 font-semibold font-body">Oleh: ${approverName}</p>
                                <p class="text-[11px] text-on-surface italic mt-1 bg-white p-2 rounded-lg border border-outline-variant/20 mt-2 font-medium">"${finalNote}"</p>
                            </div>
                        </div>
                    `;
                }

                timelineContainer.innerHTML = timelineHtml;

                document.getElementById('detail-modal').classList.remove('hidden');
            });
    }

    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }
</script>
</body>
</html>
