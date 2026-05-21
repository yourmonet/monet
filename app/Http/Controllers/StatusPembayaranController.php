<?php

namespace App\Http\Controllers;

use App\Models\PembayaranKas;
use App\Models\TagihanKas;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatusPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = PembayaranKas::with(['user', 'tagihanKas']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $bulan = sprintf('%02d', $request->bulan);
            $query->where('periode', 'like', "%-{$bulan}");
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('periode', 'like', "{$request->tahun}-%");
        }

        // Filter role (hanya bendahara & pengurus)
        if ($request->filled('role')) {
            $role = $request->role;
            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        } else {
            // Default only load pengurus and bendahara
            $query->whereHas('user', function ($q) {
                $q->whereIn('role', ['pengurus', 'bendahara']);
            });
        }

        // Search nama anggota
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan periode terbaru (karena format periode YYYY-MM bisa disorting langsung)
        $pembayarans = $query->orderBy('periode', 'desc')
                            ->paginate(30);

        // View context based on role
        if (Auth::user()->role === 'pengurus') {
            return view('pengurus.status-pembayaran.index', compact('pembayarans'));
        }

        return view('bendahara.status-pembayaran.index', compact('pembayarans'));
    }

    public function generateBulanIni(Request $request)
    {
        // Hanya bendahara
        if (Auth::user()->role !== 'bendahara') {
            abort(403);
        }

        $request->validate([
            'generate_bulan' => 'nullable|integer|min:1|max:12',
            'generate_tahun' => 'nullable|integer|min:2000',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $bulan = $request->input('generate_bulan', Carbon::now()->month);
        $tahun = $request->input('generate_tahun', Carbon::now()->year);
        $jumlahIuran = $request->input('jumlah', 25000); // Default to 25.000 for Monet

        // Cek apakah TagihanKas untuk bulan & tahun ini sudah dibuat
        $tagihanExist = TagihanKas::where('periode_bulan', $bulan)
                                  ->where('periode_tahun', $tahun)
                                  ->first();

        if ($tagihanExist) {
            return redirect()->back()->with('error', "Tagihan bulan ini sudah tersedia!");
        }

        // Buat master TagihanKas
        $tagihan = TagihanKas::create([
            'periode_bulan' => $bulan,
            'periode_tahun' => $tahun,
            'nominal' => $jumlahIuran,
            'created_by' => Auth::id()
        ]);

        // Cari semua user bendahara & pengurus
        $pengurusDanBendahara = User::whereIn('role', ['pengurus', 'bendahara'])->get();
        $generatedCount = 0;

        $periodeString = sprintf('%04d-%02d', $tahun, $bulan);

        foreach ($pengurusDanBendahara as $userTarget) {
            // Pastikan belum ada pembayaran kas untuk periode ini
            $exists = PembayaranKas::where('user_id', $userTarget->id)
                                ->where('periode', $periodeString)
                                ->exists();

            if (!$exists) {
                PembayaranKas::create([
                    'user_id' => $userTarget->id,
                    'tagihan_kas_id' => $tagihan->id,
                    'periode' => $periodeString,
                    'nominal' => $jumlahIuran,
                    'status' => 'Belum Bayar'
                ]);
                $generatedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil membuat {$generatedCount} tagihan untuk periode Bulan {$bulan} Tahun {$tahun}.");
    }
}
