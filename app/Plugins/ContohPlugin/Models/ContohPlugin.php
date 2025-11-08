<?php

namespace App\Plugins\ContohPlugin\Models;

use Illuminate\Database\Eloquent\Model;

class ContohPlugin extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal_dibuat',
        'aktif'
    ];
    
    protected $table = 'contoh_plugins';
    
    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'aktif' => 'boolean'
    ];
}