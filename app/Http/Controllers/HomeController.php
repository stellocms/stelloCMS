<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Widget;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil menu untuk header
        $headerMenus = Menu::where('type', 'frontend')
                           ->where('position', 'header')
                           ->where('is_active', true)
                           ->orderBy('order')
                           ->get();

        // Ambil widget home khusus untuk halaman ini
        $homeWidgets = Widget::aktif()->byPosition('home')->orderBy('order')->get();

        return $this->view_theme_with_widgets('frontend', 'home.index', compact(
            'headerMenus'
        ));
    }
}