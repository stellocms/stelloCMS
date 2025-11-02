# Dokumentasi Konfigurasi Database stelloCMS

## Gambaran Umum

stelloCMS menggunakan database relasional MySQL/MariaDB untuk menyimpan semua data sistem. Dokumen ini menjelaskan struktur database, konfigurasi, dan best practices untuk pengelolaan database stelloCMS.

## Konfigurasi Database

### Konfigurasi Environment (.env)
```env
# Koneksi Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simpede
DB_USERNAME=root
DB_PASSWORD=

# Pooling Connection (opsional)
DB_POOLING_ENABLED=true
DB_POOL_MIN=5
DB_POOL_MAX=15

# Konfigurasi Tambahan
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_PREFIX=
DB_STRICT=true
```

### Konfigurasi Database (config/database.php)
```php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

## Struktur Database

### Tabel Users
```sql
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `role_id` BIGINT UNSIGNED NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE SET NULL
);
```

### Tabel Roles
```sql
CREATE TABLE `roles` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) UNIQUE NOT NULL,
    `description` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

### Tabel Menus
```sql
CREATE TABLE `menus` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `route` VARCHAR(255) NOT NULL,
    `icon` VARCHAR(255) NULL,
    `parent_id` BIGINT UNSIGNED NULL,
    `order` INT DEFAULT 0,
    `is_active` BOOLEAN DEFAULT TRUE,
    `plugin_name` VARCHAR(255) NULL,
    `roles` JSON NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    
    FOREIGN KEY (`parent_id`) REFERENCES `menus`(`id`) ON DELETE CASCADE
);
```

### Tabel Plugins
```sql
CREATE TABLE `plugins` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) UNIQUE NOT NULL,
    `installed` BOOLEAN DEFAULT FALSE,
    `active` BOOLEAN DEFAULT FALSE,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);
```

### Tabel Migrations
```sql
CREATE TABLE `migrations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL
);
```

### Tabel Sessions
```sql
CREATE TABLE `sessions` (
    `id` VARCHAR(255) PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
);
```

### Tabel Cache
```sql
CREATE TABLE `cache` (
    `key` VARCHAR(255) PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT NOT NULL
);
```

### Tabel Jobs
```sql
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    
    INDEX `jobs_queue_index` (`queue`)
);
```

### Tabel Failed Jobs
```sql
CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(255) UNIQUE NOT NULL,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabel Password Reset Tokens
```sql
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    
    INDEX `password_reset_tokens_email_index` (`email`)
);
```

### Tabel Personal Access Tokens
```sql
CREATE TABLE `personal_access_tokens` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `tokenable_type` VARCHAR(255) NOT NULL,
    `tokenable_id` BIGINT UNSIGNED NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `token` VARCHAR(64) UNIQUE NOT NULL,
    `abilities` TEXT NULL,
    `last_used_at` TIMESTAMP NULL,
    `expires_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    
    INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
);
```

## Tabel Plugin Spesifik

### Tabel Berita (Plugin Berita)
```sql
CREATE TABLE `berita` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `isi` TEXT NOT NULL,
    `gambar` VARCHAR(255) NULL,
    `tanggal_publikasi` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `aktif` BOOLEAN DEFAULT TRUE,
    `user_id` BIGINT UNSIGNED NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);
```

## Migrasi Database

### Membuat Migrasi
```bash
php artisan make:migration create_{table_name}_table
```

### Menjalankan Migrasi
```bash
# Jalankan semua migrasi yang belum dijalankan
php artisan migrate

# Jalankan migrasi dengan force (untuk production)
php artisan migrate --force

# Jalankan migrasi untuk database tertentu
php artisan migrate --database=mysql
```

### Membatalkan Migrasi
```bash
# Batalkan migrasi terakhir
php artisan migrate:rollback

# Batalkan semua migrasi
php artisan migrate:reset

# Batalkan dan jalankan ulang semua migrasi
php artisan migrate:refresh

# Batalkan dan jalankan ulang semua migrasi dengan seed
php artisan migrate:fresh --seed
```

### Melihat Status Migrasi
```bash
# Lihat status semua migrasi
php artisan migrate:status
```

### Contoh File Migrasi
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->timestamp('tanggal_publikasi')->useCurrent();
            $table->boolean('aktif')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
```

## Seeder Database

### Membuat Seeder
```bash
php artisan make:seeder {TableName}Seeder
```

### Menjalankan Seeder
```bash
# Jalankan semua seeder
php artisan db:seed

# Jalankan seeder tertentu
php artisan db:seed --class={TableName}Seeder

# Jalankan seeder dengan force
php artisan db:seed --force
```

### Contoh File Seeder
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // admin role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kepala Desa',
                'email' => 'kepala-desa@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // kepala-desa role
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sekretaris Desa',
                'email' => 'sekdes@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // sekdes role
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
```

## Model Database

### Model User
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
```

### Model Role
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get all of the users for the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
```

### Model Menu
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'route',
        'icon',
        'parent_id',
        'order',
        'is_active',
        'plugin_name',
        'roles',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'roles' => 'array',
    ];

    /**
     * Get parent menu
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get child menus
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    /**
     * Scope for active menus
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for main menus (without parent)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
}
```

### Model Plugin
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'installed',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'installed' => 'boolean',
        'active' => 'boolean',
    ];
}
```

## Optimasi Database

### Indexing
```sql
-- Index untuk kolom yang sering digunakan dalam WHERE clause
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role_id ON users(role_id);
CREATE INDEX idx_menus_parent_id ON menus(parent_id);
CREATE INDEX idx_menus_plugin_name ON menus(plugin_name);
CREATE INDEX idx_plugins_name ON plugins(name);
```

### Query Optimization
```php
// Gunakan eager loading untuk mencegah N+1 queries
$menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();

