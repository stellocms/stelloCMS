<?php

namespace App\Http\Controllers;

use App\Services\PluginManager;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    protected $pluginManager;
    
    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }
    
    public function index()
    {
        $plugins = $this->pluginManager->getPlugins();
        
        return view_theme('admin', 'plugins.index', compact('plugins'));
    }
    
    public function activate(Request $request, $pluginName)
    {
        if ($this->pluginManager->activatePlugin($pluginName)) {
            return redirect()->back()->with('success', "Plugin {$pluginName} berhasil diaktifkan.");
        }
        
        return redirect()->back()->with('error', "Gagal mengaktifkan plugin {$pluginName}.");
    }
    
    public function deactivate(Request $request, $pluginName)
    {
        if ($this->pluginManager->deactivatePlugin($pluginName)) {
            return redirect()->back()->with('success', "Plugin {$pluginName} berhasil dinonaktifkan.");
        }
        
        return redirect()->back()->with('error', "Gagal menonaktifkan plugin {$pluginName}.");
    }
    
    public function install(Request $request, $pluginName)
    {
        if ($this->pluginManager->installPlugin($pluginName)) {
            return redirect()->back()->with('success', "Plugin {$pluginName} berhasil diinstal.");
        }
        
        return redirect()->back()->with('error', "Gagal menginstal plugin {$pluginName}.");
    }
    
    public function uninstall(Request $request, $pluginName)
    {
        if ($this->pluginManager->uninstallPlugin($pluginName)) {
            return redirect()->back()->with('success', "Plugin {$pluginName} berhasil dihapus.");
        }
        
        return redirect()->back()->with('error', "Gagal menghapus plugin {$pluginName}.");
    }
}