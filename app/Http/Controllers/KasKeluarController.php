<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use App\Models\KategoriTransaksi; // Wajib ditambahkan
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
 fitur-pembayaran-kasv3
        $query = KasKeluar::query();

        // Search bar (nama transaksi, kategori, deskripsi)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('sumber', 'like', "%{$search}%");
            });
        }

        // Filter tanggal (format: YYYY-MM-DD)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->input('tanggal'));
        }

        // Kategori transaksi (sumber)
        if ($request->filled('sumber')) {
            $query->where('sumber', $request->input('sumber'));
        }

        // Sorting
        $sort = $request->input('sort', 'date_desc');
        if ($sort === 'date_desc') {
            $query->orderBy('tanggal', 'desc');
        } elseif ($sort === 'date_asc') {
            $query->orderBy('tanggal', 'asc');
        } elseif ($sort === 'amount_desc') {
            $query->orderBy('nominal', 'desc');
        } elseif ($sort === 'amount_asc') {
            $query->orderBy('nominal', 'asc');
        } else {
            $query->orderBy('tanggal', 'desc');
        }

        $kasKeluar = $query->paginate(30);

        // Get unique categories for filter
        $categories = KasKeluar::select('sumber')->distinct()->pluck('sumber')->filter()->values();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('bendahara.kas-keluar._rows', compact('kasKeluar'))->render(),
                'pagination' => (string) $kasKeluar->appends($request->all())->links()
            ]);
        }

        return view('bendahara.kas-keluar.index', compact('kasKeluar', 'categories'));

        // Panggil juga relasi kategorinya agar lebih ringan dimuat
        $kasKeluar = KasKeluar::with('kategori')->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('bendahara.kas-keluar.index', compact('kasKeluar'));
main
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