# Dokumentasi Sistem Tema stelloCMS

## Gambaran Umum

Sistem tema stelloCMS memungkinkan penggunaan tema yang dapat dideteksi secara dinamis dari folder. Sistem ini mendukung tema terpisah untuk area administrasi dan area publik (frontend), dengan kemampuan untuk mengganti tema secara dinamis tanpa mengubah kode aplikasi.

## Arsitektur Tema

### Struktur Direktori Tema
```
/themes/
├── admin/
│   ├── adminlte/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── dashboard/
│   │   │   └── index.blade.php
│   │   ├── plugins/
│   │   │   └── index.blade.php
│   │   ├── themes/
│   │   │   └── index.blade.php
│   │   ├── auth/
│   │   │   └── login.blade.php
│   │   ├── css/
│   │   │   └── style.css
│   │   ├── js/
│   │   │   └── script.js
│   │   ├── images/
│   │   │   └── screenshot.png
│   │   └── theme.json
│   └── {other_admin_themes}/
└── frontend/
    └── kind_heart/
        ├── layouts/
        │   └── app.blade.php
        ├── home/
        │   └── index.blade.php
        ├── css/
        │   └── style.css
        ├── js/
        │   └── script.js
        ├── images/
        │   └── screenshot.png
        └── theme.json
```

### File Konfigurasi Tema (theme.json)
Setiap tema harus memiliki file `theme.json` yang berisi informasi metadata:
```json
{
    "name": "Nama Tema",
    "version": "1.0.0",
    "description": "Deskripsi tema",
    "author": "Nama Pembuat",
    "author_url": "https://website.com",
    "screenshot": "images/screenshot.png",
    "tags": ["tag1", "tag2"]
}
```

## Konfigurasi Tema

### Konfigurasi Environment
```env
# Tema Admin dan Frontend
ADMIN_THEME=adminlte
FRONTEND_THEME=kind_heart

# CMS Configuration
CMS_NAME=stelloCMS
CMS_DESCRIPTION="Limitless Online Content Management"
```

### Konfigurasi File (config/themes.php)
```php
<?php

return [
    'admin' => env('ADMIN_THEME', 'adminlte'),
    'frontend' => env('FRONTEND_THEME', 'kind_heart'),
];
```

## Helper Tema

### view_theme()
Helper ini digunakan untuk merender view dengan tema yang sesuai:
```php
// Untuk area admin
return view_theme('admin', 'dashboard.index');

// Untuk area frontend
return view_theme('frontend', 'home.index');

// Dengan data tambahan
return view_theme('admin', 'plugins.index', compact('plugins'));
```

### cms_name()
Mengembalikan nama CMS dari konfigurasi:
```php
echo cms_name(); // stelloCMS
```

### cms_description()
Mengembalikan deskripsi CMS dari konfigurasi:
```php
echo cms_description(); // Limitless Online Content Management
```

## Manajemen Tema

### Deteksi Tema Otomatis
Sistem secara otomatis mendeteksi tema dari folder:
```php
public function getAdminThemes()
{
    $adminThemesPath = $this->themesPath . '/admin';
    
    if (!File::exists($adminThemesPath)) {
        return [];
    }
    
    $themes = [];
    foreach (File::directories($adminThemesPath) as $themePath) {
        $themeName = basename($themePath);
        
        // Check if theme has metadata
        $themeJsonPath = $themePath . '/theme.json';
        $metadata = [];
        
        if (File::exists($themeJsonPath)) {
            $metadata = json_decode(File::get($themeJsonPath), true);
        }
        
        $themes[] = [
            'name' => $themeName,
            'path' => $themePath,
            'metadata' => $metadata,
            'active' => config('themes.admin') === $themeName
        ];
    }
    
    return $themes;
}
```

### Mengganti Tema
```php
// Controller untuk mengganti tema admin
public function switchAdminTheme(Request $request)
{
    $request->validate([
        'theme' => 'required|string|exists:themes,name,type,admin'
    ]);
    
    // Update konfigurasi tema
    $this->themeManager->setActiveAdminTheme($request->theme);
    
    return redirect()->back()->with('success', 'Tema berhasil diubah.');
}

// Service untuk mengganti tema
public function setActiveAdminTheme($themeName)
{
    // Update konfigurasi
    config(['themes.admin' => $themeName]);
    
    // Update file .env
    $this->updateEnvFile('ADMIN_THEME', $themeName);
    
    // Clear cache konfigurasi
    Artisan::call('config:clear');
}
```

