# Panduan Instalasi Plugin Berita

## Prasyarat Sistem

- PHP >= 8.2
- Laravel Framework (versi digunakan dalam stelloCMS)
- MySQL >= 5.7 atau MariaDB >= 10.2
- Ekstensi PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath

## Langkah-langkah Instalasi

1. Tempatkan plugin Berita di direktori `app/Plugins/Berita/`
2. Pastikan struktur direktori lengkap dan benar
3. Jalankan migrasi untuk membuat tabel berita:
   ```bash
   php artisan migrate
   ```
4. Aktifkan plugin melalui halaman manajemen plugin di admin panel
5. Plugin siap digunakan

## Konfigurasi Setelah Instalasi

1. Verifikasi bahwa route `/berita` dapat diakses secara publik
2. Verifikasi bahwa route `/panel/berita` dapat diakses oleh pengguna terotentikasi
3. Pastikan menu plugin muncul di sidebar admin
4. Jika menggunakan data awal, jalankan seeder:
   ```bash
   php artisan db:seed --class="App\\Plugins\\Berita\\Database\\Seeders\\BeritaTableSeeder"
   ```

## Integrasi dengan Tema

- Plugin ini kompatibel dengan tema adminLTE untuk tampilan admin
- Plugin ini kompatibel dengan tema frontend apapun yang digunakan dalam stelloCMS
- View untuk frontend menggunakan layout tema: `theme.frontend.{theme}::layouts.app`
- View untuk admin menggunakan layout tema: `theme.admin.{theme}::layouts.app`