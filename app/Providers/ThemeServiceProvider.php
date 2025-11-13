<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerThemeViews();
        $this->updateThemeConfiguration();
    }

    /**
     * Register theme views
     */
    protected function registerThemeViews(): void
    {
        // Register admin themes from app/Themes/admin
        $adminThemesPath = app_path('Themes/admin');
        if (is_dir($adminThemesPath)) {
            foreach (scandir($adminThemesPath) as $theme) {
                if (in_array($theme, ['.', '..'])) continue;

                $themePath = $adminThemesPath . '/' . $theme;
                if (is_dir($themePath)) {
                    $this->loadViewsFrom($themePath, "theme.admin.{$theme}");
                }
            }
        }

        // Register frontend themes from app/Themes/frontend
        $frontendThemesPath = app_path('Themes/frontend');
        if (is_dir($frontendThemesPath)) {
            foreach (scandir($frontendThemesPath) as $theme) {
                if (in_array($theme, ['.', '..'])) continue;

                $themePath = $frontendThemesPath . '/' . $theme;
                if (is_dir($themePath)) {
                    $this->loadViewsFrom($themePath, "theme.frontend.{$theme}");
                }
            }
        }
    }

    /**
     * Update theme configuration from database
     */
    protected function updateThemeConfiguration()
    {
        // After application boots, update the theme config with values from database
        $this->app->booted(function () {
            try {
                if (class_exists(\App\Services\ThemeService::class)) {
                    $themeService = app(\App\Services\ThemeService::class);
                    
                    // Get default themes from database
                    $adminTheme = $themeService->getDefaultTheme('admin');
                    $frontendTheme = $themeService->getDefaultTheme('frontend');
                    
                    // Override the config values with values from database if available
                    if ($adminTheme) {
                        \Illuminate\Support\Facades\Config::set('themes.admin', $adminTheme->name);
                    }
                    
                    if ($frontendTheme) {
                        \Illuminate\Support\Facades\Config::set('themes.frontend', $frontendTheme->name);
                    }
                }
            } catch (\Exception $e) {
                // If there's an error, let config use fallback from env
                \Log::warning('Failed to update theme config from database: ' . $e->getMessage());
            }
        });
    }
}