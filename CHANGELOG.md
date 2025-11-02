# Changelog

Semua perubahan penting pada stelloCMS akan dicatat dalam dokumen ini.

Format berdasarkan [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini menggunakan [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Ditambahkan
- Sistem tema dinamis yang dapat mendeteksi tema dari folder
- Sistem plugin modular yang dapat mendeteksi plugin dari folder
- Manajemen role user untuk berbagai jenis pengguna
- Database dan semua tabel yang diperlukan
- Antarmuka manajemen tema dan plugin
- File CSS dan JS contoh untuk mengatasi error 404 pada aset tema
- Struktur direktori untuk aset tema yang bisa diakses melalui web server
- Model User yang hilang dan perbaikan error trait Sanctum
- Layout dasar untuk tema admin dan menggunakan layout tersebut di view-view admin
- Sistem menu dinamis berbasis database
- Model Menu dan migrasi untuk menyimpan data menu
- Seeder untuk menu default
- Tabel menus di database
- Helper view_theme untuk merender view dengan tema yang benar
- Konfigurasi auth.php yang benar untuk sistem otentikasi
- Rute alias untuk login yang mengarah ke panel login
- Integrasi file-file AdminLTE asli ke dalam sistem
- Helper view_theme untuk memprioritaskan tema AdminLTE untuk halaman admin
- Caching konfigurasi dan view agar sistem berjalan lebih optimal
- Tampilan manajemen tema dengan struktur AdminLTE yang lebih sesuai
- Tampilan manajemen tema agar lebih menggunakan komponen AdminLTE
- Controller dan service untuk tema agar benar-benar mengganti tema aktif
- Tampilan sidebar di layout utama agar sesuai dengan demo AdminLTE
- Kelas-kelas HTML agar menggunakan struktur AdminLTE 4.x yang benar
- Fungsi JavaScript untuk mengontrol sidebar unfoldable dan show/hide
- Integrasi CSS dan JS tambahan yang diperlukan oleh AdminLTE
- Sistem menu dinamis berbasis database yang lebih fleksibel
- Model Plugin yang benar untuk interaksi dengan database
- PluginManager yang sepenuhnya dinamis berdasarkan tabel plugins
- Integrasi GitHub Actions untuk deployment otomatis

### Diubah
- Mengganti tema admin dari CoreUI ke AdminLTE untuk stabilitas yang lebih baik
- Menghapus tema CoreUI yang tidak digunakan untuk mengurangi ukuran sistem
- Menyederhanakan struktur tema untuk kemudahan pemeliharaan
- Mengganti plugin "Berita Desa" yang spesifik dengan plugin "Berita" yang umum
- Plugin "Berita" sekarang dapat digunakan untuk berbagai jenis organisasi, bukan hanya desa
- Menghapus kode yang tidak digunakan untuk plugin yang sudah dihapus

### Diperbaiki
- Masalah view dan namespace agar sesuai dengan konfigurasi Laravel
- Masalah dengan base Controller yang hilang
- Masalah dengan variabel error di view login
- Link logout agar menggunakan form POST yang sesuai dengan rute
- Route logout dan memastikan konfigurasinya benar
- Handler untuk route GET logout agar tidak menampilkan error
- Tampilan dashboard admin agar lebih sesuai dengan desain Adminator sebenarnya
- Layout AdminLTE agar menangani kasus ketika user tidak terotentikasi
- Layout AdminLTE agar hanya menampilkan menu jika route dan plugin aktif
- Fungsi uninstallPlugin agar benar-benar menghapus record plugin dari database
- Fungsi isPluginInstalled agar mencocokkan dengan perubahan bahwa plugin dihapus sepenuhnya dari tabel
- PluginManager agar benar-benar mengelola status plugin di database
- Fungsi deactivatePlugin agar benar-benar mengupdate status plugin di database
- Fungsi isPluginActive agar membaca status dari database
- Fungsi activatePlugin agar benar-benar mengupdate status plugin di database
- Fungsi activatePlugin agar juga membuat menu plugin saat diaktifkan

### Dihapus
- Tema CoreUI yang tidak digunakan
- Plugin "Berita Desa" yang spesifik
- Kode yang tidak digunakan untuk plugin yang sudah dihapus
- File lokal yang tidak diperlukan
- Referensi ke file demo.js untuk menghilangkan pesan peringatan

## [1.0.0] - 2025-01-01

### Ditambahkan
- Rilis awal stelloCMS Core
- Sistem tema dinamis
- Sistem plugin modular
- Manajemen pengguna dan hak akses
- Antarmuka administrasi
- Dokumentasi lengkap

[Unreleased]: https://github.com/stellocms/core/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/stellocms/core/releases/tag/v1.0.0