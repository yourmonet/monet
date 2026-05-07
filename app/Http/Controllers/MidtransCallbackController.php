<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY', config('midtrans.server_key'));
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $grossAmount = $notification->gross_amount;
            $orderId = $notification->order_id;
        } catch (\Exception $e) {
            // Fallback apabila class Notification gagal memproses payload lokal
            $transactionStatus = $request->transaction_status;
            $grossAmount = $request->gross_amount;
            $orderId = $request->order_id;
        }

        if ($transactionStatus == 'settlement') {
            $penagihan = null;

            if ($orderId && strpos($orderId, 'PENAGIHAN-') === 0) {
                $penagihanId = str_replace('PENAGIHAN-', '', $orderId);
                $penagihan = \App\Models\Penagihan::find($penagihanId);
            }

            $keterangan = $penagihan 
                ? 'Pembayaran Tagihan Kas Bulan ' . $penagihan->periode_bulan . ' Tahun ' . $penagihan->periode_tahun 
                : 'Pembayaran dari Midtrans';

            $kasMasuk = KasMasuk::create([
                'tanggal' => now(),
                'keterangan' => $keterangan,
                'jumlah' => (int) $grossAmount,
                'sumber' => 'midtrans',
                'user_id' => $penagihan ? $penagihan->user_id : null,
            ]);

            if ($penagihan) {
                $penagihan->update([
                    'status' => 'lunas',
                    'kas_masuk_id' => $kasMasuk->id,
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function handleCallbackKeluar(Request $request)
    {
        try {
            $status = $request->status ?? $request->transaction_status;
            $amount = $request->amount ?? $request->gross_amount;

            // Di Midtrans IRIS (Payouts), status sukses biasanya 'approved' atau 'completed'. 
            // Kita juga accept 'settlement' agar mudah untuk simulasi.
            if (in_array($status, ['approved', 'completed', 'settlement'])) {
                KasKeluar::create([
                    'tanggal' => now(),
                    'keterangan' => 'Pengeluaran via Midtrans (Payout)',
                    'nominal' => (int) $amount,
                ]);
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'ignored']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
