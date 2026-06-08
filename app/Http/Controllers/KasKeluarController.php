<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use App\Models\KategoriTransaksi; // Wajib ditambahkan
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = KasKeluar::with('kategori');

        // Search bar
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function ($qu) use ($search) {
                      $qu->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->input('tanggal'));
        }

        // Filter sumber
        if ($request->filled('sumber')) {
            $query->where('sumber', $request->input('sumber'));
        }

        // Sorting
        $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        $kasKeluar = $query->paginate(30);

        // Get unique sumber values for filter dropdown
        $categories = KasKeluar::select('sumber')->distinct()->pluck('sumber');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('bendahara.kas-keluar._rows', compact('kasKeluar'))->render(),
                'pagination' => (string) $kasKeluar->appends($request->all())->links()
            ]);
        }

        return view('bendahara.kas-keluar.index', compact('kasKeluar', 'categories'));
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