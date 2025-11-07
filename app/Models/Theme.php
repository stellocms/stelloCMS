<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'version',
        'description',
        'author',
        'author_url',
        'screenshot',
        'tags',
        'is_active',
        'is_installed',
        'is_default',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'is_installed' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Scope to get only active themes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only installed themes
     */
    public function scopeInstalled($query)
    {
        return $query->where('is_installed', true);
    }

    /**
     * Scope to get only frontend themes
     */
    public function scopeFrontend($query)
    {
        return $query->where('type', 'frontend');
    }

    /**
     * Scope to get only admin themes
     */
    public function scopeAdmin($query)
    {
        return $query->where('type', 'admin');
    }

    /**
     * Scope to get the default theme for a type
     */
    public function scopeDefaultForType($query, $type)
    {
        return $query->where('type', $type)->where('is_default', true);
    }

    /**
     * Set the current theme as default for its type
     */
    public function setAsDefault()
    {
        // First, unset the current default for this type
        self::where('type', $this->type)->where('is_default', true)->update(['is_default' => false]);
        
        // Then set this theme as default
        $this->update(['is_default' => true]);
    }

    /**
     * Get the default theme for a specific type
     */
    public static function getDefaultForType($type)
    {
        return self::where('type', $type)->where('is_default', true)->first();
    }
}