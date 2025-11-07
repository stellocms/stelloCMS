<?php

namespace App\Services;

use App\Models\Theme;
use Illuminate\Support\Facades\Cache;

class ThemeService
{
    protected $cacheKey = 'active_themes';

    /**
     * Get all active themes
     */
    public function getActiveThemes()
    {
        try {
            return Cache::remember($this->cacheKey, 3600, function () {
                return Theme::active()->get();
            });
        } catch (\Exception $e) {
            // Fallback to database if cache fails
            return Theme::active()->get();
        }
    }

    /**
     * Get active themes by type
     */
    public function getActiveThemesByType($type)
    {
        try {
            return Cache::remember("{$this->cacheKey}_{$type}", 3600, function () use ($type) {
                return Theme::active()->where('type', $type)->get();
            });
        } catch (\Exception $e) {
            // Fallback to database if cache fails
            return Theme::active()->where('type', $type)->get();
        }
    }

    /**
     * Get the default theme for a specific type
     */
    public function getDefaultTheme($type)
    {
        $theme = Theme::getDefaultForType($type);
        
        if (!$theme) {
            // Fallback to config if no default in database
            $configThemeName = config("themes.{$type}", $type === 'admin' ? 'adminlte' : 'stocker');
            $theme = Theme::where('type', $type)->where('name', $configThemeName)->first();
            
            if (!$theme) {
                // Create a default theme record if it doesn't exist
                $theme = Theme::create([
                    'name' => $configThemeName,
                    'type' => $type,
                    'is_active' => true,
                    'is_installed' => true,
                    'is_default' => true,
                    'description' => "Default {$type} theme"
                ]);
            } else {
                // If theme exists but is not default, make it default
                $theme->update(['is_default' => true]);
            }
        }
        
        return $theme;
    }

    /**
     * Update the default theme for a type
     */
    public function setDefaultTheme($type, $themeName)
    {
        $theme = Theme::where('type', $type)->where('name', $themeName)->first();
        
        if ($theme) {
            $theme->setAsDefault();
            $this->clearCache();
            return true;
        }
        
        return false;
    }

    /**
     * Check if a theme is installed
     */
    public function isThemeInstalled($type, $name)
    {
        $theme = Theme::where('type', $type)->where('name', $name)->first();
        return $theme && $theme->is_installed;
    }

    /**
     * Check if a theme is active
     */
    public function isThemeActive($type, $name)
    {
        $theme = Theme::where('type', $type)->where('name', $name)->first();
        return $theme && $theme->is_active;
    }

    /**
     * Ensure consistency of default theme status
     */
    public function ensureDefaultThemeConsistency($type)
    {
        // Get the config default theme
        $configThemeName = config("themes.{$type}", $type === 'admin' ? 'adminlte' : 'stocker');
        
        // Find the theme that should be default based on the database
        $dbDefaultTheme = Theme::where('type', $type)->where('is_default', true)->first();
        
        // If no theme is marked as default in the database, use the config default
        if (!$dbDefaultTheme) {
            $dbDefaultTheme = Theme::where('type', $type)->where('name', $configThemeName)->first();
            if ($dbDefaultTheme) {
                // Set this theme as default
                Theme::where('type', $type)->update(['is_default' => false]);
                $dbDefaultTheme->update(['is_default' => true]);
            } else {
                // Create the default theme if it doesn't exist
                $dbDefaultTheme = Theme::create([
                    'name' => $configThemeName,
                    'type' => $type,
                    'is_active' => true,
                    'is_installed' => true,
                    'is_default' => true,
                    'description' => "Default {$type} theme"
                ]);
            }
        } else {
            // Ensure only one theme is marked as default
            Theme::where('type', $type)
                 ->where('name', '!=', $dbDefaultTheme->name)
                 ->update(['is_default' => false]);
        }
    }

    /**
     * Install a theme
     */
    public function installTheme($type, $name)
    {
        $theme = Theme::firstOrCreate([
            'type' => $type,
            'name' => $name,
        ], [
            'is_installed' => true,
            'is_active' => true,
        ]);

        if (!$theme->is_installed) {
            $theme->update([
                'is_installed' => true,
                'is_active' => true,
            ]);
        }

        $this->clearCache();
        return $theme;
    }

    /**
     * Uninstall a theme
     */
    public function uninstallTheme($type, $name)
    {
        $theme = Theme::where('type', $type)->where('name', $name)->first();
        
        if ($theme) {
            // Don't allow uninstalling the default theme
            if ($theme->is_default) {
                return false;
            }
            
            $theme->update([
                'is_installed' => false,
                'is_active' => false,
            ]);
            
            $this->clearCache();
            return true;
        }
        
        return false;
    }

    /**
     * Activate a theme
     */
    public function activateTheme($type, $name)
    {
        $theme = Theme::where('type', $type)->where('name', $name)->first();
        
        if ($theme) {
            $theme->update(['is_active' => true]);
            $this->clearCache();
            return true;
        }
        
        return false;
    }

    /**
     * Deactivate a theme
     */
    public function deactivateTheme($type, $name)
    {
        $theme = Theme::where('type', $type)->where('name', $name)->first();
        
        if ($theme) {
            // Don't allow deactivating the default theme
            if ($theme->is_default) {
                return false;
            }
            
            $theme->update(['is_active' => false]);
            $this->clearCache();
            return true;
        }
        
        return false;
    }

    /**
     * Get all themes by type
     */
    public function getThemesByType($type)
    {
        try {
            return Cache::remember("{$this->cacheKey}_{$type}", 3600, function () use ($type) {
                return Theme::where('type', $type)->get();
            });
        } catch (\Exception $e) {
            // Fallback to database if cache fails
            return Theme::where('type', $type)->get();
        }
    }

    /**
     * Clear theme cache
     */
    public function clearCache()
    {
        try {
            Cache::forget($this->cacheKey);
            Cache::forget("{$this->cacheKey}_admin");
            Cache::forget("{$this->cacheKey}_frontend");
        } catch (\Exception $e) {
            // Ignore cache clearing errors
        }
    }
}