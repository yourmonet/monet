<?php

namespace App\Http\Controllers;

use App\Models\Penagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatusPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Penagihan::with(['user', 'kasMasuk']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->where('periode_bulan', $request->bulan);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('periode_tahun', $request->tahun);
        }

        // Filter role anggota
        if ($request->filled('role')) {
            $role = $request->role;
            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        // Search nama anggota
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $penagihans = $query->orderBy('periode_tahun', 'desc')
                            ->orderBy('periode_bulan', 'desc')
                            ->get();

        // View context based on role
        if (auth()->user()->role === 'pengurus') {
            return view('pengurus.status-pembayaran.index', compact('penagihans'));
        }

        return view('bendahara.status-pembayaran.index', compact('penagihans'));
    }

    public function generateBulanIni(Request $request)
    {
        // Hanya bendahara
        if (auth()->user()->role !== 'bendahara') {
            abort(403);
        }

        $request->validate([
            'generate_bulan' => 'nullable|integer|min:1|max:12',
            'generate_tahun' => 'nullable|integer|min:2000',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $bulan = $request->input('generate_bulan', Carbon::now()->month);
        $tahun = $request->input('generate_tahun', Carbon::now()->year);
        
        // Nominal iuran, bisa disesuaikan. Default 50000
        $jumlahIuran = $request->input('jumlah', 50000);

        // Hanya untuk pengurus dan bendahara (anggota tidak bayar kas)
        $pengurusDanBendahara = User::whereIn('role', ['pengurus', 'bendahara'])->get();
        $generatedCount = 0;

        foreach ($pengurusDanBendahara as $userTarget) {
            $exists = Penagihan::where('user_id', $userTarget->id)
                                ->where('periode_bulan', $bulan)
                                ->where('periode_tahun', $tahun)
                                ->exists();

            if (!$exists) {
                Penagihan::create([
                    'user_id' => $userTarget->id,
                    'periode_bulan' => $bulan,
                    'periode_tahun' => $tahun,
                    'jumlah' => $jumlahIuran,
                    'status' => 'belum_lunas'
                ]);
                $generatedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil membuat {$generatedCount} tagihan untuk periode Bulan {$bulan} Tahun {$tahun}.");
    }
}
