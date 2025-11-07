<?php

namespace App\Http\Controllers;

use App\Services\ThemeService;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ThemeController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * Display a listing of the themes.
     */
    public function index()
    {
        $frontendThemes = $this->themeService->getThemesByType('frontend');
        $adminThemes = $this->themeService->getThemesByType('admin');

        return view('theme.admin.adminlte::themes.index', compact('frontendThemes', 'adminThemes'));
    }

    /**
     * Install a theme
     */
    public function install(Request $request, $type, $name)
    {
        $theme = $this->themeService->installTheme($type, $name);
        
        if ($theme) {
            return redirect()->back()->with('success', "Theme {$name} installed successfully.");
        }
        
        return redirect()->back()->with('error', "Failed to install theme {$name}.");
    }

    /**
     * Uninstall a theme
     */
    public function uninstall(Request $request, $type, $name)
    {
        $result = $this->themeService->uninstallTheme($type, $name);
        
        if ($result) {
            return redirect()->back()->with('success', "Theme {$name} uninstalled successfully.");
        }
        
        return redirect()->back()->with('error', "Failed to uninstall theme {$name}.");
    }

    /**
     * Activate a theme
     */
    public function activate(Request $request, $type, $name)
    {
        $result = $this->themeService->activateTheme($type, $name);
        
        if ($result) {
            return redirect()->back()->with('success', "Theme {$name} activated successfully.");
        }
        
        return redirect()->back()->with('error', "Failed to activate theme {$name}.");
    }

    /**
     * Deactivate a theme
     */
    public function deactivate(Request $request, $type, $name)
    {
        $result = $this->themeService->deactivateTheme($type, $name);
        
        if ($result) {
            return redirect()->back()->with('success', "Theme {$name} deactivated successfully.");
        }
        
        return redirect()->back()->with('error', "Failed to deactivate theme {$name}.");
    }

    /**
     * Set a theme as default
     */
    public function setDefault(Request $request, $type, $name)
    {
        $result = $this->themeService->setDefaultTheme($type, $name);
        
        if ($result) {
            return redirect()->back()->with('success', "Theme {$name} set as default successfully.");
        }
        
        return redirect()->back()->with('error', "Failed to set theme {$name} as default.");
    }

    /**
     * Scan for available themes in the filesystem
     */
    public function scan()
    {
        // Scan directories for available themes
        $themeDirs = [
            'frontend' => app_path('Themes/frontend'),
            'admin' => app_path('Themes/admin'),
        ];

        $foundThemes = [];

        foreach ($themeDirs as $type => $dir) {
            if (is_dir($dir)) {
                foreach (scandir($dir) as $themeDir) {
                    if ($themeDir !== '.' && $themeDir !== '..') {
                        $themePath = $dir . '/' . $themeDir;
                        if (is_dir($themePath)) {
                            // Check if theme.json exists
                            $themeJsonPath = $themePath . '/theme.json';
                            
                            if (file_exists($themeJsonPath)) {
                                $themeData = json_decode(file_get_contents($themeJsonPath), true);
                                $themeData['name'] = $themeDir;
                                $themeData['type'] = $type;
                                
                                // Check if theme exists in database
                                $dbTheme = Theme::where('type', $type)->where('name', $themeDir)->first();
                                
                                if ($dbTheme) {
                                    // Update existing theme
                                    $dbTheme->update([
                                        'version' => $themeData['version'] ?? null,
                                        'description' => $themeData['description'] ?? null,
                                        'author' => $themeData['author'] ?? null,
                                        'author_url' => $themeData['author_url'] ?? null,
                                        'screenshot' => $themeData['screenshot'] ?? null,
                                        'tags' => $themeData['tags'] ?? null,
                                    ]);
                                } else {
                                    // Create new theme record
                                    Theme::create([
                                        'name' => $themeDir,
                                        'type' => $type,
                                        'version' => $themeData['version'] ?? null,
                                        'description' => $themeData['description'] ?? null,
                                        'author' => $themeData['author'] ?? null,
                                        'author_url' => $themeData['author_url'] ?? null,
                                        'screenshot' => $themeData['screenshot'] ?? null,
                                        'tags' => $themeData['tags'] ?? null,
                                        'is_active' => true,
                                        'is_installed' => true,
                                        'is_default' => false,
                                    ]);
                                }
                                
                                $foundThemes[] = $themeData;
                            } else {
                                // Create theme record without metadata
                                if (!Theme::where('type', $type)->where('name', $themeDir)->exists()) {
                                    Theme::create([
                                        'name' => $themeDir,
                                        'type' => $type,
                                        'description' => 'Theme without metadata',
                                        'is_active' => true,
                                        'is_installed' => true,
                                        'is_default' => false,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->themeService->clearCache();
        
        return redirect()->back()->with('success', 'Themes scanned and database updated successfully.');
    }

    /**
     * Sync themes from filesystem to database
     */
    public function sync()
    {
        // Run the scan method to sync themes
        return $this->scan();
    }

    /**
     * Switch admin theme (for backward compatibility)
     */
    public function switchAdminTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|string'
        ]);

        $result = $this->themeService->setDefaultTheme('admin', $request->theme);

        if ($result) {
            return redirect()->back()->with('success', 'Admin theme changed successfully.');
        }

        return redirect()->back()->with('error', 'Failed to change admin theme.');
    }

    /**
     * Switch frontend theme
     */
    public function switchFrontendTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|string'
        ]);

        $result = $this->themeService->setDefaultTheme('frontend', $request->theme);

        if ($result) {
            return redirect()->back()->with('success', 'Frontend theme changed successfully.');
        }

        return redirect()->back()->with('error', 'Failed to change frontend theme.');
    }

    /**
     * Upload a new theme
     */
    public function upload(Request $request)
    {
        $request->validate([
            'theme_file' => 'required|file|mimes:zip|max:10240', // Max 10MB
        ]);

        try {
            $file = $request->file('theme_file');
            $fileName = $file->getClientOriginalName();
            $themeName = pathinfo($fileName, PATHINFO_FILENAME);
            
            // Create temporary directory for extraction
            $tempBasePath = storage_path('app/temp/themes');
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
            
            // Find the theme directory in extracted files
            $extractedFiles = scandir($tempPath);
            $themeDir = null;
            $themeName = null;
            
            foreach ($extractedFiles as $item) {
                if ($item !== '.' && $item !== '..') {
                    $itemPath = $tempPath . '/' . $item;
                    if (is_dir($itemPath)) {
                        // Check if this directory contains theme.json
                        if (file_exists($itemPath . '/theme.json')) {
                            $themeDir = $itemPath;
                            $themeName = $item;
                            break;
                        }
                    }
                }
            }
            
            if (!$themeDir || !$themeName) {
                throw new \Exception('Invalid theme structure: Theme directory with theme.json not found');
            }
            
            // Check if theme.json exists
            $themeJsonPath = $themeDir . '/theme.json';
            if (!file_exists($themeJsonPath)) {
                throw new \Exception('Invalid theme structure: theme.json not found');
            }
            
            // Read theme metadata
            $themeData = json_decode(file_get_contents($themeJsonPath), true);
            if (!$themeData) {
                throw new \Exception('Invalid theme.json file');
            }
            
            // Validate required fields
            if (!isset($themeData['name'])) {
                $themeData['name'] = $themeName;
            }
            
            if (!isset($themeData['type'])) {
                $themeData['type'] = 'frontend';
            }
            
            // Move theme files to app directory
            $appThemePath = app_path('Themes/frontend/' . $themeName);
            if (!file_exists($appThemePath)) {
                mkdir($appThemePath, 0755, true);
            }
            
            // Copy theme files
            $this->copyDirectory($themeDir, $appThemePath);
            
            // Move public assets to public directory
            $publicAssets = ['css', 'js', 'img', 'lib'];
            $publicThemePath = public_path('themes/' . $themeName);
            
            if (!file_exists($publicThemePath)) {
                mkdir($publicThemePath, 0755, true);
            }
            
            foreach ($publicAssets as $assetDir) {
                $sourceDir = $themeDir . '/' . $assetDir;
                $destDir = $publicThemePath . '/' . $assetDir;
                
                if (file_exists($sourceDir)) {
                    if (!file_exists($destDir)) {
                        mkdir($destDir, 0755, true);
                    }
                    $this->copyDirectory($sourceDir, $destDir);
                }
            }
            
            // Register theme in database
            $dbTheme = Theme::firstOrCreate([
                'name' => $themeName,
                'type' => 'frontend',
            ], [
                'version' => $themeData['version'] ?? '1.0.0',
                'description' => $themeData['description'] ?? 'Uploaded theme',
                'author' => $themeData['author'] ?? 'Unknown',
                'author_url' => $themeData['author_url'] ?? '',
                'screenshot' => $themeData['screenshot'] ?? '',
                'tags' => isset($themeData['tags']) ? json_encode($themeData['tags']) : json_encode([]),
                'is_active' => true,
                'is_installed' => true,
                'is_default' => false,
            ]);
            
            // Clean up temporary files
            $this->deleteDirectory($tempPath);
            
            return redirect()->back()->with('success', 'Theme uploaded and installed successfully.');
            
        } catch (\Exception $e) {
            // Clean up temporary files on error
            if (isset($tempPath) && file_exists($tempPath)) {
                $this->deleteDirectory($tempPath);
            }
            
            return redirect()->back()->with('error', 'Failed to upload theme: ' . $e->getMessage());
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