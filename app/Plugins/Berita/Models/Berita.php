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
        'aktif',
        'user_id',
        'meta_description',
        'meta_keywords',
        'slug',
        'viewer'
    ];
    
    protected $table = 'berita';
    
    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'aktif' => 'boolean',
        'viewer' => 'integer'
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
    
    /**
     * Accessor untuk mendapatkan thumbnail kecil
     */
    public function getSmallThumbnailAttribute()
    {
        if (!$this->gambar) {
            return null;
        }
        
        $pathInfo = pathinfo($this->gambar);
        $dirname = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        $smallThumb = $dirname . '/' . $filename . '_thumb_small.' . $extension;
        
        // Cek apakah file thumbnail kecil ada
        if (file_exists(storage_path('app/public/' . $smallThumb))) {
            return $smallThumb;
        }
        
        return $this->gambar;
    }
    
    /**
     * Accessor untuk mendapatkan thumbnail besar
     */
    public function getLargeThumbnailAttribute()
    {
        if (!$this->gambar) {
            return null;
        }
        
        $pathInfo = pathinfo($this->gambar);
        $dirname = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        
        $largeThumb = $dirname . '/' . $filename . '_thumb_large.' . $extension;
        
        // Cek apakah file thumbnail besar ada
        if (file_exists(storage_path('app/public/' . $largeThumb))) {
            return $largeThumb;
        }
        
        return $this->gambar;
    }
}