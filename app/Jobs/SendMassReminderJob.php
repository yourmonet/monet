<?php

namespace App\Jobs;

use App\Models\PembayaranKas;
use App\Models\PembayaranKasReminder;
use App\Mail\ReminderTagihanMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendMassReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $senderId;

    /**
     * Create a new job instance.
     */
    public function __construct($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $unpaid = PembayaranKas::whereIn('status', ['Belum Bayar', 'Ditolak'])
            ->with('user')
            ->get();

        $successCount = 0;
        $failCount = 0;

        foreach ($unpaid as $pembayaran) {
            if (!$pembayaran->user || !$pembayaran->user->email) {
                continue;
            }

            // Check spam protection: max 1 reminder per member every 24 hours
            $lastReminder = PembayaranKasReminder::where('pembayaran_kas_id', $pembayaran->id)
                ->where('recipient_id', $pembayaran->user_id)
                ->where('created_at', '>=', Carbon::now()->subHours(24))
                ->first();

            if (!$lastReminder) {
                try {
                    Mail::to($pembayaran->user->email)->send(new ReminderTagihanMail($pembayaran));

                    // Record reminder log
                    PembayaranKasReminder::create([
                        'pembayaran_kas_id' => $pembayaran->id,
                        'sender_id' => $this->senderId,
                        'recipient_id' => $pembayaran->user_id,
                    ]);

                    $successCount++;
                } catch (\Exception $e) {
                    Log::error("Failed to send mass reminder email to {$pembayaran->user->email}: " . $e->getMessage());
                    $failCount++;
                }
            }
        }

        Log::info("Mass reminder completed. Success: {$successCount}, Failed: {$failCount}");
    }
}
