<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    protected $fillable = [
        'tanggal',
        'keterangan',
        'nominal',
    ];
}
