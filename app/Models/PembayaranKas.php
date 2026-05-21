<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranKas extends Model
{
    protected $table = 'pembayaran_kas';

    protected $fillable = [
        'user_id',
        'tagihan_kas_id',
        'periode',
        'nominal',
        'bukti_pembayaran',
        'catatan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tagihanKas()
    {
        return $this->belongsTo(TagihanKas::class, 'tagihan_kas_id');
    }
}
