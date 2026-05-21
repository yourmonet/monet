<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanKas extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_bulan',
        'periode_tahun',
        'nominal',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pembayaran()
    {
        return $this->hasMany(PembayaranKas::class, 'tagihan_kas_id');
    }
}
