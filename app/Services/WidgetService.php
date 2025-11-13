<?php

namespace App\Services;

use App\Models\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionMethod;

class WidgetService
{
    /**
     * Get all active widgets by position
     *
     * @param string|null $position
     * @return Collection|array
     */
    public function getWidgetsByPosition(?string $position = null)
    {
        if ($position) {
            return Widget::aktif()->byPosition($position)->orderBy('order')->get();
        }
        
        return [
            'header' => Widget::aktif()->byPosition('header')->orderBy('order')->get(),
            'sidebar-left' => Widget::aktif()->byPosition('sidebar-left')->orderBy('order')->get(),
            'sidebar-right' => Widget::aktif()->byPosition('sidebar-right')->orderBy('order')->get(),
            'footer' => Widget::aktif()->byPosition('footer')->orderBy('order')->get(),
            'home' => Widget::aktif()->byPosition('home')->orderBy('order')->get(),
        ];
    }

    /**
     * Get widgets for a specific page
     *
     * @param string $page
     * @param array $positions
     * @return array
     */
    public function getWidgetsForPage(string $page, array $positions = ['header', 'sidebar-left', 'sidebar-right', 'footer']): array
    {
        $widgets = [];
        
        // Add page-specific widgets if they exist
        if ($page === 'home') {
            $positions[] = 'home';
        }
        
        foreach ($positions as $position) {
            $widgets[$position . 'Widgets'] = $this->getWidgetsByPosition($position);
        }
        
        return $widgets;
    }

    /**
     * Render a widget
     *
     * @param Widget $widget
     * @return string|null
     */
    public function renderWidget(Widget $widget): ?string
    {
        $content = '';
        
        switch ($widget->type) {
            case 'html':
                $content = $widget->content;
                break;
            case 'text':
                $content = Str::limit(strip_tags($widget->content ?? ''), 150, '...');
                break;
            case 'plugin':
                if ($widget->plugin_name) {
                    $pluginClass = "App\\Plugins\\" . $widget->plugin_name . "\\Controllers\\" . $widget->plugin_name . "Controller";
                    if (class_exists($pluginClass)) {
                        $controller = new $pluginClass();
                        
                        // Cek nama widget untuk menentukan fungsi yang benar
                        $methodName = $this->getWidgetMethodName($widget);
                        
                        if (method_exists($controller, $methodName)) {
                            try {
                                // Gunakan ReflectionMethod untuk menentukan cara memanggil fungsi
                                $methodReflection = new \ReflectionMethod($controller, $methodName);
                                $params = $methodReflection->getParameters();
                                
                                if (count($params) > 0) {
                                    $firstParam = $params[0];
                                    $type = $firstParam->getType();
                                    
                                    if ($type && $type->getName() === 'int') {
                                        // Parameter pertama adalah integer (misalnya limit), gunakan dari settings
                                        $limit = isset($widget->settings['limit']) ? intval($widget->settings['limit']) : 5;
                                        $content = $controller->$methodName($limit);
                                    } else {
                                        // Parameter pertama bukan integer, kirimkan widget
                                        $content = $controller->$methodName($widget);
                                    }
                                } else {
                                    // Fungsi tidak memiliki parameter
                                    $content = $controller->$methodName();
                                }
                            } catch (\TypeError $e) {
                                // Jika terjadi TypeError (biasanya karena pengiriman argumen yang salah), coba dengan limit
                                $limit = isset($widget->settings['limit']) ? intval($widget->settings['limit']) : 5;
                                $content = $controller->$methodName($limit);
                            }
                        } elseif (method_exists($controller, 'getWidgetContent')) {
                            $content = $controller->getWidgetContent($widget);
                        } elseif (method_exists($controller, 'get' . $widget->plugin_name . 'Widget')) {
                            $method = 'get' . $widget->plugin_name . 'Widget';
                            try {
                                $methodReflection = new \ReflectionMethod($controller, $method);
                                $params = $methodReflection->getParameters();
                                
                                if (count($params) > 0) {
                                    $firstParam = $params[0];
                                    $type = $firstParam->getType();
                                    
                                    if ($type && $type->getName() === 'int') {
                                        // Parameter pertama adalah integer (misalnya limit)
                                        $limit = isset($widget->settings['limit']) ? intval($widget->settings['limit']) : 5;
                                        $content = $controller->$method($limit);
                                    } else {
                                        $content = $controller->$method($widget);
                                    }
                                } else {
                                    // Fungsi tidak memiliki parameter
                                    $content = $controller->$method();
                                }
                            } catch (\TypeError $e) {
                                // Jika terjadi TypeError, coba dengan limit
                                $limit = isset($widget->settings['limit']) ? intval($widget->settings['limit']) : 5;
                                $content = $controller->$method($limit);
                            }
                        }
                    }
                }
                break;
        }
        
        return $content;
    }
    
    /**
     * Determine the widget method name based on widget name
     *
     * @param Widget $widget
     * @return string
     */
    public function getWidgetMethodName($widget): string
    {
        // Mapping specific widget names to their corresponding methods
        $methodMap = [
            'berita-terbaru-widget' => 'getLatestNewsWidget',
            'berita-populer-widget' => 'getPopularNewsWidget',
            'berita-acak-widget' => 'getRandomNewsWidget',
            'slider-berita-widget' => 'getSliderNewsWidget',
        ];
        
        return $methodMap[$widget->name] ?? 'get' . $widget->plugin_name . 'Widget';
    }
}