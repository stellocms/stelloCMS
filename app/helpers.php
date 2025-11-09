<?php

if (!function_exists('cms_name')) {
    /**
     * Get the CMS name from configuration
     */
    function cms_name()
    {
        return config('cms.name', 'stelloCMS');
    }
}

if (!function_exists('cms_description')) {
    /**
     * Get the CMS description from configuration
     */
    function cms_description()
    {
        return config('cms.description', 'Limitless Online Content Management');
    }
}

if (!function_exists('view_theme')) {
    /**
     * Render a view with theme support
     */
    function view_theme($type, $view, $data = [])
    {
        try {
            // Get theme from database first, fallback to config if not found
            $theme = config("themes.{$type}", $type === 'admin' ? 'adminlte' : 'stocker');
            
            // If ThemeService exists and can be accessed, try to get theme from database
            if (class_exists('\App\Services\ThemeService')) {
                try {
                    $themeService = app(\App\Services\ThemeService::class);
                    $dbTheme = $themeService->getDefaultTheme($type);
                    
                    if ($dbTheme) {
                        $theme = $dbTheme->name;
                    }
                } catch (\Exception $e) {
                    // If ThemeService fails, use config fallback
                    $theme = config("themes.{$type}", $type === 'admin' ? 'adminlte' : 'stocker');
                }
            }
            
            $namespace = "theme.{$type}.{$theme}";
            $viewName = "{$namespace}::{$view}";

            // Check if view exists with namespace
            if (view()->exists($viewName)) {
                return view($viewName, $data);
            }
            
            // Try without namespace as fallback
            $path = "Themes/{$type}/{$theme}/{$view}";
            if (view()->exists($path)) {
                return view($path, $data);
            }

            // Final fallback to default view
            return view($view, $data);
        } catch (\Exception $e) {
            // If anything goes wrong, return a simple welcome message
            if ($type === 'frontend' && $view === 'home.index') {
                return '<div class="container"><h1>stelloCMS</h1><p>Selamat datang di sistem stelloCMS.</p></div>';
            }
            
            return view($view, $data);
        }
    }
}

if (!function_exists('generate_slug')) {
    /**
     * Generate a URL-friendly slug from a string
     */
    function generate_slug($string, $separator = '-')
    {
        // Convert to lowercase
        $string = strtolower($string);
        
        // Remove special characters and replace spaces with separator
        $string = preg_replace('/[^a-z0-9-_.]+/', $separator, $string);
        
        // Remove multiple occurrences of separator
        $string = preg_replace('/' . preg_quote($separator) . '+/', $separator, $string);
        
        // Trim separator from the beginning and end
        $string = trim($string, $separator);
        
        // If string is empty after processing, use a default
        if (empty($string)) {
            $string = 'untitled-' . time();
        }
        
        return $string;
    }
}