# Panduan File Install untuk Plugin Berita

## Deskripsi

File `install.php` adalah komponen penting dalam plugin Berita yang menangani pembuatan dan pembaruan struktur tabel `berita` secara dinamis. File ini digunakan ketika plugin diinstal atau diperbarui, menggantikan pendekatan lama yang menggunakan fungsi dalam PluginManager.php atau file migrasi di folder Database/.

**Catatan Penting:** Dengan adanya file `install.php`, folder `Database/` tidak lagi diperlukan dan telah dihapus dari struktur plugin Berita. Ini memberikan fleksibilitas lebih besar dalam pengelolaan struktur database plugin secara dinamis.

## Struktur File

File `install.php` berisi class `BeritaInstaller` dengan metode-metode berikut:

- `install()` - Membuat atau memperbarui tabel berita
- `uninstall()` - Menghapus tabel berita (jika diperlukan)

## Fungsi Install

Metode `install()` melakukan hal-hal berikut:

1. Mengecek apakah tabel `berita` sudah ada di database
2. Jika tabel belum ada, membuat tabel baru dengan struktur yang benar
3. Jika tabel sudah ada, memeriksa kolom-kolom yang hilang dan menambahkannya
4. Memastikan foreign key ke tabel `users` terbentuk dengan benar

## Fungsi Uninstall

Metode `uninstall()` menghapus tabel `berita` dari database saat plugin dihapus secara permanen.

## Keunggulan Pendekatan Baru

### 1. Fleksibilitas
- Plugin dapat menentukan sendiri struktur tabelnya
- Dapat menyesuaikan perubahan struktur tanpa mengganti file inti sistem

### 2. Keterpisahan Kepedulian
- Setiap plugin mengelola struktur datanya sendiri
- Tidak bergantung pada fungsi umum dalam PluginManager.php

### 3. Keterbacaan
- Mudah dipahami apa yang dilakukan oleh setiap plugin
- Dokumentasi dan struktur lebih jelas

## Implementasi

File `install.php` mengimplementasikan pendekatan berbasis migrasi yang lebih sesuai dengan standar Laravel:

```php
// Contoh pendekatan untuk mengecek dan menambahkan kolom
if (!Schema::hasColumn('berita', 'nama_kolom')) {
    Schema::table('berita', function (Blueprint $table) {
        $table->string('nama_kolom')->nullable();
    });
}
```

## Integrasi dengan PluginManager

Saat plugin diinstal, PluginManager.php sekarang:

1. Mengecek apakah plugin memiliki file `install.php`
2. Jika ada, menginclude file tersebut
3. Mencari class `{NamaPlugin}Installer` (dalam kasus ini `BeritaInstaller`)
4. Jika class dan metode `install()` ditemukan, menjalankan metode tersebut
5. Jika tidak ada, menggunakan pendekatan migrasi standar

Saat plugin dihapus:

1. Mengecek apakah plugin memiliki file `install.php`
2. Mencari class `{NamaPlugin}Installer` 
3. Jika class dan metode `uninstall()` ditemukan, menjalankan metode tersebut
4. Untuk membersihkan database