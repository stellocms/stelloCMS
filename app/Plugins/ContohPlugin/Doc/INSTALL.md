# Panduan File Install untuk Plugin ContohPlugin

## Deskripsi

File `install.php` adalah komponen penting dalam plugin ContohPlugin yang menangani pembuatan dan pembaruan struktur tabel `contoh_plugins` secara dinamis. File ini digunakan ketika plugin diinstal atau diperbarui, menggantikan pendekatan lama yang menggunakan fungsi dalam PluginManager.php.

## Struktur File

File `install.php` berisi class `ContohPluginInstaller` dengan metode-metode berikut:

- `install()` - Membuat atau memperbarui tabel contoh_plugins
- `uninstall()` - Menghapus tabel contoh_plugins (jika diperlukan)

## Fungsi Install

Metode `install()` melakukan hal-hal berikut:

1. Mengecek apakah tabel `contoh_plugins` sudah ada di database
2. Jika tabel belum ada, membuat tabel baru dengan struktur yang benar
3. Jika tabel sudah ada, memeriksa kolom-kolom yang hilang dan menambahkannya
4. Memastikan kolom `slug` memiliki indeks unik

## Fungsi Uninstall

Metode `uninstall()` menghapus tabel `contoh_plugins` dari database saat plugin dihapus secara permanen.

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
if (!Schema::hasColumn('contoh_plugins', 'nama_kolom')) {
    Schema::table('contoh_plugins', function (Blueprint $table) {
        $table->string('nama_kolom')->nullable();
    });
}
```

## Integrasi dengan PluginManager

Saat plugin diinstal, PluginManager.php sekarang:

1. Mengecek apakah plugin memiliki file `install.php`
2. Jika ada, menginclude file tersebut
3. Mencari class `{NamaPlugin}Installer` (dalam kasus ini `ContohPluginInstaller`)
4. Jika class dan metode `install()` ditemukan, menjalankan metode tersebut
5. Jika tidak ada, menggunakan pendekatan migrasi standar

Saat plugin dihapus:

1. Mengecek apakah plugin memiliki file `install.php`
2. Mencari class `{NamaPlugin}Installer` 
3. Jika class dan metode `uninstall()` ditemukan, menjalankan metode tersebut
4. Untuk membersihkan database