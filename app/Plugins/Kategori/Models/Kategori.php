<?php

namespace App\Plugins\Kategori\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'warna',
        'ikon',
        'aktif'
    ];

    protected $table = 'kategori_berita';

    protected $casts = [
        'aktif' => 'boolean'
    ];

    /**
     * Scope untuk kategori aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Relasi ke berita
     */
    public function berita()
    {
        return $this->hasMany(\App\Plugins\Berita\Models\Berita::class, 'kategori_id');
    }
}