## Pembuatan Tema Baru

### Langkah-langkah Membuat Tema Admin
1. Buat folder tema di `/themes/admin/`
2. Tambahkan file `theme.json` dengan informasi tema
3. Buat struktur view yang diperlukan
4. Tambahkan file CSS dan JS jika diperlukan
5. Tambahkan screenshot tema
6. Tema akan terdeteksi secara otomatis

### Contoh theme.json untuk Tema Admin
```json
{
    "name": "AdminLTE",
    "version": "3.2.0",
    "description": "AdminLTE Free Bootstrap Admin Template",
    "author": "AdminLTE.io",
    "author_url": "https://adminlte.io",
    "screenshot": "images/screenshot.png",
    "tags": ["admin", "bootstrap", "responsive"]
}
```

## Konfigurasi Tema

### Mengganti Tema Aktif
Tema aktif dapat diubah melalui:
1. File konfigurasi `.env`
2. Panel administrasi
3. File konfigurasi `config/themes.php`

### Variabel Lingkungan Tema
```
ADMIN_THEME=adminlte
FRONTEND_THEME=kind_heart
```

## Best Practices

### Penamaan Tema
- Gunakan nama yang deskriptif
- Hindari karakter spesial
- Gunakan huruf kecil dengan pemisah underscore atau dash

### Struktur View
- Ikuti struktur view yang konsisten
- Gunakan helper `view_theme()` untuk semua view tema
- Pastikan semua view yang diperlukan tersedia

### Asset Tema
- Tempatkan asset CSS dan JS di folder yang sesuai
- Gunakan path relatif untuk asset
- Optimalkan ukuran asset untuk performa yang lebih baik

## Troubleshooting

### Tema Tidak Terdeteksi
- Pastikan struktur folder sudah benar
- Periksa file `theme.json` ada dan formatnya benar
- Bersihkan cache konfigurasi dengan `php artisan config:clear`

### View Tidak Ditemukan
- Pastikan nama view sesuai dengan struktur tema
- Gunakan helper `view_theme()` dengan parameter yang benar
- Periksa path view dalam tema

### CSS/JS Tidak Dimuat
- Pastikan path asset sudah benar
- Periksa permission file
- Bersihkan cache browser

## Pengembangan Lebih Lanjut

### Tema Dinamis
```php
// Mengambil tema berdasarkan preferensi pengguna
class DynamicThemeManager extends ThemeManager
{
    public function getUserPreferredTheme($userId, $type = 'admin')
    {
        $user = User::find($userId);
        $preference = $user->preferences()->where('key', $type . '_theme')->first();
        
        if ($preference) {
            return $preference->value;
        }
        
        // Fallback ke tema default
        return config('themes.' . $type);
    }
}
```

### Tema dengan Variabel
```json
{
    "name": "Custom Theme",
    "version": "1.0.0",
    "description": "Theme with customizable variables",
    "author": "Developer",
    "variables": {
        "primary_color": "#007bff",
        "secondary_color": "#6c757d",
        "font_family": "'Open Sans', sans-serif"
    }
}
```

### Theme Compiler
```php
class ThemeCompiler
{
    public function compile($themePath)
    {
        // Compile SCSS to CSS
        $scss = new Compiler();
        $scssContent = file_get_contents($themePath . '/scss/style.scss');
        $cssContent = $scss->compileString($scssContent);
        
        // Save compiled CSS
        file_put_contents($themePath . '/css/style.css', $cssContent);
        
        return true;
    }
}
```

### Theme Preview
```php
// Controller untuk preview tema
class ThemePreviewController extends Controller
{
    public function preview($type, $themeName)
    {
        // Simpan tema sementara untuk preview
        session()->put('preview_theme_' . $type, $themeName);
        
        // Redirect ke halaman yang sesuai
        if ($type === 'admin') {
            return redirect()->route('panel.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    
    public function reset()
    {
        // Hapus tema preview
        session()->forget(['preview_theme_admin', 'preview_theme_frontend']);
        
        return redirect()->back();
    }
}
```