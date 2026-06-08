<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KasMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'keterangan',
        'jumlah',
        'sumber',
        'user_id',
        'kategori_id', // Tambahan untuk relasi kategori
        'pembayaran_kas_id' // Hubungan dengan pembayaran kas
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function kategori()
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_id');
    }

    public function pembayaranKas()
    {
        return $this->belongsTo(PembayaranKas::class, 'pembayaran_kas_id');
    }
}