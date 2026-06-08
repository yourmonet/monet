<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanDana extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_danas';

    protected $fillable = [
        'user_id',
        'jenis_pengajuan',
        'jumlah_dana',
        'no_telp',
        'nama_bank',
        'no_rekening',
        'nama_rekening',
        'keterangan',
        'status',
        'catatan_pengurus',
        'file_pendukung',
        'approved_by',
        'approved_at',
        'approval_note',
        'rejected_by',
        'rejected_at',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function histories()
    {
        return $this->hasMany(PengajuanDanaHistory::class, 'pengajuan_dana_id');
    }
}
