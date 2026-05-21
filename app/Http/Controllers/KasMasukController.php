<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = KasMasuk::with('user');

        // Search bar (nama transaksi, kategori, deskripsi, nama anggota/penginput)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('sumber', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
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
            $query->orderBy('jumlah', 'desc');
        } elseif ($sort === 'amount_asc') {
            $query->orderBy('jumlah', 'asc');
        } else {
            $query->orderBy('tanggal', 'desc');
        }

        $kasMasuk = $query->paginate(30);

        // Get unique categories for filter
        $categories = KasMasuk::select('sumber')->distinct()->pluck('sumber')->filter()->values();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('bendahara.kas-masuk._rows', compact('kasMasuk'))->render(),
                'pagination' => (string) $kasMasuk->appends($request->all())->links()
            ]);
        }

        return view('bendahara.kas-masuk.index', compact('kasMasuk', 'categories'));
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
