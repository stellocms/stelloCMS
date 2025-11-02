<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ThemeManager
{
    protected $themesPath;
    
    public function __construct()
    {
        $this->themesPath = app_path('Themes');
    }
    
    /**
     * Get all available admin themes
     */
    public function getAdminThemes()
    {
        $adminThemesPath = $this->themesPath . '/admin';
        
        if (!File::exists($adminThemesPath)) {
            return [];
        }
        
        $themes = [];
        foreach (File::directories($adminThemesPath) as $themePath) {
            $themeName = basename($themePath);
            
            // Only include adminlte theme
            if ($themeName === 'adminlte') {
                $themes[] = [
                    'name' => $themeName,
                    'path' => $themePath,
                    'active' => config('themes.admin') === $themeName
                ];
            }
        }
        
        return $themes;
    }
    
    /**
     * Get all available frontend themes
     */
    public function getFrontendThemes()
    {
        $frontendThemesPath = $this->themesPath . '/frontend';
        
        if (!File::exists($frontendThemesPath)) {
            return [];
        }
        
        $themes = [];
        foreach (File::directories($frontendThemesPath) as $themePath) {
            $themeName = basename($themePath);
            $themes[] = [
                'name' => $themeName,
                'path' => $themePath,
                'active' => config('themes.frontend') === $themeName
            ];
        }
        
        return $themes;
    }
    
    /**
     * Set active admin theme
     */
    public function setActiveAdminTheme($themeName)
    {
        $adminThemes = $this->getAdminThemes();
        $themeNames = array_column($adminThemes, 'name');
        
        if (in_array($themeName, $themeNames)) {
            // Update the .env file
            $this->updateEnvFile('ADMIN_THEME', $themeName);
            
            // Clear config cache to reload the new theme
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Set active frontend theme
     */
    public function setActiveFrontendTheme($themeName)
    {
        $frontendThemes = $this->getFrontendThemes();
        $themeNames = array_column($frontendThemes, 'name');
        
        if (in_array($themeName, $themeNames)) {
            // Update the .env file
            $this->updateEnvFile('FRONTEND_THEME', $themeName);
            
            // Clear config cache to reload the new theme
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Update .env file with new theme setting
     */
    protected function updateEnvFile($key, $value)
    {
        $envPath = base_path('.env');
        
        if (File::exists($envPath)) {
            $content = File::get($envPath);
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            File::put($envPath, $content);
        }
    }
}