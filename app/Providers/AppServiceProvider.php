<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\PluginManager;
use App\Console\Commands\InstallContohPlugin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the PluginManager as a singleton
        $this->app->singleton(PluginManager::class, function ($app) {
            return new PluginManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerThemeViews();
        $this->loadPlugins();
        $this->registerCommands();
    }

    /**
     * Register theme views
     */
    protected function registerThemeViews(): void
    {
        // Register admin themes
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

        // Register frontend themes
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
     * Load all plugins automatically
     */
    protected function loadPlugins(): void
    {
        // Plugin loading is handled by PluginServiceProvider
        // This method exists to maintain compatibility but does nothing
        // PluginServiceProvider handles the loading to ensure proper timing
    }
    
    /**
     * Register console commands
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallContohPlugin::class,
            ]);
        }
    }
}