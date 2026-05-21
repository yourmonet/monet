<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KasKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'keterangan',
        'sumber',
        'nominal',
        'kategori_id' 
    ];

   
    public function kategori()
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_id');
    }
}