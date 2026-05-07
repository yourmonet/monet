<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SimulasiLunasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kas:simulasi-lunas {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mensimulasikan pembayaran kas menjadi LUNAS untuk 1 tagihan saja';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $tagihan = \App\Models\Penagihan::find($id);

        if (!$tagihan) {
            $this->error("[ERROR] Tagihan ID {$id} tidak ditemukan");
            return;
        }

        if ($tagihan->status === 'lunas') {
            $this->info("[INFO] Tagihan ID {$id} sudah LUNAS");
            return;
        }

        // Simulasikan pembayaran sukses (buat KasMasuk)
        $kasMasuk = \App\Models\KasMasuk::create([
            'tanggal' => now(),
            'keterangan' => 'Pembayaran Tagihan Kas Bulan ' . $tagihan->periode_bulan . ' Tahun ' . $tagihan->periode_tahun . ' (Simulasi)',
            'jumlah' => $tagihan->jumlah,
            'sumber' => 'simulasi_command',
            'user_id' => $tagihan->user_id,
        ]);

        $tagihan->update([
            'status' => 'lunas',
            'kas_masuk_id' => $kasMasuk->id,
        ]);

        $this->info("[OK] Tagihan ID {$id} berhasil disimulasikan menjadi LUNAS");
    }
}
