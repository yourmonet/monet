<?php

namespace App\Observers;

use App\Models\PembayaranKas;
use App\Models\KasMasuk;
use App\Models\KategoriTransaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranKasObserver
{
    /**
     * Handle the PembayaranKas "created" event.
     */
    public function created(PembayaranKas $pembayaranKas): void
    {
        $this->handlePaymentStatus($pembayaranKas);
    }

    /**
     * Handle the PembayaranKas "updated" event.
     */
    public function updated(PembayaranKas $pembayaranKas): void
    {
        $this->handlePaymentStatus($pembayaranKas);
    }

    /**
     * Handle the PembayaranKas "deleted" event.
     */
    public function deleted(PembayaranKas $pembayaranKas): void
    {
        $this->removeKasMasuk($pembayaranKas);
    }

    /**
     * Handle the PembayaranKas status to verify if we need to create or delete KasMasuk.
     */
    protected function handlePaymentStatus(PembayaranKas $pembayaranKas): void
    {
        if ($pembayaranKas->status === 'Lunas') {
            $this->createOrUpdateKasMasuk($pembayaranKas);
        } else {
            $this->removeKasMasuk($pembayaranKas);
        }
    }

    /**
     * Create or update KasMasuk for the given PembayaranKas.
     */
    protected function createOrUpdateKasMasuk(PembayaranKas $pembayaranKas): void
    {
        // Get or create category for "Pembayaran Kas"
        $kategori = KategoriTransaksi::firstOrCreate(
            ['nama_kategori' => 'Pembayaran Kas', 'jenis' => 'pemasukan'],
            ['deskripsi' => 'Kategori otomatis untuk iuran bulanan kas anggota.']
        );

        // Find existing KasMasuk for this PembayaranKas to prevent duplication
        $kasMasuk = KasMasuk::where('pembayaran_kas_id', $pembayaranKas->id)->first();

        // Get user_id of the person who input/approved the transaction
        // Since it's an observer, auth()->id() is the current logged-in user (usually bendahara)
        // If not authenticated (e.g. system/console/webhook/tinker), fallback to user who paid.
        $userIdPenginput = Auth::id() ?? $pembayaranKas->user_id;

        // Generate keterangan containing: Pembayaran Iuran Bulanan - [Nama Anggota]
        $pembayaranKas->loadMissing('user');
        $namaAnggota = $pembayaranKas->user ? $pembayaranKas->user->name : 'Anggota';
        $keterangan = "Pembayaran Iuran Bulanan - " . $namaAnggota;

        // Date of payment: if updated_at is available, use that, else use today's date
        $tanggalPembayaran = $pembayaranKas->updated_at ? $pembayaranKas->updated_at->toDateString() : Carbon::now()->toDateString();

        if ($kasMasuk) {
            // Update if already exists (just in case fields changed)
            $kasMasuk->update([
                'tanggal' => $tanggalPembayaran,
                'keterangan' => $keterangan,
                'jumlah' => $pembayaranKas->nominal,
                'sumber' => 'Pembayaran Kas',
                'user_id' => $userIdPenginput,
                'kategori_id' => $kategori->id,
            ]);
        } else {
            // Create new transaction
            KasMasuk::create([
                'tanggal' => $tanggalPembayaran,
                'keterangan' => $keterangan,
                'jumlah' => $pembayaranKas->nominal,
                'sumber' => 'Pembayaran Kas',
                'user_id' => $userIdPenginput,
                'kategori_id' => $kategori->id,
                'pembayaran_kas_id' => $pembayaranKas->id,
            ]);
        }
    }

    /**
     * Remove KasMasuk associated with the given PembayaranKas.
     */
    protected function removeKasMasuk(PembayaranKas $pembayaranKas): void
    {
        $kasMasuk = KasMasuk::where('pembayaran_kas_id', $pembayaranKas->id)->first();
        if ($kasMasuk) {
            $kasMasuk->delete();
        }
    }
}
