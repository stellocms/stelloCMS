# Dokumentasi Sistem Tema stelloCMS

## Gambaran Umum

Sistem tema stelloCMS memungkinkan penggunaan tema yang dapat dideteksi secara dinamis dari folder. Sistem ini mendukung tema terpisah untuk area administrasi dan area publik (frontend).

## Struktur Tema

### Struktur Dasar Tema Admin
```
/themes/admin/{nama_tema}/
├── layouts/
│   └── app.blade.php
├── dashboard/
│   └── index.blade.php
├── plugins/
│   ├── index.blade.php
│   └── ...
├── themes/
│   └── index.blade.php
├── auth/
│   └── login.blade.php
├── css/
│   └── style.css
├── js/
│   └── script.js
├── images/
│   └── screenshot.png
└── theme.json
```

### Struktur Dasar Tema Frontend
```
/themes/frontend/{nama_tema}/
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

## File Konfigurasi Tema

### theme.json
File `theme.json` berisi informasi metadata tentang tema:
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

## Helper Tema

### view_theme()
Helper ini digunakan untuk merender view dengan tema yang sesuai:
```php
// Untuk area admin
return view_theme('admin', 'dashboard.index');

// Untuk area frontend
return view_theme('frontend', 'home.index');
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
    "name": "Dark Admin",
    "version": "1.0.0",
    "description": "Tema admin dengan tampilan gelap",
    "author": "stelloCMS Team",
    "author_url": "https://stellocms.com",
    "screenshot": "images/screenshot.png",
    "tags": ["admin", "dark", "responsive"]
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
FRONTEND_THEME=default
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
