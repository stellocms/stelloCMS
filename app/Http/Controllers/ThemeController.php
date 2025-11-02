<?php

namespace App\Http\Controllers;

use App\Services\ThemeManager;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    protected $themeManager;
    
    public function __construct(ThemeManager $themeManager)
    {
        $this->themeManager = $themeManager;
    }
    
    public function index()
    {
        $adminThemes = $this->themeManager->getAdminThemes();
        $frontendThemes = $this->themeManager->getFrontendThemes();
        
        return view_theme('admin', 'themes.index', compact('adminThemes', 'frontendThemes'));
    }
    
    public function switchAdminTheme(Request $request)
    {
        $themeName = $request->input('theme');
        
        if ($this->themeManager->setActiveAdminTheme($themeName)) {
            return redirect()->back()->with('success', "Tema admin berhasil diubah ke {$themeName}.");
        }
        
        return redirect()->back()->with('error', "Gagal mengubah tema admin ke {$themeName}.");
    }
    
    public function switchFrontendTheme(Request $request)
    {
        $themeName = $request->input('theme');
        
        if ($this->themeManager->setActiveFrontendTheme($themeName)) {
            return redirect()->back()->with('success', "Tema frontend berhasil diubah ke {$themeName}.");
        }
        
        return redirect()->back()->with('error', "Gagal mengubah tema frontend ke {$themeName}.");
    }
}