<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use Illuminate\Http\Request;

class KasKeluarController extends Controller
{
    public function index(Request $request)
    {
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
            'sumber' => 'required|string',
            'nominal' => 'required|numeric|min:1',
        ]);

        KasKeluar::create([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'sumber' => $request->sumber,
            'nominal' => $request->nominal,
        ]);

        return redirect()->route('bendahara.kas-keluar.index')
            ->with('success', 'Data Kas Keluar berhasil ditambahkan.');
    }
}
