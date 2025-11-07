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
    
    public function upload(Request $request)
    {
        $request->validate([
            'plugin_file' => 'required|file|mimes:zip|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('plugin_file');
            $fileName = $file->getClientOriginalName();
            $pluginName = pathinfo($fileName, PATHINFO_FILENAME);
            
            // Create temporary directory for extraction
            $tempBasePath = storage_path('app/temp/plugins');
            if (!file_exists($tempBasePath)) {
                mkdir($tempBasePath, 0755, true);
            }
            
            $tempPath = $tempBasePath . '/' . uniqid();
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }
            
            // Extract ZIP file
            $zip = new \ZipArchive();
            if ($zip->open($file->getRealPath()) === TRUE) {
                $zip->extractTo($tempPath);
                $zip->close();
            } else {
                throw new \Exception('Failed to extract ZIP file');
            }
            
            // Find the plugin directory in extracted files
            $extractedFiles = scandir($tempPath);
            $pluginDir = null;
            $pluginName = null;
            
            foreach ($extractedFiles as $item) {
                if ($item !== '.' && $item !== '..') {
                    $itemPath = $tempPath . '/' . $item;
                    if (is_dir($itemPath)) {
                        // Check if this directory contains plugin.json or main plugin file
                        if (file_exists($itemPath . '/plugin.json') || file_exists($itemPath . '/Plugin.php')) {
                            $pluginDir = $itemPath;
                            $pluginName = $item;
                            break;
                        }
                    }
                }
            }
            
            if (!$pluginDir || !$pluginName) {
                throw new \Exception('Invalid plugin structure: Plugin directory with plugin.json or Plugin.php not found');
            }
            
            // Check if plugin.json exists
            $pluginJsonPath = $pluginDir . '/plugin.json';
            if (!file_exists($pluginJsonPath)) {
                throw new \Exception('Invalid plugin structure: plugin.json not found');
            }
            
            // Read plugin metadata
            $pluginData = json_decode(file_get_contents($pluginJsonPath), true);
            if (!$pluginData) {
                throw new \Exception('Invalid plugin.json file');
            }
            
            // Validate required fields
            if (!isset($pluginData['name'])) {
                $pluginData['name'] = $pluginName;
            }
            
            // Move plugin files to app directory
            $appPluginPath = app_path('Plugins/' . $pluginName);
            if (file_exists($appPluginPath)) {
                throw new \Exception("Plugin {$pluginName} sudah ada. Harap hapus dulu plugin yang lama sebelum mengupload yang baru.");
            }
            
            if (!file_exists($appPluginPath)) {
                mkdir($appPluginPath, 0755, true);
            }
            
            // Copy plugin files
            $this->copyDirectory($pluginDir, $appPluginPath);
            
            // Clean up temporary files
            $this->deleteDirectory($tempPath);
            
            return redirect()->back()->with('success', "Plugin {$pluginName} berhasil diupload dan diinstal.");
            
        } catch (\Exception $e) {
            // Clean up temporary files on error
            if (isset($tempPath) && file_exists($tempPath)) {
                $this->deleteDirectory($tempPath);
            }
            
            return redirect()->back()->with('error', 'Failed to upload plugin: ' . $e->getMessage());
        }
    }
    
    /**
     * Copy directory recursively
     */
    private function copyDirectory($source, $destination)
    {
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }
        
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $sourcePath = $source . '/' . $file;
                $destPath = $destination . '/' . $file;
                
                if (is_dir($sourcePath)) {
                    $this->copyDirectory($sourcePath, $destPath);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }
    }
    
    /**
     * Delete directory recursively
     */
    private function deleteDirectory($dirPath)
    {
        if (!file_exists($dirPath)) {
            return;
        }
        
        if (!is_dir($dirPath)) {
            unlink($dirPath);
            return;
        }
        
        $files = array_diff(scandir($dirPath), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $dirPath . '/' . $file;
            if (is_dir($filePath)) {
                $this->deleteDirectory($filePath);
            } else {
                unlink($filePath);
            }
        }
        
        rmdir($dirPath);
    }
}