# Dokumentasi Instalasi dan Konfigurasi stelloCMS

## Persyaratan Sistem

### Server Requirements
- **PHP**: Versi 8.2 atau lebih tinggi
- **Database**: MySQL 5.7+ atau MariaDB 10.2+
- **Web Server**: Apache 2.4+ atau Nginx
- **Memory**: Minimal 2GB RAM (direkomendasikan 4GB+)
- **Storage**: Minimal 500MB ruang kosong (direkomendasikan 1GB+)

### PHP Extensions yang Diperlukan
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension
- Intl PHP Extension (untuk internasionalisasi)
- GD Library atau Imagick (untuk manipulasi gambar)

### Dependensi Tambahan
- **Composer**: Dependency Manager untuk PHP
- **Node.js & NPM**: Untuk asset compilation (opsional)
- **Git**: Untuk version control (direkomendasikan)

## Instalasi

### Metode 1: Menggunakan Git Clone (Direkomendasikan)

#### Langkah 1: Clone Repository
```bash
git clone https://github.com/username/stelloCMS.git
cd stelloCMS
```

#### Langkah 2: Install Dependencies
```bash
composer install
npm install && npm run dev
```

#### Langkah 3: Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

#### Langkah 4: Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simpede
DB_USERNAME=root
DB_PASSWORD=
```

#### Langkah 5: Migrasi Database
```bash
php artisan migrate --seed
```

#### Langkah 6: Konfigurasi Web Server
Pastikan document root mengarah ke folder `public`.

### Metode 2: Download Manual

#### Langkah 1: Download dan Extract
1. Download file ZIP dari repository
2. Extract ke direktori web server

#### Langkah 2: Install Dependencies
```bash
composer install --no-dev
```

#### Langkah 3: Konfigurasi Environment
Ikuti langkah 3-6 dari Metode 1.

## Konfigurasi Awal

### Konfigurasi Database

#### Membuat Database
```sql
CREATE DATABASE simpede CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Konfigurasi Koneksi Database
Di file `.env`:
```env
# Koneksi Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simpede
DB_USERNAME=username
DB_PASSWORD=password

# Pooling Connection (opsional)
DB_POOLING_ENABLED=true
DB_POOL_MIN=5
DB_POOL_MAX=15
```

### Konfigurasi Aplikasi

#### Pengaturan Dasar
```env
# Nama dan Deskripsi Aplikasi
APP_NAME=stelloCMS
APP_ENV=local
APP_KEY=base64:generated_key
APP_DEBUG=true
APP_URL=http://localhost

# Timezone dan Locale
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
APP_FALLBACK_LOCALE=en
```

#### Konfigurasi Cache dan Session
```env
# Driver Cache
CACHE_DRIVER=database
CACHE_PREFIX=stello_

# Driver Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false

# Driver Queue
QUEUE_CONNECTION=database
```

#### Konfigurasi Email
```env
# SMTP Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Konfigurasi CMS

#### Pengaturan Tema
```env
# Tema Admin dan Frontend
ADMIN_THEME=adminlte
FRONTEND_THEME=kind_heart

# Konfigurasi CMS
CMS_NAME=stelloCMS
CMS_DESCRIPTION="Limitless Online Content Management"
CMS_TEAM="stelloCMS Development Team"
```

#### Pengaturan Keamanan
```env
# API Authentication
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
SESSION_DOMAIN=localhost

# Password Reset
PASSWORD_RESET_TOKEN_LIFETIME=60
```

## Konfigurasi Web Server

### Apache

#### Virtual Host Configuration
```apache
<VirtualHost *:80>
    ServerName simpede.local
    DocumentRoot "D:/htdocs/simpede/public"
    
    <Directory "D:/htdocs/simpede/public">
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog "D:/logs/simpede_error.log"
    CustomLog "D:/logs/simpede_access.log" combined
