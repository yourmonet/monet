<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    public function index()
    {
        $kasKeluar = KasKeluar::orderBy('tanggal', 'desc')->get();
        return view('bendahara.kas-keluar.index', compact('kasKeluar'));
    }

    public function create()
    {
        return view('bendahara.kas-keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:1',
        ]);

        KasKeluar::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('bendahara.kas-keluar.index')
            ->with('success', 'Data Kas Keluar berhasil ditambahkan.');
    }
}
