<?php

namespace App\Providers;

use App\Services\WidgetService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WidgetService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(WidgetService $widgetService)
    {
        // Share widgets data only with frontend views using view composers
        View::composer([
            'theme.frontend.*',
            'theme.frontend.*::*',
            'Themes.frontend.*',
            'app.Themes.frontend.*'
        ], function ($view) use ($widgetService) {
            $widgets = $view->getData(); // Ambil data yang sudah ada
            
            foreach (['header', 'sidebar-left', 'sidebar-right', 'footer'] as $position) {
                $positionKey = $position . 'Widgets';
                if (!isset($widgets[$positionKey]) || !is_iterable($widgets[$positionKey])) {
                    $positionWidgets = $widgetService->getWidgetsByPosition($position);
                    // Proses setiap widget untuk mendapatkan kontennya
                    foreach ($positionWidgets as $widget) {
                        try {
                            $widget->rendered_content = $widgetService->renderWidget($widget);
                        } catch (\TypeError $e) {
                            // Jika terjadi TypeError, mungkin karena pengiriman parameter yang salah
                            $widget->rendered_content = '<div class="text-red-500">Error saat menampilkan widget: ' . htmlspecialchars($e->getMessage()) . '</div>';
                        } catch (\Exception $e) {
                            // Tangani exception lainnya
                            $widget->rendered_content = '<div class="text-red-500">Error saat menampilkan widget: ' . htmlspecialchars($e->getMessage()) . '</div>';
                        }
                    }
                    $view->with($positionKey, $positionWidgets);
                }
            }
            
            // Lakukan hal yang sama untuk homeWidgets
            if (!isset($widgets['homeWidgets']) || !is_iterable($widgets['homeWidgets'])) {
                $homeWidgets = $widgetService->getWidgetsByPosition('home');
                foreach ($homeWidgets as $widget) {
                    try {
                        $widget->rendered_content = $widgetService->renderWidget($widget);
                    } catch (\TypeError $e) {
                        // Jika terjadi TypeError, mungkin karena pengiriman parameter yang salah
                        $widget->rendered_content = '<div class="text-red-500">Error saat menampilkan widget: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    } catch (\Exception $e) {
                        // Tangani exception lainnya
                        $widget->rendered_content = '<div class="text-red-500">Error saat menampilkan widget: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                }
                $view->with('homeWidgets', $homeWidgets);
            }
        });
    }
}