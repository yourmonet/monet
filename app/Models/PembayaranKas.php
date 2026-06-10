<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranKas extends Model
{
    protected $table = 'pembayaran_kas';

    protected $appends = ['bukti_url'];

    protected $fillable = [
        'user_id',
        'tagihan_kas_id',
        'periode',
        'nominal',
        'bukti_pembayaran',
        'catatan',
        'alasan_penolakan',
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

    public function kasMasuk()
    {
        return $this->hasOne(KasMasuk::class, 'pembayaran_kas_id');
    }

    public function getBuktiUrlAttribute()
    {
        if (!$this->bukti_pembayaran) {
            return null;
        }
        if (\Illuminate\Support\Str::startsWith($this->bukti_pembayaran, ['http://', 'https://'])) {
            return $this->bukti_pembayaran;
        }
        return asset('storage/' . $this->bukti_pembayaran);
    }
}
