@forelse($kasKeluar as $kk)
    <tr class="hover:bg-surface/50 transition-colors group">
        <td class="px-6 py-4 text-on-surface-variant font-medium whitespace-nowrap">
            {{ \Carbon\Carbon::parse($kk->tanggal)->translatedFormat('d F Y') }}
        </td>
        <td class="px-6 py-4">
            <div class="font-bold text-on-surface">{{ $kk->keterangan }}</div>
        </td>
        <td class="px-6 py-4 capitalize font-semibold text-on-surface-variant">
            {{ $kk->sumber }}
        </td>
        <td class="px-6 py-4 text-center">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-bold bg-success-container/70 text-on-success-container border border-success/20">
                <span class="w-1.5 h-1.5 rounded-full bg-success"></span>
                LUNAS
            </span>
        </td>
        <td class="px-6 py-4 text-right font-black text-red-600">
            Rp {{ number_format($kk->nominal, 0, ',', '.') }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-16 text-center text-on-surface-variant">
            <div class="flex flex-col items-center justify-center py-6">
                <span class="material-symbols-outlined text-5xl mb-3 text-outline-variant">search_off</span>
                <p class="font-bold text-lg text-on-surface">Data transaksi tidak ditemukan</p>
                <p class="text-xs text-on-surface-variant/80 mt-1 font-medium max-w-sm leading-relaxed">
                    Coba sesuaikan kata kunci pencarian Anda atau reset filter untuk menampilkan semua data.
                </p>
            </div>
        </td>
    </tr>
@endforelse
