<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;

class KategoriTransaksiController extends Controller
{
    public function index()
    {
        $kategori = KategoriTransaksi::latest()->get();
        
        // Menghitung statistik untuk Kartu Ringkasan (Metric Cards)
        $totalKategori = $kategori->count();
        $totalPemasukan = $kategori->where('jenis', 'pemasukan')->count();
        $totalPengeluaran = $kategori->where('jenis', 'pengeluaran')->count();

        return view('bendahara.kategori.index', compact('kategori', 'totalKategori', 'totalPemasukan', 'totalPengeluaran'));
    }

    public function create()
    {
        return view('bendahara.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'nullable|string'
        ]);

        KategoriTransaksi::create($request->all());

        return redirect()->route('bendahara.kategori.index')
            ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit
    public function edit(KategoriTransaksi $kategori)
    {
        return view('bendahara.kategori.edit', compact('kategori'));
    }

    // Memproses perubahan data dari form edit
    public function update(Request $request, KategoriTransaksi $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update($request->all());

        return redirect()->route('bendahara.kategori.index')
            ->with('success', 'Data Kategori berhasil diperbarui!');
    }

    // Menghapus data kategori
    public function destroy(KategoriTransaksi $kategori)
    {
        $kategori->delete();

        return redirect()->route('bendahara.kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}