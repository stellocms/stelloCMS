# Instalasi dan Konfigurasi Plugin Contoh

## Prasyarat Sistem

Sebelum menginstal plugin Contoh, pastikan sistem Anda memenuhi syarat berikut:

### Server Requirements
- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.2
- Composer
- Ekstensi PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath

### Sistem stelloCMS
- Sistem stelloCMS terinstal dan berfungsi
- Akses ke panel administrasi
- Hak akses administrator

## Metode Instalasi

### Metode 1: Instalasi Melalui Panel Administrasi (Direkomendasikan)

1. **Mengunduh Plugin**
   - Siapkan file plugin dalam format ZIP
   - Pastikan struktur file sesuai dengan standar stelloCMS

2. **Login ke Panel Administrasi**
   - Buka browser dan akses `http://domaintools/stelloCMS/public/panel`
   - Login dengan akun administrator

3. **Upload Plugin**
   - Buka menu "Plugin"
   - Klik tombol "Upload Plugin"
   - Pilih file ZIP plugin (ContohPlugin.zip)
   - Tunggu proses upload selesai

4. **Instal Plugin**
   - Setelah upload, plugin akan otomatis dikenali sistem
   - Klik tombol "Instal" pada plugin ContohPlugin
   - Tunggu proses instalasi selesai
   - Sistem akan membuat tabel database dan menu secara otomatis

5. **Verifikasi Instalasi**
   - Plugin seharusnya muncul sebagai "Terinstal" dan "Aktif"
   - Menu plugin akan muncul di sidebar panel

### Metode 2: Instalasi Manual

Jika fitur upload plugin tidak tersedia, ikuti langkah ini:

1. **Menyalin Plugin ke Direktori**
   ```bash
   # Salin folder plugin ke direktori plugins
   cp -r /path/to/ContohPlugin /path/to/stelloCMS/app/Plugins/
   ```

2. **Login ke Panel Administrasi**
   - Buka browser dan akses `http://localhost/stelloCMS/public/panel`
   - Login dengan akun administrator

3. **Instal Plugin**
   - Buka menu "Plugin"
   - Cari "ContohPlugin" dalam daftar
   - Klik tombol "Instal"
   - Tunggu proses instalasi selesai

4. **Verifikasi Instalasi**
   - Plugin seharusnya muncul sebagai "Terinstal" dan "Aktif"
   - Menu plugin akan muncul di sidebar

### Metode 3: Instalasi Melalui Command Line (Advanced)

1. **Salin Plugin ke Direktori**
   ```bash
   # Salin folder ContohPlugin ke app/Plugins/
   ```

2. **Jalankan Instalasi Melalui Tinker**
   ```bash
   cd /path/to/stelloCMS
   php artisan tinker
   ```

   Di tinker:
   ```php
   $pluginManager = app(App\Services\PluginManager::class);
   $pluginManager->installPlugin('ContohPlugin');
   ```

## Struktur File Setelah Instalasi

Setelah instalasi berhasil, sistem akan memiliki struktur berikut:

```
app/Plugins/ContohPlugin/
├── Controllers/
│   └── ContohPluginController.php
├── Models/
│   └── ContohPlugin.php
├── Views/
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── index.blade.php
│   ├── show.blade.php
│   └── frontpage/
│       ├── index.blade.php
│       └── show.blade.php
├── routes.php
├── plugin.json
└── Doc/
    ├── README.md
    ├── DEVELOPING.md
    └── INSTALLATION.md
```

## Konfigurasi Database

Plugin Contoh akan otomatis membuat tabel berikut dalam database:

```sql
CREATE TABLE `contoh_plugins` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `deskripsi` TEXT NOT NULL,
    `gambar` VARCHAR(255) NULL,
    `tanggal_dibuat` TIMESTAMP NULL,
    `aktif` BOOLEAN DEFAULT TRUE,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL
);
```

## Konfigurasi dan Pengaturan

### Pengaturan Awal

1. **Verifikasi Plugin Aktif**
   - Pastikan plugin muncul di menu "Plugin" dengan status "Aktif"
   - Menu "Manajemen Plugin Contoh" seharusnya muncul di sidebar

2. **Cek Hak Akses**
   - Plugin secara otomatis akan mengikuti hak akses role
   - Default: Akses untuk admin, kepala-desa, sekdes, kaur, kadus, rw, rt

3. **Cek Menu Plugin**
   - Menu plugin akan otomatis ditambahkan ke sidebar
   - Nama menu: "Manajemen Plugin Contoh"
   - Route: `/panel/contohplugin`

### Route yang Tersedia

Setelah instalasi, berikut adalah route yang tersedia:

#### Backend (Admin)
- `GET /panel/contohplugin` - Daftar item
- `GET /panel/contohplugin/create` - Form tambah item
- `POST /panel/contohplugin` - Simpan item baru
- `GET /panel/contohplugin/{id}/edit` - Form edit item
- `PUT /panel/contohplugin/{id}` - Update item
- `DELETE /panel/contohplugin/{id}` - Hapus item
- `GET /panel/contohplugin/{id}` - Lihat detail item

