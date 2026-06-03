<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class PengingatTagihanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $periode;
    public $nominal;

    /**
     * Create a new notification instance.
     */
    public function __construct($periode, $nominal)
    {
        $this->periode = $periode; // YYYY-MM
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
        $periodeFormatted = Carbon::createFromFormat('Y-m', $this->periode)->translatedFormat('F Y');
        $url = url($notifiable->getDashboardRoute());

        return (new MailMessage)
            ->subject("Pengingat Pembayaran Kas - {$periodeFormatted}")
            ->greeting("Halo {$notifiable->name},")
            ->line("Ini adalah pengingat bahwa tagihan kas untuk periode **{$periodeFormatted}** belum dibayarkan.")
            ->line("Nominal tagihan: **Rp" . number_format($this->nominal, 0, ',', '.') . "**.")
            ->action('Bayar Sekarang', $url)
            ->line('Mohon segera lunasi tagihan Anda. Jika terdapat kendala dalam melakukan pembayaran, hubungi kami melalui email ini.')
            ->line('Abaikan email ini jika sudah melakukan pembayaran.');
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
