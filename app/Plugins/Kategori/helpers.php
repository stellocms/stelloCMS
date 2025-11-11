<?php

use App\Plugins\Kategori\Models\Kategori;

if (!function_exists('get_kategori')) {
    /**
     * Mendapatkan semua kategori aktif
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_kategori()
    {
        if (class_exists(App\Plugins\Kategori\Models\Kategori::class)) {
            return Kategori::aktif()->orderBy('nama_kategori')->get();
        }
        
        return collect([]);
    }
}

if (!function_exists('get_kategori_all')) {
    /**
     * Mendapatkan semua kategori (aktif dan non-aktif)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_kategori_all()
    {
        if (class_exists(App\Plugins\Kategori\Models\Kategori::class)) {
            return Kategori::orderBy('nama_kategori')->get();
        }
        
        return collect([]);
    }
}

if (!function_exists('get_kategori_by_id')) {
    /**
     * Mendapatkan kategori berdasarkan ID
     *
     * @param int $id ID kategori
     * @return \App\Plugins\Kategori\Models\Kategori|null
     */
    function get_kategori_by_id($id)
    {
        if (class_exists(App\Plugins\Kategori\Models\Kategori::class)) {
            return Kategori::aktif()->find($id);
        }
        
        return null;
    }
}