# Dokumentasi stelloCMS

Selamat datang di dokumentasi stelloCMS. Dokumen ini menyediakan panduan lengkap untuk instalasi, konfigurasi, penggunaan, dan pengembangan stelloCMS.

## Daftar Isi

### Panduan Pengguna
1. [Instalasi dan Konfigurasi](INSTALLATION.md) - Panduan lengkap untuk menginstal dan mengkonfigurasi stelloCMS
2. [Sistem Pengguna dan Hak Akses](USER_MANAGEMENT.md) - Dokumentasi tentang manajemen pengguna, role, dan hak akses
3. [Sistem Tema](THEMING.md) - Panduan untuk menggunakan dan membuat tema
4. [Sistem Plugin](PLUGIN_SYSTEM.md) - Dokumentasi tentang manajemen dan pengembangan plugin
5. [Sistem Menu](MENUS.md) - Dokumentasi tentang manajemen menu dinamis
6. [Konfigurasi Database](DATABASE.md) - Dokumentasi struktur dan konfigurasi database
7. [Konfigurasi Sistem](CONFIGURATION.md) - Dokumentasi konfigurasi sistem secara menyeluruh

### Panduan Pengembang
1. [Arsitektur Sistem](ARCHITECTURE.md) - Gambaran arsitektur stelloCMS
2. [API Documentation](API.md) - Dokumentasi API untuk integrasi
3. [Development Guidelines](DEVELOPMENT.md) - Panduan pengembangan dan best practices
4. [Testing](TESTING.md) - Panduan testing dan quality assurance

### Referensi Teknis
1. [Database Schema](DATABASE_SCHEMA.md) - Skema database lengkap
2. [Configuration Reference](CONFIGURATION_REFERENCE.md) - Referensi konfigurasi lengkap
3. [Environment Variables](ENVIRONMENT_VARIABLES.md) - Daftar dan penjelasan variabel lingkungan
4. [CLI Commands](CLI_COMMANDS.md) - Daftar dan penjelasan command line interface
5. [Plugin Naming Conventions](PLUGIN_NAMING_CONVENTIONS.md) - Aturan penamaan plugin untuk pengembang

## Perubahan Penting

### Perubahan Tema (Versi 1.1.0)
- Mengganti tema admin default dari CoreUI ke AdminLTE untuk stabilitas yang lebih baik
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan

### Perubahan Plugin (Versi 1.1.0)
- Mengganti plugin "Berita Desa" yang spesifik dengan plugin "Berita" yang umum
- Plugin "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus kode yang tidak digunakan untuk plugin yang sudah dihapus

## Mulai Cepat

### Instalasi Cepat
```bash
# Clone repository
git clone https://github.com/username/stelloCMS.git
cd stelloCMS

# Install dependencies
composer install
npm install && npm run dev

# Konfigurasi environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database dan migrasi
php artisan migrate --seed

# Jalankan aplikasi
php artisan serve
```

### Konfigurasi Minimum
1. Sesuaikan konfigurasi database di `.env`
2. Jalankan migrasi dengan `php artisan migrate --seed`
3. Akses aplikasi melalui `http://localhost:8000`

## Dukungan dan Komunitas

### Kanal Dukungan
- **GitHub Issues**: Laporkan bug dan permintaan fitur
- **Forum Komunitas**: Diskusi dan bantuan pengguna
- **Documentation**: Dokumentasi resmi dan panduan
- **Email Support**: support@stellocms.com

### Kontribusi
Kami menyambut kontribusi dari komunitas:
1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat pull request

### Pedoman Kontribusi
- Ikuti pedoman penulisan kode Laravel
- Tulis dokumentasi yang jelas untuk setiap fitur baru
- Tambahkan test untuk setiap perubahan yang signifikan
- Gunakan commit message yang deskriptif
- Pastikan semua test berjalan dengan baik sebelum membuat pull request

## Lisensi
stelloCMS dilisensikan di bawah lisensi MIT. Lihat file [LICENSE](../LICENSE) untuk detail lebih lanjut.

## Kontak
Untuk pertanyaan dan dukungan, silakan hubungi tim pengembang stelloCMS di hello@stellocms.com.
