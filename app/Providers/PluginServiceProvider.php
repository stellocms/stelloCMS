<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\PluginManager;

class PluginServiceProvider extends ServiceProvider
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
        $pluginManager = app(PluginManager::class);
        $plugins = $pluginManager->getPlugins();
        
        foreach ($plugins as $plugin) {
            if ($plugin['active']) {
                // Register plugin views namespace
                $viewsPath = app_path("Plugins/{$plugin['name']}/Views");
                if (file_exists($viewsPath)) {
                    // Register with lowercase namespace to match view references
                    $namespace = strtolower($plugin['name']);
                    $this->loadViewsFrom($viewsPath, $namespace);
                }
                
                // Load plugin helpers if they exist
                $helpersPath = app_path("Plugins/{$plugin['name']}/helpers.php");
                if (file_exists($helpersPath)) {
                    require_once $helpersPath;
                }
                
                // Load plugin routes if they exist
                $routesPath = app_path("Plugins/{$plugin['name']}/routes.php");
                if (file_exists($routesPath)) {
                    require_once $routesPath;
                }
            }
        }
    }
}