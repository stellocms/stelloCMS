# Dokumentasi Sistem Pengguna dan Hak Akses stelloCMS

## Gambaran Umum

Sistem pengguna dan hak akses stelloCMS menggunakan pendekatan Role-Based Access Control (RBAC) yang fleksibel. Sistem ini mendukung berbagai level pengguna dengan hak akses yang dapat dikustomisasi berdasarkan role dan menu.

## Struktur Pengguna

### Tabel Users
```
users
├── id (bigint, primary key, auto increment)
├── name (varchar)
├── email (varchar, unique)
├── password (varchar)
├── role_id (bigint, foreign key to roles)
├── email_verified_at (timestamp, nullable)
├── remember_token (varchar, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)
```

### Tabel Roles
```
roles
├── id (bigint, primary key, auto increment)
├── name (varchar, unique)
├── description (text)
├── created_at (timestamp)
└── updated_at (timestamp)
```

### Tabel Menus
```
menus
├── id (bigint, primary key, auto increment)
├── name (varchar)
├── title (varchar)
├── route (varchar)
├── icon (varchar)
├── parent_id (bigint, nullable, foreign key to menus)
├── order (integer)
├── is_active (boolean)
├── plugin_name (varchar, nullable)
├── roles (json)
├── created_at (timestamp)
└── updated_at (timestamp)
```

## Role Pengguna

### Role Standar
1. **admin** - Administrator sistem dengan akses penuh
2. **kepala-desa** - Kepala desa dengan akses administrasi
3. **sekdes** - Sekretaris desa
4. **kaur** - Kepala Urusan
5. **kadus** - Kepala Dusun
6. **rw** - Ketua RW
7. **rt** - Ketua RT
8. **warga** - Warga masyarakat (akses publik)

### Menambahkan Role Baru
Role baru dapat ditambahkan melalui:
1. Seeder database
2. Panel administrasi
3. Query database langsung

## Sistem Menu

### Struktur Menu
Menu dalam stelloCMS memiliki struktur hierarkis yang mendukung submenu. Setiap menu dapat dikonfigurasi untuk:
- Ditampilkan hanya untuk role tertentu
- Diaktifkan atau dinonaktifkan
- Diurutkan sesuai kebutuhan

### Konfigurasi Menu per Role
Setiap menu dapat dikonfigurasi untuk ditampilkan hanya untuk role tertentu melalui field `roles` yang berupa array JSON:
```json
{
    "roles": ["admin", "kepala-desa", "sekdes"]
}
```

## Middleware Hak Akses

### RoleMiddleware
Middleware `RoleMiddleware` digunakan untuk membatasi akses berdasarkan role pengguna:
```php
Route::get('/admin/panel', function () {
    // Hanya dapat diakses oleh admin, kepala-desa, dan sekdes
})->middleware(['role:admin,kepala-desa,sekdes']);
```

### Penggunaan Middleware
```php
// Hanya admin yang dapat mengakses
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/settings', [SettingsController::class, 'index']);
});

// Multiple role yang dapat mengakses
Route::middleware(['role:admin,kepala-desa,sekdes'])->group(function () {
    Route::get('/admin/reports', [ReportController::class, 'index']);
});
```

## Manajemen Pengguna

### Membuat Pengguna Baru
Pengguna baru dapat dibuat melalui:
1. Panel administrasi oleh admin
2. Form registrasi publik (jika diaktifkan)
3. Seeder database
4. Command Artisan

### Mengatur Role Pengguna
Role pengguna dapat diatur melalui:
1. Panel administrasi
2. Database query langsung
3. API (jika tersedia)

## Manajemen Role

### Menambahkan Role Baru
Untuk menambahkan role baru:
1. Tambahkan role ke tabel `roles` melalui seeder atau panel administrasi
2. Konfigurasikan menu yang dapat diakses oleh role tersebut
3. Assign pengguna ke role baru

