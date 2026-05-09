<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use App\Models\KategoriTransaksi; // Wajib ditambahkan agar sistem mengenali model Kategori
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan tanggal terbaru, lalu waktu input (created_at) terbaru
        // Ditambahkan with('kategori') agar nama kategori langsung ditarik dari database dengan efisien
        $kasMasuk = KasMasuk::with('kategori')->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('bendahara.kas-masuk.index', compact('kasMasuk'));
    }

    public function create()
    {
        // Ambil HANYA kategori yang jenisnya 'pemasukan'
        $kategori = KategoriTransaksi::where('jenis', 'pemasukan')->get();
        return view('bendahara.kas-masuk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori_id' => 'required|exists:kategori_transaksis,id', // Validasi kategori wajib diisi
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'sumber' => 'required|string'
        ]);

        KasMasuk::create([
            'tanggal' => $request->tanggal,
            'kategori_id' => $request->kategori_id, // Simpan ID kategori ke database
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'sumber' => $request->sumber,
        ]);

        return redirect()->route('bendahara.kas-masuk.index')
            ->with('success', 'Data Kas Masuk berhasil ditambahkan.');
    }
}
