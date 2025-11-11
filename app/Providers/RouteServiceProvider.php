<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     */
    public const HOME = '/panel/dashboard';

    /**
     * The path to your application's login route.
     */
    public const LOGIN_PATH = '/panel';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->loadPlugins();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
                
            // Load panel routes within the web middleware group
            Route::middleware('web')
                ->group(base_path('routes/panel.php'));
        });
    }

    /**
     * Load all plugins automatically
     */
    protected function loadPlugins(): void
    {
        $pluginManager = app(\App\Services\PluginManager::class);
        $plugins = $pluginManager->getPlugins();
        
        foreach ($plugins as $plugin) {
            if ($plugin['active']) {
                $pluginManager->loadPlugin($plugin['name']);
            }
        }
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}