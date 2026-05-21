<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PembayaranKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranKasController extends Controller
{
    /**
     * Display the member's payment page, billing status, and history.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Cek jika user bukan pengurus atau bendahara, jangan boleh akses form pembayaran
        if (!in_array($user->role, ['pengurus', 'bendahara'])) {
            return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki tagihan pembayaran kas.');
        }
        
        // Year filter for billing status grid
        $selectedYear = $request->input('billing_tahun', Carbon::now()->year);
        
        // List of Indonesian month names
        $monthsList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        // Hanya ambil tagihan kas yang sudah dibuat oleh bendahara (yang ada di tabel pembayaran_kas)
        $payments = PembayaranKas::where('user_id', $user->id)
            ->where('periode', 'like', "{$selectedYear}-%")
            ->orderBy('periode', 'asc')
            ->get();
            
        $billings = [];
        foreach ($payments as $payment) {
            $parts = explode('-', $payment->periode);
            $year = $parts[0];
            $monthNum = (int)$parts[1];
            $monthName = $monthsList[$monthNum] ?? '';
            
            $billings[] = [
                'id' => $payment->id, // ID untuk dipakai saat update
                'periode_code' => $payment->periode,
                'periode_label' => "{$monthName} {$year}",
                'nominal' => $payment->nominal,
                'status' => $payment->status,
                'payment' => $payment,
            ];
        }

        // Fetch payment history with filters
        $historyQuery = PembayaranKas::where('user_id', $user->id)
                                    ->whereNotNull('bukti_pembayaran'); // Hanya riwayat yang sudah pernah bayar

        if ($request->filled('status')) {
            $historyQuery->where('status', $request->status);
        }

        if ($request->filled('bulan')) {
            $monthVal = sprintf('%02d', $request->bulan);
            $historyQuery->where('periode', 'like', "%-{$monthVal}");
        }

        if ($request->filled('tahun')) {
            $historyQuery->where('periode', 'like', "{$request->tahun}-%");
        }

        $riwayat = $historyQuery->orderBy('updated_at', 'desc')->paginate(10);

        // Fetch years list for filter dropdown (dynamic based on current year or existing bills)
        $yearsList = range(Carbon::now()->year - 2, Carbon::now()->year + 2);

        return view('user.pembayaran.index', compact(
            'billings', 
            'riwayat', 
            'selectedYear', 
            'monthsList', 
            'yearsList'
        ));
    }

    /**
     * Store a newly uploaded proof of payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pembayaran_id' => ['required', 'exists:pembayaran_kas,id'],
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], [
            'pembayaran_id.required' => 'Periode pembayaran wajib dipilih.',
            'pembayaran_id.exists' => 'Tagihan kas tidak ditemukan.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.image' => 'File bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar harus berupa jpeg, jpg, atau png.',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        $user = Auth::user();
        
        // Cari tagihan yang dipilih milik user ini
        $pembayaran = PembayaranKas::where('id', $request->pembayaran_id)
                                   ->where('user_id', $user->id)
                                   ->first();

        if (!$pembayaran) {
            return redirect()->back()->with('error', "Tagihan tidak ditemukan atau bukan milik Anda.");
        }

        if (in_array($pembayaran->status, ['Lunas', 'Menunggu Verifikasi'])) {
            $statusText = $pembayaran->status === 'Lunas' ? 'Lunas' : 'Menunggu Verifikasi';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Anda sudah melakukan pembayaran untuk periode ini dengan status: {$statusText}."
                ], 422);
            }
            return redirect()->back()->with('error', "Anda sudah melakukan pembayaran untuk periode ini dengan status: {$statusText}.");
        }

        // Simpan bukti pembayaran ke public disk
        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

        // Update record pembayaran
        $pembayaran->update([
            'bukti_pembayaran' => $path,
            'catatan' => $request->catatan,
            'status' => 'Menunggu Verifikasi',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diunggah dan status menunggu verifikasi.',
                'data' => $pembayaran
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
