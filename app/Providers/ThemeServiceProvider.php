<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
}