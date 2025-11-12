<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'position',
        'status',
        'content',
        'plugin_name',
        'order',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'string',
        'type' => 'string',
        'position' => 'string'
    ];

    /**
     * Scope untuk widget aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk widget berdasarkan posisi
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope untuk widget berdasarkan tipe
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}