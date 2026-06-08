<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanDanaController extends Controller
{
    /**
     * Display a listing of all fund requests.
     */
    public function index(Request $request)
    {
        $query = PengajuanDana::with('user');

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', strtolower($request->status));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('jenis_pengajuan', 'like', "%{$search}%");
            });
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('bendahara.pengajuan-dana.index', compact('pengajuans'));
    }

    /**
     * Display the specified fund request details.
     */
    public function show($id)
    {
        $pengajuan = PengajuanDana::with(['user', 'reviewer'])->findOrFail($id);
        return view('bendahara.pengajuan-dana.show', compact('pengajuan'));
    }

    /**
     * Setujui pengajuan
     */
    public function approve(Request $request, $id)
    {
        $pengajuan = PengajuanDana::findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan dana tidak dapat diproses lagi.');
        }

        $request->validate([
            'catatan_reviewer' => 'nullable|string'
        ]);

        $pengajuan->update([
            'status' => 'approved',
            'reviewer_id' => Auth::id(),
            'reviewed_at' => now(),
            'catatan_reviewer' => $request->catatan_reviewer,
        ]);

        return redirect()->route('bendahara.pengajuan-dana.index')
            ->with('success', 'Pengajuan dana berhasil disetujui.');
    }

    /**
     * Tolak pengajuan
     */
    public function reject(Request $request, $id)
    {
        $pengajuan = PengajuanDana::findOrFail($id);

        if ($pengajuan->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan dana tidak dapat diproses lagi.');
        }

        $request->validate([
            'catatan_reviewer' => 'nullable|string'
        ]);

        $pengajuan->update([
            'status' => 'rejected',
            'reviewer_id' => Auth::id(),
            'reviewed_at' => now(),
            'catatan_reviewer' => $request->catatan_reviewer,
        ]);

        return redirect()->route('bendahara.pengajuan-dana.index')
            ->with('success', 'Pengajuan dana telah ditolak.');
    }
}
