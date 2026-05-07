<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan tanggal terbaru, lalu berdasarkan waktu input (created_at) terbaru
        $kasMasuk = KasMasuk::orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('bendahara.kas-masuk.index', compact('kasMasuk'));
    }

    public function create()
    {
        return view('bendahara.kas-masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'sumber' => 'nullable|string'
        ]);

        KasMasuk::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'sumber' => $request->sumber ?? 'manual',
        ]);

        return redirect()->route('bendahara.kas-masuk.index')
            ->with('success', 'Data Kas Masuk berhasil ditambahkan.');
    }
}
