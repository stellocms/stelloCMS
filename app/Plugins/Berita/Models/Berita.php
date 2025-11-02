<?php

namespace App\Plugins\Berita\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'tanggal_publikasi',
        'aktif'
    ];
    
    protected $table = 'berita';
    
    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'aktif' => 'boolean'
    ];
}