### Contoh Seeder Role
```php
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator Sistem'],
            ['name' => 'kepala-desa', 'description' => 'Kepala Desa'],
            ['name' => 'sekdes', 'description' => 'Sekretaris Desa'],
            ['name' => 'kaur', 'description' => 'Kepala Urusan'],
            ['name' => 'kadus', 'description' => 'Kepala Dusun'],
            ['name' => 'rw', 'description' => 'Ketua RW'],
            ['name' => 'rt', 'description' => 'Ketua RT'],
            ['name' => 'warga', 'description' => 'Warga Masyarakat'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
```

## Manajemen Menu

### Struktur Menu Hierarkis
Menu dalam stelloCMS mendukung struktur hierarkis dengan parent-child relationship:
```
Dashboard
├── Statistik
├── Laporan
└── Pengaturan
```

### Konfigurasi Menu
Setiap menu dapat dikonfigurasi dengan:
- Nama dan judul
- Route yang dituju
- Icon untuk tampilan
- Parent menu (untuk submenu)
- Urutan tampilan
- Status aktif/nonaktif
- Plugin yang terkait
- Role yang dapat mengakses

### Contoh Konfigurasi Menu
```php
$menu = [
    'name' => 'berita',
    'title' => 'Manajemen Berita',
    'route' => 'berita.index',
    'icon' => 'fas fa-newspaper',
    'parent_id' => null,
    'order' => 1,
    'is_active' => true,
    'plugin_name' => 'Berita',
    'roles' => ['admin', 'kepala-desa', 'sekdes']
];
```

## Hak Akses Plugin

### Konfigurasi Hak Akses Plugin
Setiap plugin dapat memiliki hak akses khusus yang dikonfigurasi melalui menu:
1. Plugin membuat menu otomatis saat diinstal
2. Menu dapat dikonfigurasi untuk role tertentu
3. Hak akses diterapkan secara otomatis berdasarkan konfigurasi

### Contoh Konfigurasi Menu Plugin
```php
// Dalam PluginManager saat membuat menu plugin
$menu = new \App\Models\Menu([
    'name' => 'berita',
    'title' => 'Manajemen Berita',
    'route' => 'berita.index',
    'icon' => 'fas fa-newspaper',
    'plugin_name' => $pluginName,
    'is_active' => true,
    'roles' => ['admin', 'kepala-desa', 'sekdes'] // Hanya role tertentu yang dapat mengakses
]);
```

## Best Practices

### Keamanan
1. Selalu gunakan middleware untuk membatasi akses
2. Validasi role pada setiap request
3. Gunakan HTTPS untuk proteksi data
4. Hash password dengan bcrypt

### Manajemen Role
1. Gunakan role yang deskriptif dan konsisten
2. Batasi jumlah role yang tidak perlu
3. Dokumentasikan setiap role dan hak aksesnya
4. Gunakan role inheritance jika diperlukan

### Manajemen Menu
1. Gunakan struktur menu yang konsisten
2. Konfigurasikan hak akses menu dengan tepat
3. Gunakan icon yang mudah dikenali
4. Urutkan menu berdasarkan prioritas penggunaan

### Pengguna
1. Validasi email dan data pengguna
2. Gunakan email verification jika diperlukan
3. Implementasi password strength policy
4. Gunakan remember token untuk session persistence

## Troubleshooting

### Pengguna Tidak Dapat Mengakses Menu
- Periksa apakah role pengguna sesuai dengan konfigurasi menu
- Pastikan menu dalam status aktif
- Cek apakah route menu sudah benar

### Role Tidak Ditemukan
- Pastikan role ada dalam tabel `roles`
- Periksa penulisan nama role (case sensitive)
- Bersihkan cache konfigurasi jika diperlukan

### Middleware Tidak Berfungsi
- Pastikan middleware sudah diregistrasi dengan benar
- Periksa parameter role dalam middleware
- Cek apakah pengguna sudah login

### Menu Tidak Muncul
- Periksa status aktif menu
- Cek konfigurasi role untuk menu tersebut
- Bersihkan cache view dan route