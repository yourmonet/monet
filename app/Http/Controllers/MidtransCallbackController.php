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

            if ($transactionStatus == 'settlement') {
                KasMasuk::create([
                    'tanggal' => now(),
                    'keterangan' => 'Pembayaran dari Midtrans',
                    'jumlah' => (int) $grossAmount,
                    'sumber' => 'midtrans',
                ]);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Fallback apabila class Notification gagal memproses payload lokal
            $transactionStatus = $request->transaction_status;
            $grossAmount = $request->gross_amount;

            if ($transactionStatus == 'settlement') {
                KasMasuk::create([
                    'tanggal' => now(),
                    'keterangan' => 'Pembayaran dari Midtrans',
                    'jumlah' => (int) $grossAmount,
                    'sumber' => 'midtrans',
                ]);
                return response()->json(['status' => 'success']);
            }

            return response()->json(['error' => $e->getMessage()], 500);
        }
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
