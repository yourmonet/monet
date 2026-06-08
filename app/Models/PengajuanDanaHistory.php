<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanDanaHistory extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_dana_histories';

    protected $fillable = [
        'pengajuan_dana_id',
        'status_sebelum',
        'status_sesudah',
        'catatan',
        'approver_id',
    ];

    public function pengajuanDana()
    {
        return $this->belongsTo(PengajuanDana::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
