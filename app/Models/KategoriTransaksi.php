<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTransaksi extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar Laravel tahu kolom mana yang boleh diisi manual
    protected $fillable = [
        'nama_kategori',
        'jenis',
        'deskripsi'
    ];
}