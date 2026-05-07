<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;

class KategoriTransaksiController extends Controller
{
    public function index()
    {
        $kategori = KategoriTransaksi::latest()->get();
        return view('bendahara.kategori.index', compact('kategori'));
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
}