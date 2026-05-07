<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penagihan extends Model
{
    protected $fillable = [
        'user_id',
        'periode_bulan',
        'periode_tahun',
        'jumlah',
        'status',
        'kas_masuk_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kasMasuk()
    {
        return $this->belongsTo(KasMasuk::class);
    }
}
