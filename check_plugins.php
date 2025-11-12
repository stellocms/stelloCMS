<?php
// Bootstrap Laravel untuk mengecek status plugin

require_once __DIR__.'/vendor/autoload.php';

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->bootstrapWith([
    'Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables',
    'Illuminate\Foundation\Bootstrap\LoadConfiguration',
    'Illuminate\Foundation\Bootstrap\HandleExceptions',
    'Illuminate\Foundation\Bootstrap\RegisterFacades',
    'Illuminate\Foundation\Bootstrap\SetRequestForConsole',
    'Illuminate\Foundation\Bootstrap\RegisterProviders',
    'Illuminate\Foundation\Bootstrap\BootProviders',
]);

// Cek apakah plugin terinstal
use App\Models\Plugin;

echo "Status Plugin Berita: ";
$berita = Plugin::where('name', 'Berita')->first();
if ($berita) {
    echo "Terinstal (active: " . ($berita->active ? 'true' : 'false') . ")\n";
} else {
    echo "Tidak ditemukan\n";
}

echo "Status Plugin Kategori: ";
$kategori = Plugin::where('name', 'Kategori')->first();
if ($kategori) {
    echo "Terinstal (active: " . ($kategori->active ? 'true' : 'false') . ")\n";
} else {
    echo "Tidak ditemukan\n";
}

// Cek entri menu
use App\Models\Menu;

echo "\nMenu untuk Berita: ";
$berita_menus = Menu::where('plugin_name', 'Berita')->get();
foreach ($berita_menus as $menu) {
    echo "\n  - Route: " . $menu->route . ", Roles: " . $menu->roles . ", Active: " . ($menu->is_active ? 'true' : 'false');
}

echo "\n\nMenu untuk Kategori: ";
$kategori_menus = Menu::where('plugin_name', 'Kategori')->get();
foreach ($kategori_menus as $menu) {
    echo "\n  - Route: " . $menu->route . ", Roles: " . $menu->roles . ", Active: " . ($menu->is_active ? 'true' : 'false');
}

echo "\n";