// Gunakan chunking untuk query besar
User::chunk(1000, function ($users) {
    foreach ($users as $user) {
        // Proses user
    }
});

// Gunakan select spesifik untuk menghindari loading data yang tidak perlu
$users = User::select('id', 'name', 'email')->get();
```

### Connection Pooling
```env
# Konfigurasi pooling connection
DB_POOLING_ENABLED=true
DB_POOL_MIN=5
DB_POOL_MAX=15
```

### Caching Query
```php
// Gunakan caching untuk query yang jarang berubah
$menus = Cache::remember('active_menus', 3600, function () {
    return Menu::where('is_active', true)
               ->with('children')
               ->orderBy('order')
               ->get();
});
```

## Backup dan Recovery

### Backup Database
```bash
# Backup struktur dan data
mysqldump -u username -p database_name > backup.sql

# Backup hanya struktur
mysqldump -u username -p --no-data database_name > structure.sql

# Backup hanya data
mysqldump -u username -p --no-create-info database_name > data.sql

# Backup dengan kompresi
mysqldump -u username -p database_name | gzip > backup.sql.gz
```

### Restore Database
```bash
# Restore dari backup
mysql -u username -p database_name < backup.sql

# Restore dari backup terkompresi
gunzip < backup.sql.gz | mysql -u username -p database_name
```

### Scheduled Backup
```bash
# Tambahkan ke crontab untuk backup harian
0 2 * * * mysqldump -u username -p database_name | gzip > /backups/database_$(date +\%Y\%m\%d).sql.gz

# Hapus backup lama (lebih dari 30 hari)
0 3 * * * find /backups -name "database_*.sql.gz" -mtime +30 -delete
```

## Monitoring dan Maintenance

### Health Check
```sql
-- Cek ukuran tabel
SELECT 
    table_name AS `Table`,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) `Size in MB`
FROM information_schema.TABLES
WHERE table_schema = "database_name"
ORDER BY (data_length + index_length) DESC;

-- Cek connection pool
SHOW STATUS LIKE 'Threads_connected';

-- Cek slow queries
SHOW VARIABLES LIKE 'slow_query_log';
```

### Maintenance Commands
```bash
# Optimize tabel
mysqlcheck -u username -p --optimize database_name

# Repair tabel
mysqlcheck -u username -p --repair database_name

# Analyze tabel
mysqlcheck -u username -p --analyze database_name
```

### Database Cleanup
```sql
-- Hapus session yang kadaluarsa
DELETE FROM sessions WHERE last_activity < UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY);

-- Hapus cache yang kadaluarsa
DELETE FROM cache WHERE expiration < UNIX_TIMESTAMP(NOW());

-- Hapus job yang gagal lama
DELETE FROM failed_jobs WHERE failed_at < NOW() - INTERVAL 30 DAY;
```

## Perubahan Penting

### Perubahan Database (Versi 1.1.0)
- Mengganti tabel `berita_desa` yang spesifik dengan tabel `berita` yang umum
- Tabel `berita` sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus tabel `berita_desa` yang tidak digunakan untuk mengurangi kompleksitas sistem

### Perubahan Tema (Versi 1.1.0)
- Mengganti tema admin default dari CoreUI ke AdminLTE untuk stabilitas yang lebih baik
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan

## Troubleshooting

### Connection Issues
```bash
# Cek status MySQL
systemctl status mysql

# Restart MySQL
systemctl restart mysql

# Cek log error MySQL
tail -f /var/log/mysql/error.log
```

### Permission Issues
```sql
-- Berikan permission yang diperlukan
GRANT ALL PRIVILEGES ON database_name.* TO 'username'@'localhost';
FLUSH PRIVILEGES;
```

### Encoding Issues
```sql
-- Pastikan charset dan collation benar
ALTER DATABASE database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Performance Issues
```sql
-- Cek slow queries
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;

-- Cek query yang sedang berjalan
SHOW PROCESSLIST;
```

### Migration Issues
```bash
# Reset migrasi
php artisan migrate:reset

# Jalankan ulang migrasi
php artisan migrate:fresh

# Cek status migrasi
php artisan migrate:status
```

## Best Practices

### Naming Conventions
- Gunakan nama tabel dalam bentuk jamak (plural)
- Gunakan snake_case untuk nama kolom
- Gunakan foreign key dengan format `{related_table}_id`
- Gunakan timestamp `created_at` dan `updated_at` untuk semua tabel

### Relationship
- Gunakan foreign key constraint untuk integritas data
- Gunakan cascade delete dengan hati-hati
- Gunakan eager loading untuk mencegah N+1 queries
- Gunakan soft deletes jika diperlukan

### Indexing
- Buat index untuk kolom yang sering digunakan dalam WHERE clause
- Buat composite index untuk multiple column WHERE clauses
- Hindari index yang tidak digunakan
- Gunakan fulltext index untuk pencarian teks

### Security
- Gunakan prepared statements untuk mencegah SQL injection
- Hash password dengan bcrypt
- Gunakan HTTPS untuk koneksi database
- Batasi permission user database sesuai kebutuhan

### Performance
- Gunakan pagination untuk hasil yang besar
- Gunakan caching untuk data yang jarang berubah
- Gunakan connection pooling untuk aplikasi dengan traffic tinggi
- Optimize query dengan EXPLAIN