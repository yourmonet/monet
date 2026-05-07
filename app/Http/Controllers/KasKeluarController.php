<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use App\Models\KategoriTransaksi; // Wajib ditambahkan
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    public function index()
    {
        // Panggil juga relasi kategorinya agar lebih ringan dimuat
        $kasKeluar = KasKeluar::with('kategori')->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('bendahara.kas-keluar.index', compact('kasKeluar'));
    }

    public function create()
    {
        // Ambil HANYA kategori yang jenisnya 'pengeluaran'
        $kategori = KategoriTransaksi::where('jenis', 'pengeluaran')->get();
        return view('bendahara.kas-keluar.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategori_transaksis,id', // Validasi kategori
            'keterangan' => 'required|string|max:255',
            'sumber' => 'required|string',
            'nominal' => 'required|numeric|min:1',
        ]);

        KasKeluar::create([
            'tanggal' => $request->tanggal,
            'kategori_id' => $request->kategori_id, // Simpan kategori_id ke database
            'keterangan' => $request->keterangan,
            'sumber' => $request->sumber,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('bendahara.kas-keluar.index')
            ->with('success', 'Data Kas Keluar berhasil ditambahkan.');
    }
}