#### Frontend (Publik)
- `GET /contohplugin` - Daftar item publik
- `GET /contohplugin/{slug}` - Detail item dengan slug

## Konfigurasi Tema

Plugin menggunakan tema yang aktif:

### Backend Tema
- Menggunakan tema admin yang sedang aktif (default: adminlte)
- Template: `theme.admin.{tema}::layouts.app`

### Frontend Tema
- Menggunakan tema frontend yang sedang aktif
- Template: `theme.frontend.{tema}::layouts.app`

## Troubleshooting

### Plugin Tidak Muncul di Menu
**Kemungkinan Penyebab:**
- Plugin tidak diaktifkan
- Cache menu tidak diperbarui

**Solusi:**
1. Buka menu "Plugin" di panel administrasi
2. Pastikan status plugin adalah "Aktif"
3. Refresh halaman browser

### Route Tidak Bekerja
**Kemungkinan Penyebab:**
- Route cache tidak diperbarui
- Plugin tidak benar-benar diinstal

**Solusi:**
```bash
cd /path/to/stelloCMS
php artisan route:clear
```

### Tabel Database Tidak Dibuat
**Kemungkinan Penyabab:**
- Error saat instalasi plugin
- Hak akses database tidak mencukupi

**Solusi:**
1. Cek log error di `storage/logs/laravel.log`
2. Pastikan user database memiliki hak CREATE dan ALTER
3. Jalankan ulang instalasi plugin

### Slug Tidak Di-generate
**Kemungkinan Penyebab:**
- Helper `generate_slug` tidak ditemukan
- Error pada model hook

**Solusi:**
1. Pastikan `app/helpers.php` telah dimuat
2. Cek apakah fungsi `generate_slug` ada dan dapat diakses

### View Tidak Ditemukan
**Kemungkinan Penyebab:**
- Namespace view tidak benar
- Plugin tidak dianggap aktif

**Solusi:**
1. Pastikan PluginServiceProvider terdaftar di config/app.php
2. Clear view cache: `php artisan view:clear`

### Upload Plugin Gagal
**Kemungkinan Penyebab:**
- Ukuran file terlalu besar
- Format file tidak didukung
- Izin direktori tidak mencukupi

**Solusi:**
1. Cek konfigurasi upload_max_filesize
2. Pastikan file dalam format ZIP
3. Cek izin tulis pada direktori app/Plugins/

## Uninstall Plugin

### Melalui Panel Administrasi
1. Login ke panel administrasi
2. Buka menu "Plugin"
3. Cari "ContohPlugin"
4. Klik tombol "Hapus"
5. Konfirmasi penghapusan

Catatan: Saat uninstall, data plugin tidak dihapus secara otomatis untuk mencegah kehilangan data penting.

### Melalui Command Line
```php
php artisan tinker
```

Di tinker:
```php
$pluginManager = app(App\Services\PluginManager::class);
$pluginManager->uninstallPlugin('ContohPlugin');
```

## Pemeliharaan dan Update

### Update Plugin
1. Backup sistem dan database
2. Ganti file plugin dengan versi baru
3. Jalankan `php artisan route:clear`
4. Verifikasi fungsionalitas

### Backup dan Restore
Backup Plugin:
```bash
# Backup folder plugin
tar -czf contohplugin-backup.tar.gz app/Plugins/ContohPlugin/

# Backup tabel database
mysqldump -u username -p database_name contoh_plugins > contoh_plugins_backup.sql
```

## Testing Setelah Instalasi

### Fungsi Backend
- [ ] Menu muncul di sidebar
- [ ] Dapat mengakses halaman daftar
- [ ] Dapat membuat item baru
- [ ] Dapat mengedit item
- [ ] Dapat menghapus item
- [ ] Validasi bekerja dengan benar

### Fungsi Frontend
- [ ] Halaman daftar publik dapat diakses
- [ ] Detail item dapat diakses melalui slug
- [ ] Tampilan sesuai dengan tema aktif
- [ ] Gambar ditampilkan dengan benar

### Fungsi Slug
- [ ] Slug di-generate otomatis dari judul
- [ ] Slug unik dan tidak bentrok
- [ ] URL menggunakan slug yang benar
- [ ] Halaman detail dapat diakses lewat slug

## Catatan Penting

1. **Keamanan**: Selalu backup sistem sebelum menginstal plugin
2. **Kompatibilitas**: Pastikan plugin kompatibel dengan versi stelloCMS yang digunakan
3. **Performance**: Plugin yang terlalu kompleks bisa mempengaruhi kinerja sistem
4. **Maintenance**: Pastikan plugin terus di-update jika ada pembaruan keamanan

## Dukungan

Jika mengalami masalah saat instalasi:
- Periksa kembali dokumentasi
- Cek log error di `storage/logs/laravel.log`
- Hubungi pengembang plugin jika terdapat masalah teknis

## Kesimpulan

Plugin Contoh sekarang telah berhasil diinstal dan siap digunakan. Plugin ini menyediakan contoh lengkap dari struktur dan fungsionalitas plugin di sistem stelloCMS, termasuk:

- Sistem CRUD lengkap
- Frontend dan backend
- Sistem slug otomatis
- Integrasi dengan tema sistem
- Hak akses berbasis role