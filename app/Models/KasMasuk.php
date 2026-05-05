<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    protected $fillable = [
        'tanggal',
        'keterangan',
        'jumlah',
        'sumber',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
