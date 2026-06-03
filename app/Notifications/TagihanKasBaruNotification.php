<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TagihanKasBaruNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $bulan;
    public $tahun;
    public $nominal;

    /**
     * Create a new notification instance.
     */
    public function __construct($bulan, $tahun, $nominal)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->nominal = $nominal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $namaBulan = Carbon::create()->month((int) $this->bulan)->translatedFormat('F');
        $url = url($notifiable->getDashboardRoute());

        return (new MailMessage)
            ->subject("Tagihan Kas Baru - {$namaBulan} {$this->tahun}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Tagihan kas untuk periode **{$namaBulan} {$this->tahun}** telah diterbitkan.")
            ->line("Nominal tagihan yang harus dibayarkan adalah **Rp" . number_format($this->nominal, 0, ',', '.') . "**.")
            ->action('Cek Tagihan Saya', $url)
            ->line('Segera bayar tagihan Anda. Jika mengalami kendala saat melakukan pembayaran, hubungi kami melalui email ini.')
            ->line('Terima kasih.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
