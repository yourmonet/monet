<?php

namespace App\Mail;

use App\Models\PembayaranKas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TagihanBaruMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pembayaran;

    public function __construct(PembayaranKas $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tagihan Kas Baru - Periode ' . $this->pembayaran->periode,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tagihan-baru',
        );
    }
}
