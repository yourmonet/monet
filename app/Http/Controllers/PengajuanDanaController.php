<?php

namespace App\Http\Controllers;

use App\Models\PengajuanDana;
use App\Models\PengajuanDanaHistory;
use App\Mail\PengajuanDanaDisetujuiMail;
use App\Mail\PengajuanDanaDitolakMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

class PengajuanDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $routeName = $request->route()->getName();

        // Admin view (Bendahara / Pengurus)
        if (str_starts_with($routeName, 'bendahara.') || str_starts_with($routeName, 'pengurus.')) {
            // Check authorization
            if (!$user->isBendahara() && !$user->isPengurus()) {
                abort(403);
            }

            // Filters
            $search = $request->input('search');
            $status = $request->input('status');
            $tglMulai = $request->input('tanggal_mulai');
            $tglSelesai = $request->input('tanggal_selesai');

            // Query base for stats (unfiltered by search/dates/status except user if needed, but stats are for overall org)
            $totalPengajuan = PengajuanDana::count();
            $pendingCount = PengajuanDana::where('status', 'Pending')->count();
            $approvedCount = PengajuanDana::where('status', 'Disetujui')->count();
            $rejectedCount = PengajuanDana::where('status', 'Ditolak')->count();
            $totalDanaDisetujui = PengajuanDana::where('status', 'Disetujui')->sum('jumlah_dana');

            // Query base for Table
            $queryAll = PengajuanDana::with(['user', 'approvedBy', 'rejectedBy', 'histories.approver'])->latest();

            if ($search) {
                $queryAll->where(function($q) use ($search) {
                    $q->where('jenis_pengajuan', 'like', "%{$search}%")
                      ->orWhereHas('user', function($qu) use ($search) {
                          $qu->where('name', 'like', "%{$search}%");
                      });
                });
            }

            if ($status) {
                $queryAll->where('status', $status);
            }

            if ($tglMulai) {
                $queryAll->whereDate('created_at', '>=', $tglMulai);
            }

            if ($tglSelesai) {
                $queryAll->whereDate('created_at', '<=', $tglSelesai);
            }

            $allPengajuan = $queryAll->paginate(15, ['*'], 'page_all')->withQueryString();
            
            // Get user's own requests
            $myPengajuan = PengajuanDana::where('user_id', $user->id)
                ->with(['approvedBy', 'rejectedBy', 'histories.approver'])
                ->latest()
                ->paginate(15, ['*'], 'page_my')
                ->withQueryString();

            $viewName = $user->isBendahara() ? 'bendahara.pengajuan-dana.index' : 'pengurus.pengajuan-dana.index';
            
            return view($viewName, compact(
                'allPengajuan', 
                'myPengajuan',
                'totalPengajuan',
                'pendingCount',
                'approvedCount',
                'rejectedCount',
                'totalDanaDisetujui',
                'status',
                'search',
                'tglMulai',
                'tglSelesai'
            ));
        }

        // Regular Member view
        $myPengajuan = PengajuanDana::where('user_id', $user->id)
            ->with(['approvedBy', 'rejectedBy', 'histories.approver'])
            ->latest()
            ->paginate(15);
            
        return view('user.pengajuan-dana.index', compact('myPengajuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->isBendahara()) {
            return view('bendahara.pengajuan-dana.create');
        } elseif ($user->isPengurus()) {
            return view('pengurus.pengajuan-dana.create');
        }
        return view('user.pengajuan-dana.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pengajuan' => 'required|string|max:255',
            'jumlah_dana' => 'required|integer|min:1',
            'no_telp' => 'required|string|max:20',
            'nama_bank' => 'required|string|max:100',
            'no_rekening' => 'required|string|max:50',
            'nama_rekening' => 'required|string|max:150',
            'keterangan' => 'required|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $filePath = $request->file('file_pendukung')->store('pengajuan_dana', 'public');
        }

        $pengajuan = PengajuanDana::create([
            'user_id' => Auth::id(),
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'jumlah_dana' => $request->jumlah_dana,
            'no_telp' => $request->no_telp,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'keterangan' => $request->keterangan,
            'file_pendukung' => $filePath,
            'status' => 'Pending',
        ]);

        // Log initial history
        PengajuanDanaHistory::create([
            'pengajuan_dana_id' => $pengajuan->id,
            'status_sebelum' => 'Draft',
            'status_sesudah' => 'Pending',
            'catatan' => 'Pengajuan diajukan ke sistem.',
            'approver_id' => null,
        ]);

        $user = Auth::user();
        $redirectRoute = 'user.pengajuan-dana.index';
        if ($user->isBendahara()) {
            $redirectRoute = 'bendahara.pengajuan-dana.index';
        } elseif ($user->isPengurus()) {
            $redirectRoute = 'pengurus.pengajuan-dana.index';
        }

        return redirect()->route($redirectRoute)->with('success', 'Pengajuan dana berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuan = PengajuanDana::with(['user', 'approvedBy', 'rejectedBy', 'histories.approver'])->findOrFail($id);
        
        // Return JSON details for modal display or standard view
        return response()->json($pengajuan);
    }

    /**
     * Approve the request.
     */
    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isBendahara()) {
            abort(403, 'Hanya bendahara yang dapat melakukan persetujuan.');
        }

        $pengajuan = PengajuanDana::findOrFail($id);
        
        if ($pengajuan->status !== 'Pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses dan tidak dapat diubah.');
        }

        $request->validate([
            'catatan_pengurus' => 'nullable|string|max:1000',
        ]);

        $statusSebelum = $pengajuan->status;

        $pengajuan->update([
            'status' => 'Disetujui',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'approval_note' => $request->catatan_pengurus,
        ]);

        // Create history log
        PengajuanDanaHistory::create([
            'pengajuan_dana_id' => $pengajuan->id,
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => 'Disetujui',
            'catatan' => $request->catatan_pengurus,
            'approver_id' => $user->id,
        ]);

        // Send Email Notification
        try {
            Mail::to($pengajuan->user->email)->send(new PengajuanDanaDisetujuiMail($pengajuan));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email pengajuan disetujui: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pengajuan dana berhasil disetujui.');
    }

    /**
     * Reject the request.
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isBendahara()) {
            abort(403, 'Hanya bendahara yang dapat melakukan penolakan.');
        }

        $pengajuan = PengajuanDana::findOrFail($id);

        if ($pengajuan->status !== 'Pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses dan tidak dapat diubah.');
        }

        $request->validate([
            'catatan_pengurus' => 'required|string|max:1000',
        ]);

        $statusSebelum = $pengajuan->status;

        $pengajuan->update([
            'status' => 'Ditolak',
            'rejected_by' => $user->id,
            'rejected_at' => now(),
            'rejection_reason' => $request->catatan_pengurus,
        ]);

        // Create history log
        PengajuanDanaHistory::create([
            'pengajuan_dana_id' => $pengajuan->id,
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => 'Ditolak',
            'catatan' => $request->catatan_pengurus,
            'approver_id' => $user->id,
        ]);

        // Send Email Notification
        try {
            Mail::to($pengajuan->user->email)->send(new PengajuanDanaDitolakMail($pengajuan));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email pengajuan ditolak: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pengajuan dana telah ditolak.');
    }

    /**
     * Export to PDF.
     */
    public function exportPdf(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $tglMulai = $request->input('tanggal_mulai');
        $tglSelesai = $request->input('tanggal_selesai');

        $query = PengajuanDana::with(['user', 'approvedBy', 'rejectedBy']);

        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_pengajuan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }
        if ($tglMulai) {
            $query->whereDate('created_at', '>=', $tglMulai);
        }
        if ($tglSelesai) {
            $query->whereDate('created_at', '<=', $tglSelesai);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('bendahara.pengajuan-dana.pdf', compact('data', 'status', 'search', 'tglMulai', 'tglSelesai'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Pengajuan_Dana_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Export to Excel.
     */
    public function exportExcel(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        $tglMulai = $request->input('tanggal_mulai');
        $tglSelesai = $request->input('tanggal_selesai');

        $query = PengajuanDana::with(['user', 'approvedBy', 'rejectedBy']);

        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_pengajuan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }
        if ($tglMulai) {
            $query->whereDate('created_at', '>=', $tglMulai);
        }
        if ($tglSelesai) {
            $query->whereDate('created_at', '<=', $tglSelesai);
        }

        $data = $query->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pengajuan Dana');

        // Header
        $sheet->setCellValue('A1', 'LAPORAN PENGAJUAN DANA ORGANISASI');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->fromArray([
            'No', 'Nama Pemohon', 'Role', 'Tanggal Pengajuan', 'Jenis Pengajuan', 
            'Nominal (Rp)', 'Status', 'Diverifikasi Oleh', 'Waktu Verifikasi', 'Catatan / Alasan', 'No. Rekening'
        ], null, 'A3');

        $sheet->getStyle('A3:K3')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '003D9B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        $sheet->getStyle('A3:K3')->getFont()->getColor()->setRGB('FFFFFF');

        $row = 4;
        foreach ($data as $index => $item) {
            $diverifikasiOleh = '-';
            $waktuVerifikasi = '-';
            $catatan = '-';

            if ($item->status === 'Disetujui') {
                $diverifikasiOleh = $item->approvedBy ? $item->approvedBy->name : '-';
                $waktuVerifikasi = $item->approved_at ? Carbon::parse($item->approved_at)->format('d/m/Y H:i') : '-';
                $catatan = $item->approval_note ?: '-';
            } elseif ($item->status === 'Ditolak') {
                $diverifikasiOleh = $item->rejectedBy ? $item->rejectedBy->name : '-';
                $waktuVerifikasi = $item->rejected_at ? Carbon::parse($item->rejected_at)->format('d/m/Y H:i') : '-';
                $catatan = $item->rejection_reason ?: '-';
            }

            $rekening = $item->nama_bank . ' ' . $item->no_rekening . ' (a.n. ' . $item->nama_rekening . ')';

            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->user->name);
            $sheet->setCellValue('C' . $row, ucfirst($item->user->role));
            $sheet->setCellValue('D' . $row, $item->created_at->format('d/m/Y H:i'));
            $sheet->setCellValue('E' . $row, $item->jenis_pengajuan);
            $sheet->setCellValue('F' . $row, $item->jumlah_dana);
            $sheet->setCellValue('G' . $row, $item->status);
            $sheet->setCellValue('H' . $row, $diverifikasiOleh);
            $sheet->setCellValue('I' . $row, $waktuVerifikasi);
            $sheet->setCellValue('J' . $row, $catatan);
            $sheet->setCellValue('K' . $row, $rekening);

            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $row++;
        }

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_Pengajuan_Dana_' . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
