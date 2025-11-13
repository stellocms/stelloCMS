<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FrontendController extends Controller
{
    /**
     * Add widgets data to view data using view_theme helper
     *
     * @param string $themeType
     * @param string $view
     * @param array $data
     * @return \Illuminate\Contracts\View\View|RedirectResponse|JsonResponse
     */
    protected function view_theme_with_widgets($themeType, $view, $data = [])
    {
        // Ambil semua widget yang mungkin diperlukan dan tambahkan ke data
        $widgetService = $this->getWidgetService();
        $widgets = $widgetService->getWidgetsForPage('general', ['header', 'sidebar-left', 'sidebar-right', 'footer']);
        
        // Tambahkan homeWidgets jika view adalah home.index
        if ($view === 'home.index') {
            $widgets['homeWidgets'] = $widgetService->getWidgetsByPosition('home');
        }
        
        // Gabungkan widget dengan data lainnya
        $mergedData = array_merge($data, $widgets);
        
        return view_theme($themeType, $view, $mergedData);
    }
    
    /**
     * Get the widget service instance
     *
     * @return WidgetService
     */
    protected function getWidgetService(): \App\Services\WidgetService
    {
        return app(\App\Services\WidgetService::class);
    }
}