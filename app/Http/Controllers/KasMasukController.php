<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use App\Models\KategoriTransaksi; // Wajib ditambahkan agar sistem mengenali model Kategori
use Illuminate\Http\Request;

class KasMasukController extends Controller
{
    public function index(Request $request)
    {
fitur-pembayaran-kasv3
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

        // Mengurutkan berdasarkan tanggal terbaru, lalu waktu input (created_at) terbaru
        // Ditambahkan with('kategori') agar nama kategori langsung ditarik dari database dengan efisien
        $kasMasuk = KasMasuk::with('kategori')->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->get();
        return view('bendahara.kas-masuk.index', compact('kasMasuk'));
main
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
