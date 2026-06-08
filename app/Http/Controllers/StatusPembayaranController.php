<?php

namespace App\Http\Controllers;

use App\Models\PembayaranKas;
use App\Models\TagihanKas;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TagihanBaruMail;
use App\Mail\PembayaranBerhasilMail;
use App\Mail\PembayaranDitolakMail;
use App\Mail\ReminderTagihanMail;
use App\Models\PembayaranKasReminder;
use App\Jobs\SendMassReminderJob;

class StatusPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = PembayaranKas::with(['user', 'tagihanKas']);

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $bulan = sprintf('%02d', $request->bulan);
            $query->where('periode', 'like', "%-{$bulan}");
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->where('periode', 'like', "{$request->tahun}-%");
        }

        // Filter role (hanya bendahara & pengurus)
        if ($request->filled('role')) {
            $role = $request->role;
            $query->whereHas('user', function ($q) use ($role) {
                $q->where('role', $role);
            });
        } else {
            // Default only load pengurus and bendahara
            $query->whereHas('user', function ($q) {
                $q->whereIn('role', ['pengurus', 'bendahara']);
            });
        }

        // Search nama anggota
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan periode terbaru (karena format periode YYYY-MM bisa disorting langsung)
        $pembayarans = $query->orderBy('periode', 'desc')
                            ->paginate(30);

        // View context based on role
        if (Auth::user()->role === 'pengurus') {
            return view('pengurus.status-pembayaran.index', compact('pembayarans'));
        }

        return view('bendahara.status-pembayaran.index', compact('pembayarans'));
    }

    public function generateBulanIni(Request $request)
    {
        // Hanya bendahara
        if (Auth::user()->role !== 'bendahara') {
            abort(403);
        }

        $request->validate([
            'generate_bulan' => 'nullable|integer|min:1|max:12',
            'generate_tahun' => 'nullable|integer|min:2000',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $bulan = $request->input('generate_bulan', Carbon::now()->month);
        $tahun = $request->input('generate_tahun', Carbon::now()->year);
        $jumlahIuran = $request->input('jumlah', 5000); // Default to 5.000 for Monet

        // Cek apakah TagihanKas untuk bulan & tahun ini sudah dibuat
        $tagihanExist = TagihanKas::where('periode_bulan', $bulan)
                                  ->where('periode_tahun', $tahun)
                                  ->first();

        if ($tagihanExist) {
            return redirect()->back()->with('error', "Tagihan bulan ini sudah tersedia!");
        }

        // Buat master TagihanKas
        $tagihan = TagihanKas::create([
            'periode_bulan' => $bulan,
            'periode_tahun' => $tahun,
            'nominal' => $jumlahIuran,
            'created_by' => Auth::id()
        ]);

        // Cari semua user bendahara & pengurus
        $pengurusDanBendahara = User::whereIn('role', ['pengurus', 'bendahara'])->get();
        $generatedCount = 0;

        $periodeString = sprintf('%04d-%02d', $tahun, $bulan);

        foreach ($pengurusDanBendahara as $userTarget) {
            // Pastikan belum ada pembayaran kas untuk periode ini
            $exists = PembayaranKas::where('user_id', $userTarget->id)
                                ->where('periode', $periodeString)
                                ->exists();

            if (!$exists) {
                $pembayaran = PembayaranKas::create([
                    'user_id' => $userTarget->id,
                    'tagihan_kas_id' => $tagihan->id,
                    'periode' => $periodeString,
                    'nominal' => $jumlahIuran,
                    'status' => 'Belum Bayar'
                ]);
                $generatedCount++;

                // Kirim email tagihan baru!
                try {
                    Mail::to($userTarget->email)->send(new TagihanBaruMail($pembayaran));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Gagal mengirim email tagihan baru ke {$userTarget->email}: " . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', "Berhasil membuat {$generatedCount} tagihan untuk periode Bulan {$bulan} Tahun {$tahun}. Email notifikasi telah dikirim ke masing-masing anggota.");
    }

    /**
     * Verify (approve) a payment — change status to 'Lunas'.
     */
    public function verify(Request $request, $id)
    {
        if (Auth::user()->role !== 'bendahara') {
            abort(403);
        }

        $pembayaran = PembayaranKas::findOrFail($id);

        if ($pembayaran->status !== 'Menunggu Verifikasi') {
            return redirect()->back()->with('error', 'Pembayaran ini tidak dalam status menunggu verifikasi.');
        }

        $pembayaran->update([
            'status' => 'Lunas',
        ]);

        // Kirim email konfirmasi pembayaran berhasil
        try {
            Mail::to($pembayaran->user->email)->send(new PembayaranBerhasilMail($pembayaran));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal mengirim email pembayaran berhasil ke {$pembayaran->user->email}: " . $e->getMessage());
        }

        return redirect()->back()->with('success', "Pembayaran {$pembayaran->user->name} periode {$pembayaran->periode} berhasil diverifikasi (Lunas).");
    }

    /**
     * Reject a payment — change status to 'Ditolak' so the user can re-upload.
     */
    public function reject(Request $request, $id)
    {
        if (Auth::user()->role !== 'bendahara') {
            abort(403);
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        $pembayaran = PembayaranKas::findOrFail($id);

        if ($pembayaran->status !== 'Menunggu Verifikasi') {
            return redirect()->back()->with('error', 'Pembayaran ini tidak dalam status menunggu verifikasi.');
        }

        $pembayaran->update([
            'status' => 'Ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'bukti_pembayaran' => null,
        ]);

        // Kirim email penolakan pembayaran
        try {
            Mail::to($pembayaran->user->email)->send(new PembayaranDitolakMail($pembayaran));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal mengirim email penolakan pembayaran ke {$pembayaran->user->email}: " . $e->getMessage());
        }

        return redirect()->back()->with('success', "Pembayaran {$pembayaran->user->name} periode {$pembayaran->periode} telah ditolak dengan alasan: {$request->alasan_penolakan}.");
    }

    /**
     * Send email reminder to a single member.
     */
    public function sendReminder(Request $request, $id)
    {
        $pembayaran = PembayaranKas::findOrFail($id);

        if ($pembayaran->status === 'Lunas' || $pembayaran->status === 'Menunggu Verifikasi') {
            return redirect()->back()->with('error', 'Reminder hanya dapat dikirim untuk tagihan yang belum dibayar atau ditolak.');
        }

        // Spam protection: max 1 reminder per member every 24 hours
        $lastReminder = PembayaranKasReminder::where('pembayaran_kas_id', $pembayaran->id)
            ->where('recipient_id', $pembayaran->user_id)
            ->where('created_at', '>=', Carbon::now()->subHours(24))
            ->first();

        if ($lastReminder) {
            $formattedTime = $lastReminder->created_at->addHours(24)->diffForHumans();
            return redirect()->back()->with('error', "Batas pengiriman reminder: Maksimal 1 reminder per 24 jam. Anda baru dapat mengirim pengingat lagi {$formattedTime}.");
        }

        try {
            Mail::to($pembayaran->user->email)->send(new ReminderTagihanMail($pembayaran));

            // Record reminder log
            PembayaranKasReminder::create([
                'pembayaran_kas_id' => $pembayaran->id,
                'sender_id' => Auth::id(),
                'recipient_id' => $pembayaran->user_id,
            ]);

            return redirect()->back()->with('success', "Email pengingat berhasil dikirim ke {$pembayaran->user->name}.");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal mengirim email pengingat ke {$pembayaran->user->email}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email pengingat. Silakan coba lagi.');
        }
    }

    /**
     * Send email reminder to all members who haven't paid.
     */
    public function sendMassReminder(Request $request)
    {
        $unpaid = PembayaranKas::whereIn('status', ['Belum Bayar', 'Ditolak'])
            ->with('user')
            ->get();

        $eligibleCount = 0;
        $spamCount = 0;

        foreach ($unpaid as $pembayaran) {
            if (!$pembayaran->user || !$pembayaran->user->email) {
                continue;
            }

            $lastReminder = PembayaranKasReminder::where('pembayaran_kas_id', $pembayaran->id)
                ->where('recipient_id', $pembayaran->user_id)
                ->where('created_at', '>=', Carbon::now()->subHours(24))
                ->exists();

            if (!$lastReminder) {
                $eligibleCount++;
            } else {
                $spamCount++;
            }
        }

        if ($eligibleCount === 0) {
            return redirect()->back()->with('info', "Tidak ada anggota yang memenuhi syarat untuk dikirimi pengingat saat ini (semua sudah diingatkan dalam 24 jam terakhir).");
        }

        // Dispatch mass reminder job
        SendMassReminderJob::dispatch(Auth::id());

        return redirect()->back()->with('success', "Proses pengiriman pengingat massal telah dimasukkan ke dalam antrean (Queue) untuk {$eligibleCount} anggota. Silakan jalankan 'php artisan queue:work' jika antrean belum berjalan.");
    }
}
