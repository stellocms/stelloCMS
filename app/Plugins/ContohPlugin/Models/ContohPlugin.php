<?php

namespace App\Plugins\ContohPlugin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContohPlugin extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal_dibuat',
        'aktif',
        'slug'
    ];
    
    protected $table = 'contoh_plugins';
    
    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'aktif' => 'boolean'
    ];
    
    /**
     * Generate a unique slug before saving
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            if (empty($model->slug) || $model->isDirty('judul')) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }
    
    /**
     * Generate a unique slug based on the title
     */
    private function generateUniqueSlug()
    {
        $slug = generate_slug($this->judul);
        $originalSlug = $slug;
        $counter = 1;
        
        // If this is an update, exclude current record from the check
        $query = static::where('slug', $slug);
        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }
        
        while ($query->first()) {
            $slug = $originalSlug . '-' . $counter;
            $query = static::where('slug', $slug);
            
            if ($this->exists) {
                $query->where('id', '!=', $this->id);
            }
            
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Scope to find by slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}