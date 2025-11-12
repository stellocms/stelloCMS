<?php
// Skrip untuk menginstal plugin Kategori

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap aplikasi Laravel secara minimal
$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->bind('Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables', function () {
    return new class implements Illuminate\Contracts\Foundation\Application {
        public function configurationIsCached() { return false; }
        public function environmentFile() { return '.env'; }
        public function environmentPath() { return __DIR__; }
        public function environment() { $args = func_get_args(); return count($args) ? in_array($_ENV['APP_ENV'] ?? 'production', $args) : $_ENV['APP_ENV'] ?? 'production'; }
        public function runningInConsole() { return true; }
        public function version() { return '1.0.0'; }
        public function basePath($path = '') { return __DIR__ . ($path ? '/' . $path : ''); }
        public function bootstrapPath($path = '') { return $this->basePath('bootstrap'); }
        public function configPath($path = '') { return $this->basePath('config'); }
        public function databasePath($path = '') { return $this->basePath('database'); }
        public function environmentPath() { return $this->basePath(); }
        public function resourcePath($path = '') { return $this->basePath('resources'); }
        public function storagePath($path = '') { return $this->basePath('storage'); }
        public function publicPath() { return $this->basePath('public'); }
        public function langPath($path = '') { return $this->resourcePath('lang'); }
        public function locale() { return $_ENV['APP_LOCALE'] ?? 'en'; }
        public function getProvider($provider) { return new stdClass(); }
        public function getProviders($provider) { return [new stdClass()]; }
        public function resolveProvider($provider) { return new stdClass(); }
        public function registerConfiguredProviders() { }
        public function register($provider, $options = [], $force = false) { }
        public function registerDeferredProvider($provider, $service = null) { }
        public function bindIf($abstract, $concrete = null, $shared = false) { }
        public function singleton($abstract, $concrete = null) { }
        public function singletonIf($abstract, $concrete = null) { }
        public function bindEagerSingletons() { }
        public function afterResolving($abstract, $callback = null) { }
        public function resolve($abstract, array $parameters = []) { return new stdClass(); }
        public function bound($abstract) { return true; }
        public function has($id) { return true; }
        public function isShared($abstract) { return false; }
        public function isAlias($name) { return false; }
        public function bindMethod($method, $callback) { }
        public function callMethod($method, $parameters = []) { return null; }
        public function extend($abstract, $closure) { }
        public function instance($abstract, $instance) { }
        public function tag($abstracts, $tags) { }
        public function tagged($tag) { return collect([]); }
        public function flush() { }
        public function getAlias($abstract) { return $abstract; }
        public function make($abstract, array $parameters = []) { 
            if ($abstract === 'env') return $_ENV['DB_CONNECTION'] ?? 'mysql';
            return new stdClass();
        }
        public function get($id) { return $this; }
        public function offsetExists($offset) { return true; }
        public function offsetGet($offset) { return $this; }
        public function offsetSet($offset, $value) { }
        public function offsetUnset($offset) { }
        public function forgetExtenders($abstract) { }
        public function forgetInstance($abstract) { }
        public function forgetInstances() { }
        public function forgetScopedInstances() { }
        public function bootstrap() { }
        public function hasBeenBootstrapped() { return true; }
        public function boot() { }
        public function isBooted() { return true; }
        public function booting($callback) { }
        public function booted($callback) { }
        public function setBasePath($basePath) { return $this; }
        public function useAppPath($path) { return $this; }
        public function useDatabasePath($path) { return $this; }
        public function useConfigurationPath($path) { return $this; }
        public function useLanguagePath($path) { return $this; }
        public function usePublicPath($path) { return $this; }
        public function useStoragePath($path) { return $this; }
        public function useResourcePath($path) { return $this; }
        public function getInstance() { return $this; }
    };
});

try {
    // Coba untuk bootstrap aplikasi dengan konfigurasi minimal
    $app->instance('app', $app);
    $app->instance('Illuminate\Container\Container', $app);
    
    // Coba load konfigurasi database
    $app->bind('config', function() {
        $config = new Illuminate\Config\Repository();
        $config->set('database.default', $_ENV['DB_CONNECTION'] ?? 'mysql');
        $config->set('database.connections.mysql', [
            'driver' => 'mysql',
            'url' => $_ENV['DATABASE_URL'] ?? null,
            'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'port' => $_ENV['DB_PORT'] ?? '3306',
            'database' => $_ENV['DB_DATABASE'] ?? 'forge',
            'username' => $_ENV['DB_USERNAME'] ?? 'forge',
            'password' => $_ENV['DB_PASSWORD'] ?? '',
        ]);
        return $config;
    });

    // Set up database connection
    $app->bind('db', function($app) {
        return new Illuminate\Database\DatabaseManager($app, $app['db.factory']);
    });

    // Coba untuk install plugin Kategori via PluginManager
    $pluginManager = new \App\Services\PluginManager();
    
    // Cek apakah plugin Kategori sudah ada di database
    $pluginModel = new \App\Models\Plugin();
    $kategoriPlugin = $pluginModel->where('name', 'Kategori')->first();
    
    if ($kategoriPlugin) {
        echo "Plugin Kategori sudah terdaftar di database\n";
        echo "Status: " . ($kategoriPlugin->installed ? 'INSTALLED' : 'NOT INSTALLED') . 
             ", Active: " . ($kategoriPlugin->active ? 'ACTIVE' : 'INACTIVE') . "\n";
        
        if (!$kategoriPlugin->active) {
            // Coba aktifkan plugin
            $pluginManager->activatePlugin('Kategori');
            echo "Plugin Kategori telah diaktifkan\n";
        }
    } else {
        echo "Plugin Kategori belum terdaftar di database\n";
        // Coba install plugin
        $result = $pluginManager->installPlugin('Kategori');
        if ($result) {
            echo "Plugin Kategori berhasil diinstal dan diaktifkan\n";
        } else {
            echo "Gagal menginstal Plugin Kategori\n";
        }
    }
    
    echo "Proses selesai. Silakan coba akses kembali plugin Kategori.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}