<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanDanaController extends Controller
{
    /**
     * Display a listing of the user's fund requests.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get filter/search params if needed
        $query = PengajuanDana::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('user.pengajuan-dana.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new fund request.
     */
    public function create()
    {
        return view('user.pengajuan-dana.create');
    }

    /**
     * Store a newly created fund request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pengajuan' => ['required', 'string', 'in:Kebutuhan Mendesak,Bantuan Sosial,Kegiatan Anggota,Lainnya'],
            'jumlah_dana' => ['required', 'numeric', 'min:1'],
            'keterangan' => ['required', 'string', 'max:2000'],
            'file_pendukung' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'jenis_pengajuan.required' => 'Jenis pengajuan wajib dipilih.',
            'jenis_pengajuan.in' => 'Jenis pengajuan tidak valid.',
            'jumlah_dana.required' => 'Jumlah dana wajib diisi.',
            'jumlah_dana.numeric' => 'Jumlah dana harus berupa angka.',
            'jumlah_dana.min' => 'Jumlah dana minimal Rp 1.',
            'keterangan.required' => 'Keterangan pengajuan wajib diisi.',
            'keterangan.max' => 'Keterangan maksimal 2000 karakter.',
            'file_pendukung.mimes' => 'Format file pendukung harus berupa pdf, jpg, jpeg, atau png.',
            'file_pendukung.max' => 'Ukuran file pendukung maksimal 5MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $disk = env('FILESYSTEM_DISK') === 's3' ? 's3_bukti' : 'public';
            $filePath = $file->storeAs('file_pendukung', $filename, $disk);
            
            if ($disk === 's3_bukti') {
                $filePath = \Illuminate\Support\Facades\Storage::disk('s3_bukti')->url($filePath);
            }
        }

        PengajuanDana::create([
            'user_id' => Auth::id(),
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'jumlah_dana' => $request->jumlah_dana,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'file_pendukung' => $filePath,
        ]);

        return redirect()->route('user.pengajuan-dana.index')
            ->with('success', 'Pengajuan dana/bantuan Anda berhasil diajukan dan sedang menunggu verifikasi.');
    }
}
