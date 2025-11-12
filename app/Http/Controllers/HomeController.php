<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Widget;
use Illuminate\Http\Request;

class HomeController extends Controller
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

        // Ambil widget berdasarkan posisi
        $headerWidgets = Widget::aktif()
                               ->byPosition('header')
                               ->orderBy('order')
                               ->get();

        $sidebarLeftWidgets = Widget::aktif()
                                    ->byPosition('sidebar-left')
                                    ->orderBy('order')
                                    ->get();

        $sidebarRightWidgets = Widget::aktif()
                                     ->byPosition('sidebar-right')
                                     ->orderBy('order')
                                     ->get();

        $footerWidgets = Widget::aktif()
                               ->byPosition('footer')
                               ->orderBy('order')
                               ->get();

        $homeWidgets = Widget::aktif()
                             ->byPosition('home')
                             ->orderBy('order')
                             ->get();

        return view_theme('frontend', 'home.index', compact(
            'headerMenus',
            'headerWidgets',
            'sidebarLeftWidgets',
            'sidebarRightWidgets',
            'footerWidgets',
            'homeWidgets'
        ));
    }
}