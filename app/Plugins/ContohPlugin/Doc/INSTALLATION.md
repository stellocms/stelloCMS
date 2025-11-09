# Panduan Instalasi Plugin Contoh

## Prasyarat Sistem

Sebelum menginstal plugin Contoh, pastikan sistem Anda memenuhi persyaratan berikut:

### Server Requirements
- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.2
- Ekstensi PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath
- Web server (Apache/Nginx)
- Composer

### Sistem stelloCMS
- Sistem stelloCMS terinstal dan berjalan
- Hak akses administrator ke panel CMS
- Akses ke direktori `app/Plugins/`

## Metode Instalasi

### Metode 1: Instalasi Melalui Panel Administrasi (Disarankan)

1. **Upload Plugin**
   - Login ke panel administrasi
   - Buka menu "Plugin"
   - Klik tombol "Upload Plugin"
   - Pilih file `ContohPlugin.zip`
   - Tunggu proses upload selesai

2. **Instal Plugin**
   - Setelah upload, plugin akan muncul dalam daftar
   - Klik tombol "Instal" pada ContohPlugin
   - Tunggu proses instalasi selesai
   - Plugin otomatis aktif

3. **Verifikasi Instalasi**
   - Pastikan plugin muncul sebagai "Terinstal" dan "Aktif"
   - Periksa bahwa menu plugin muncul di sidebar

### Metode 2: Instalasi Manual

1. **Ekstrak Plugin**
   - Ekstrak file plugin ke direktori sementara
   - Pastikan struktur direktori benar

2. **Salin ke Direktori Plugin**
   ```bash
   # Salin ke direktori plugins
   cp -r /path/to/ContohPlugin /path/to/stelloCMS/app/Plugins/
   ```

3. **Login ke Panel Administrasi**
   - Buka `http://localhost/stelloCMS/public/panel`
   - Login dengan akun administrator

4. **Instal melalui Panel**
   - Buka menu "Plugin"
   - Temukan "ContohPlugin" dalam daftar
   - Klik tombol "Instal"
   - Tunggu proses instalasi selesai

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
├── Doc/
│   ├── README.md
│   ├── DEVELOPING.md
│   └── HELPERS.md
```

## Konfigurasi Setelah Instalasi

### Verifikasi Tabel Database

Plugin akan membuat tabel berikut secara otomatis:

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

### Menu yang Dibuat

Setelah instalasi, sistem akan membuat menu:

- **Menu Utama**: "Manajemen Plugin Contoh"
- **URL Backend**: `/panel/contohplugin`
- **URL Frontend**: `/contohplugin`
- **Route**: `contohplugin.index`
- **Hak Akses**: Berdasarkan role pengguna

## Penggunaan Plugin

### Backend (Admin Panel)

Setelah instalasi, plugin menyediakan:

- **Daftar Item**: `/panel/contohplugin`
- **Form Tambah**: `/panel/contohplugin/create`
- **Form Edit**: `/panel/contohplugin/{id}/edit`
- **Detail Item**: `/panel/contohplugin/{id}`

### Frontend (Publik)

Plugin juga menyediakan tampilan publik:

- **Daftar Item Publik**: `/contohplugin`
- **Detail Item Publik**: `/contohplugin/{slug}`

## Fitur-Fitur Plugin

### 1. CRUD Lengkap
- **Create**: Form tambah item baru
- **Read**: Tampilan daftar dan detail item
- **Update**: Form edit item
- **Delete**: Fungsi hapus item

### 2. Sistem Slug Otomatis
- Slug dibuat otomatis dari judul
- Slug unik (dengan angka jika bentrok)
- Mendukung SEO

### 3. Upload Gambar
- Dukungan upload gambar untuk setiap item
- Gambar disimpan di direktori `storage/app/public/`
- Tampilan responsif

### 4. Status Aktif/Nonaktif
- Pengaturan status publikasi item
- Hanya item aktif yang ditampilkan di frontend

## Troubleshooting

### Plugin Tidak Muncul di Panel
**Gejala**: Plugin tidak muncul setelah diinstal
**Kemungkinan Penyebab**:
- Struktur direktori salah
- File `plugin.json` tidak valid
- Nama plugin tidak sesuai dengan nama folder

**Solusi**:
1. Periksa struktur direktori
2. Verifikasi file `plugin.json`
3. Pastikan nama plugin sesuai dengan nama folder

### Route Tidak Ditemukan
**Gejala**: URL plugin menghasilkan 404
**Kemungkinan Penyabab**:
- Route cache belum diperbarui
- Plugin belum benar-benar aktif

**Solusi**:
```bash
# Clear route cache
php artisan route:clear

# Clear all caches
php artisan cache:clear
```

### Tabel Database Tidak Dibuat
**Gejala**: Error terkait tabel tidak ditemukan
**Kemungkinan Penyebab**:
- Hak akses database tidak mencukupi
- Proses instalasi tidak selesai

**Solusi**:
1. Cek hak akses database
2. Ulangi proses instalasi
3. Pastikan konfigurasi database benar

### View Tidak Ditemukan
**Gejala**: Error "View not found"
**Kemungkinan Penyebab**:
- Namespace view salah
- PluginServiceProvider tidak aktif

**Solusi**:
```bash
# Clear view cache
php artisan view:clear

# Clear configuration cache
php artisan config:clear
```

## Update Plugin

### Manual Update
1. Backup file plugin lama
2. Ganti file plugin dengan versi baru
3. Jalankan `php artisan route:clear`
4. Verifikasi fungsionalitas plugin

### Via Panel (Jika Tersedia)
1. Buka menu "Plugin"
2. Temukan ContohPlugin
3. Klik tombol "Update"
4. Pilih file plugin baru dalam format ZIP

## Uninstall Plugin

### Melalui Panel Administrasi
1. Login ke panel administrasi
2. Buka menu "Plugin"
3. Temukan "ContohPlugin"
4. Klik tombol "Hapus"
5. Konfirmasi penghapusan

**Catatan**: Data plugin biasanya disimpan untuk mencegah kehilangan informasi penting.

### Manual Uninstall
1. Hapus direktori `app/Plugins/ContohPlugin/`
2. Hapus entri menu dari tabel `menus` di database
3. Hapus tabel `contoh_plugins` jika diperlukan

## Kesimpulan

Plugin Contoh sekarang telah berhasil diinstal dan siap digunakan. Plugin ini menyediakan contoh lengkap dari struktur dan fungsi plugin dalam sistem stelloCMS, termasuk:
- CRUD operasi lengkap
- Frontend dan backend interfaces
- Sistem slug otomatis
- Upload dan tampilan gambar
- Integrasi dengan sistem tema dan role

Pastikan untuk selalu backup sistem sebelum instalasi plugin baru dan verifikasi bahwa semua fitur berfungsi dengan benar setelah instalasi.