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