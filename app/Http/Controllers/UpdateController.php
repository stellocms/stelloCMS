<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    protected $githubRepo = 'stellocms/stelloCMS';
    protected $githubApiBaseUrl = 'https://api.github.com/repos/';
    
    public function index()
    {
        return view('theme.admin.' . config('themes.admin') . '::update.index');
    }
    
    public function checkLatestVersion()
    {
        try {
            $response = Http::get($this->githubApiBaseUrl . $this->githubRepo . '/releases/latest');
            
            if ($response->successful()) {
                $latestRelease = $response->json();
                $latestVersion = $latestRelease['tag_name'];
                
                // Remove 'v' prefix if exists
                $latestVersion = ltrim($latestVersion, 'v');
                
                $currentVersion = config('app.version');
                
                // Compare versions
                $hasUpdate = version_compare($currentVersion, $latestVersion, '<');
                
                return response()->json([
                    'current_version' => $currentVersion,
                    'latest_version' => $latestVersion,
                    'has_update' => $hasUpdate,
                    'release_url' => $latestRelease['html_url'] ?? null,
                    'published_at' => $latestRelease['published_at'] ?? null,
                    'message' => $latestRelease['body'] ?? null
                ]);
            } else {
                return response()->json([
                    'error' => 'Gagal mengambil informasi versi terbaru',
                    'message' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error checking latest version: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Gagal menghubungi server GitHub',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getChangelog()
    {
        try {
            $response = Http::get('https://raw.githubusercontent.com/' . $this->githubRepo . '/main/CHANGELOG.md');
            
            if ($response->successful()) {
                $changelog = $response->body();
                
                // Convert markdown to HTML
                $changelogHtml = $this->markdownToHtml($changelog);
                
                return response($changelogHtml);
            } else {
                return response('<div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Gagal Memuat Catatan Pembaruan!</h5>
                    <p>Tidak dapat mengambil catatan pembaruan dari GitHub.</p>
                </div>');
            }
        } catch (\Exception $e) {
            Log::error('Error getting changelog: ' . $e->getMessage());
            
            return response('<div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Gagal Memuat Catatan Pembaruan!</h5>
                <p>' . $e->getMessage() . '</p>
            </div>');
        }
    }
    
    private function markdownToHtml($markdown)
    {
        // Simple markdown to HTML conversion
        $html = $markdown;
        
        // Convert headers
        $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
        $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
        $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $html);
        
        // Bold
        $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
        
        // Italic
        $html = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $html);
        
        // Code blocks
        $html = preg_replace('/`(.+?)`/', '<code>$1</code>', $html);
        
        // Simple paragraph conversion
        $html = nl2br($html);
        
        return $html;
    }
    
    public function performUpdate(Request $request)
    {
        // In a real implementation, this would perform actual update
        // For now, we'll just simulate the update process
        
        $currentVersion = config('app.version');
        
        try {
            // Simulate update process
            sleep(2); // Simulate download time
            
            // This would normally:
            // 1. Download latest release
            // 2. Extract files
            // 3. Run database migrations if needed
            // 4. Clear caches
            // 5. Update version in config
            
            // For simulation purposes, we'll just update the version in config file
            $this->simulateUpdate();
            
            return response()->json([
                'success' => true,
                'message' => 'Sistem berhasil diperbarui!',
                'new_version' => config('app.version')
            ]);
        } catch (\Exception $e) {
            Log::error('Error performing update: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan pembaruan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function simulateUpdate()
    {
        // In a real implementation, this would perform actual update operations
        // For now, we'll just update the version in config/app.php
        $configPath = config_path('app.php');
        $configContent = file_get_contents($configPath);
        
        // Update version in config - make sure to use version that's higher than current
        $newVersion = $this->getNextVersion(config('app.version'));
        $configContent = preg_replace(
            "/'version' => '(.+?)',/",
            "'version' => '" . $newVersion . "',",
            $configContent
        );
        
        file_put_contents($configPath, $configContent);
    }
    
    private function getNextVersion($currentVersion)
    {
        // Simple version increment function for simulation
        $parts = explode('.', $currentVersion);
        if (count($parts) >= 3) {
            $parts[2] = (int)$parts[2] + 1;  // Increment patch version
        } else {
            $parts[] = '1';  // If format isn't x.y.z, append .1
        }
        
        return implode('.', $parts);
    }
}