</VirtualHost>
```

#### .htaccess (sudah disediakan)
File `.htaccess` sudah tersedia di folder `public`:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Nginx

#### Server Block Configuration
```nginx
server {
    listen 80;
    server_name simpede.local;
    root D:/htdocs/simpede/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass php_upstream;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Konfigurasi Database Lanjutan

### Optimasi MySQL/MariaDB

#### my.cnf Configuration
```ini
[mysqld]
# Character Set
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

# Buffer dan Cache
innodb_buffer_pool_size=1G
query_cache_size=128M
tmp_table_size=256M
max_heap_table_size=256M

# Connection
max_connections=200
thread_cache_size=20

# Logging
slow_query_log=1
long_query_time=2
```

### Backup dan Restore

#### Backup Database
```bash
# Backup struktur dan data
mysqldump -u username -p database_name > backup.sql

# Backup hanya struktur
mysqldump -u username -p --no-data database_name > structure.sql

# Backup hanya data
mysqldump -u username -p --no-create-info database_name > data.sql
```

#### Restore Database
```bash
mysql -u username -p database_name < backup.sql
```

## Konfigurasi SSL (HTTPS)

### Menggunakan Let's Encrypt (Linux)

#### Instalasi Certbot
```bash
sudo apt-get install certbot python3-certbot-apache
```

#### Mendapatkan Sertifikat
```bash
sudo certbot --apache -d simpede.domain.com
```

### Konfigurasi Manual (Self-Signed)

#### Membuat Sertifikat Self-Signed
```bash
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/apache-selfsigned.key \
    -out /etc/ssl/certs/apache-selfsigned.crt
```

#### Konfigurasi Apache dengan SSL
```apache
<VirtualHost *:443>
    ServerName simpede.local
    DocumentRoot "D:/htdocs/simpede/public"
    
    SSLEngine on
    SSLCertificateFile "/etc/ssl/certs/apache-selfsigned.crt"
    SSLCertificateKeyFile "/etc/ssl/private/apache-selfsigned.key"
    
    <Directory "D:/htdocs/simpede/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Konfigurasi Cache

### Cache Driver Options

#### Database Cache
```env
CACHE_DRIVER=database
CACHE_TABLE=cache
```

#### Redis Cache
```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

#### Memcached Cache
```env
CACHE_DRIVER=memcached
MEMCACHED_HOST=127.0.0.1
MEMCACHED_PORT=11211
```

### Clear Cache Commands
```bash
# Clear semua cache
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear compiled views
php artisan view:cache
```

## Konfigurasi Environment Production

### Pengaturan Keamanan
```env
# Environment Production
APP_ENV=production
APP_DEBUG=false

# Logging
LOG_LEVEL=error
LOG_STACKTRACE_QUALITY=verbose

# Session
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

### Optimasi Performa
```env
# Opcache
OPCACHE_ENABLE=1
OPCACHE_MEMORY_CONSUMPTION=256
OPCACHE_INTERNED_STRINGS_BUFFER=16
OPCACHE_MAX_ACCELERATED_FILES=20000

# Realpath Cache
REALPATH_CACHE_SIZE=4096K
REALPATH_CACHE_TTL=600
```

## Troubleshooting

### Error Umum

#### "Class not found"
```bash
# Clear dan rebuild autoloader
composer dump-autoload
php artisan optimize:clear
```

#### "Permission denied"
```bash
# Set permission yang benar
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### "Database connection failed"
```bash
# Test koneksi database
php artisan tinker
>>> DB::connection()->getPdo();
```

#### "No application encryption key"
```bash
# Generate application key
php artisan key:generate
```

### Maintenance Commands

#### Health Check
```bash
# Check status aplikasi
php artisan about

# Check requirement sistem
php artisan doctor

# Check migrasi
php artisan migrate:status
```

#### Optimization
```bash
# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear semua cache
php artisan optimize:clear
```

## Upgrade

### Prosedur Upgrade

#### Backup Sebelum Upgrade
```bash
# Backup database
mysqldump -u username -p database_name > backup_before_upgrade.sql

# Backup file konfigurasi
cp .env .env.backup
cp config/*.php config_backup/
```

#### Upgrade dari Git
```bash
# Pull versi terbaru
git pull origin main

# Install dependencies baru
composer install --no-dev

# Jalankan migrasi
php artisan migrate --force

# Clear cache
php artisan optimize:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
```

#### Upgrade Manual
1. Backup seluruh sistem
2. Download versi terbaru
3. Extract dan replace file
4. Update konfigurasi jika ada perubahan
5. Jalankan migrasi database
6. Clear dan rebuild cache

## Monitoring dan Logging

### Log Files Location
```
/storage/logs/
├── laravel.log
├── production.log
└── queue.log
```

### Monitoring Commands
```bash
# Monitor log secara real-time
tail -f storage/logs/laravel.log

# Check queue status
php artisan queue:monitor

# Check schedule
php artisan schedule:list
```

### Custom Logging
```php
// Di controller atau service
\Log::info('User action logged', [
    'user_id' => auth()->id(),
    'action' => 'plugin_installed',
    'plugin_name' => $pluginName
]);
```

## Backup Strategy

### Automated Backup Script
```bash
#!/bin/bash
# backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/simpede"

# Backup database
mysqldump -u username -p database_name > "$BACKUP_DIR/db_$DATE.sql"

# Backup files penting
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" \
    .env \
    storage/app/public \
    storage/logs

# Hapus backup lama (lebih dari 30 hari)
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

### Schedule Backup
Tambahkan ke crontab:
```bash
# Backup harian jam 2 pagi
0 2 * * * /path/to/backup.sh

# Backup mingguan hari Minggu jam 3 pagi
0 3 * * 0 /path/to/backup.sh
```