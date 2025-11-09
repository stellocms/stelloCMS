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
        // Get theme from database first, fallback to config if not found
        try {
            $themeService = app(\App\Services\ThemeService::class);
            $dbTheme = $themeService->getDefaultTheme($type);
            
            if ($dbTheme) {
                $theme = $dbTheme->name;
            } else {
                // Fallback to config if no theme found in database
                $theme = config("themes.{$type}", $type === 'admin' ? 'adminlte' : 'stocker');
            }
        } catch (\Exception $e) {
            // If there's an issue with the service, fallback to config
            $theme = config("themes.{$type}", $type === 'admin' ? 'adminlte' : 'stocker');
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