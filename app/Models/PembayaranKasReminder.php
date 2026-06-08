<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranKasReminder extends Model
{
    protected $table = 'pembayaran_kas_reminders';

    protected $fillable = [
        'pembayaran_kas_id',
        'sender_id',
        'recipient_id',
    ];

    public function pembayaranKas(): BelongsTo
    {
        return $this->belongsTo(PembayaranKas::class, 'pembayaran_kas_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
