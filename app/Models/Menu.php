<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title', 
        'route',
        'url',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'plugin_name',
        'roles'
    ];

    protected $casts = [
        'roles' => 'array',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Scope to get only active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get main menus (no parent)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
}