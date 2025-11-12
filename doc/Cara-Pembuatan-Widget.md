# Panduan Praktis Membuat Widget Plugin untuk stelloCMS

## Daftar Isi
1. [Pengantar Widget Plugin](#pengantar-widget-plugin)
2. [Jenis-jenis Widget](#jenis-jenis-widget)
3. [Membuat Widget Plugin](#membuat-widget-plugin)
4. [Membuat Widget Text dan HTML](#membuat-widget-text-dan-html)
5. [Best Practices](#best-practices)
6. [Troubleshooting](#troubleshooting)

## Pengantar Widget Plugin

Widget adalah elemen tampilan dinamis yang dapat ditempatkan di berbagai posisi dalam sistem stelloCMS. Widget memungkinkan penempatan konten di area-area tertentu seperti sidebar, header, footer, atau halaman home tanpa mengubah struktur utama sistem.

### Keunggulan Widget
- **Fleksibilitas**: Tempatkan konten di posisi yang Anda inginkan
- **Dinamis**: Aktif/nonaktifkan sesuai kebutuhan
- **Personalisasi**: Tampilkan konten berdasarkan konteks atau role
- **Integrasi Plugin**: Menampilkan konten dari plugin yang terinstal

## Jenis-jenis Widget

### 1. Plugin Widget
- Menampilkan konten dari plugin yang terinstal
- Menggunakan nama plugin untuk mengakses konten
- Cocok untuk menampilkan informasi dinamis dari plugin

### 2. Text Widget
- Menampilkan teks sederhana
- Ideal untuk informasi statis atau pengumuman
- Mendukung format dasar teks

### 3. HTML Widget
- Menampilkan konten HTML
- Cocok untuk elemen tampilan khusus
- Mendukung embed code dari layanan eksternal

## Membuat Widget Plugin

### Langkah 1: Pastikan Plugin Terinstal
Sebelum membuat widget plugin, pastikan plugin yang ingin ditampilkan telah:
- Diinstal di sistem melalui menu Plugin
- Diaktifkan dan berfungsi dengan baik
- Memiliki endpoint atau method untuk menampilkan konten widget

### Langkah 2: Akses Menu Widget
1. Login sebagai admin atau operator
2. Akses menu **Pengaturan** → **Widgets**
3. Klik tombol **Tambah Widget**

### Langkah 3: Isi Form Widget Plugin
```
Nama: [Nama widget, misal: "Widget Berita Terbaru"]
Tipe: Plugin
Posisi: [Pilih posisi yang diinginkan]
Status: Aktif
Nama Plugin: [Nama plugin yang sesuai]
Urutan: [Angka untuk mengatur urutan]
```

### Langkah 4: Konfigurasi Tambahan (Opsional)
Jika plugin memiliki pengaturan spesifik untuk widget, Anda bisa mengisinya di field Pengaturan dalam format JSON:
```json
{
    "limit": 5,
    "show_date": true,
    "show_thumbnail": true
}
```

## Membuat Widget Text dan HTML

### Membuat Text Widget
1. Pilih tipe **Text** saat membuat widget baru
2. Isi **Konten** dengan teks yang ingin ditampilkan
3. Gunakan tag HTML dasar jika diperlukan (dengan batasan keamanan)

### Membuat HTML Widget
1. Pilih tipe **HTML** saat membuat widget baru
2. Isi **Konten** dengan kode HTML yang ingin ditampilkan
3. **PERINGATAN**: Hanya kode HTML yang aman yang harus digunakan untuk mencegah XSS

## Best Practices

### Pengelolaan Widget
- **Gunakan nama yang deskriptif** untuk memudahkan identifikasi
- **Atur urutan widget** untuk kontrol tampilan
- **Batasi jumlah widget** per posisi untuk menjaga kecepatan loading
- **Gunakan status widget** untuk mengaktifkan/nonaktifkan tanpa menghapus

### Keamanan Konten
- **Validasi konten HTML** sebelum menyimpan
- **Gunakan hanya plugin terpercaya** dalam widget plugin
- **Batasi akses** pembuatan widget hanya untuk role yang berwenang
- **Perhatikan sanitasi** konten dari user input

### Kinerja dan Optimasi
- **Gunakan caching** untuk widget dengan konten yang tidak sering berubah
- **Optimalkan query** untuk widget plugin yang menampilkan data besar
- **Gunakan lazy loading** jika widget memuat resource eksternal
- **Ukur waktu rendering** untuk widget kompleks

### Tampilan dan UX
- **Pastikan widget responsif** dan tampil baik di berbagai ukuran layar
- **Gunakan ukuran konten yang proporsional** dengan posisi widget
- **Berikan batasan jumlah item** untuk widget yang menampilkan daftar
- **Gunakan animasi/efek secara bijak** agar tidak mengganggu UX

### Plugin Widget Spesifik
- **Pastikan plugin memiliki method khusus** untuk konten widget
- **Gunakan model dan resource minimal** untuk widget
- **Implementasikan error handling** jika data tidak tersedia
- **Gunakan format tampilan ringkas** untuk widget

## Troubleshooting

### Widget Tidak Muncul di Tampilan
- **Periksa status widget**: Pastikan statusnya "Aktif"
- **Periksa posisi widget**: Pastikan posisi sesuai dengan template yang digunakan
- **Periksa role pengguna**: Pastikan pengguna memiliki hak akses
- **Clear cache**: Jalankan `php artisan view:clear` dan `php artisan cache:clear`

### Plugin Widget Tidak Berfungsi
- **Verifikasi nama plugin**: Pastikan nama plugin benar dan terinstal
- **Cek endpoint plugin**: Pastikan plugin memiliki konten yang bisa ditampilkan
- **Periksa error log**: Lihat `storage/logs/laravel.log` untuk error terkait
- **Test manual**: Coba akses konten plugin secara langsung

### HTML Widget Tidak Ditampilkan Sempurna
- **Periksa validitas HTML**: Pastikan struktur HTML benar
- **Periksa kebijakan keamanan**: Beberapa tag mungkin diblokir
- **Gunakan HTML sederhana**: Hindari struktur kompleks di widget

### Widget Membuat Halaman Lambat
- **Optimalkan query**: Gunakan eager loading dan indexing
- **Terapkan caching**: Gunakan cache untuk data yang tidak sering berubah
- **Batasi jumlah data**: Tampilkan hanya data yang relevan
- **Gunakan asinkron**: Muat konten secara asinkron jika perlu

### Integrasi dengan Tema
- **Pastikan tema mendukung** posisi widget yang digunakan
- **Cek struktur CSS**: Pastikan tidak ada konflik kelas CSS
- **Gunakan kelas khusus**: Tambahkan kelas unik untuk styling widget

## Contoh Implementasi

### Contoh Widget Plugin: Berita Terbaru
```php
// Widget untuk menampilkan 5 berita terbaru
Nama: "Berita Terbaru"
Tipe: Plugin
Posisi: "sidebar-right"
Nama Plugin: "Berita"
Konten: ""
Pengaturan: {"limit": 5, "show_image": true, "order_by": "latest"}
```

### Contoh Widget Plugin: Berita Acak
```php
// Widget untuk menampilkan 1 berita acak yang memiliki gambar
Nama: "Berita Acak"
Tipe: Plugin
Posisi: "sidebar-left"
Nama Plugin: "Berita"
Konten: ""
Pengaturan: {"limit": 1, "has_image": true, "random": true}
```

### Contoh Widget Plugin: Berita Acak
```php
// Widget untuk menampilkan 1 berita acak yang memiliki gambar
Nama: "Berita Acak"
Tipe: Plugin
Posisi: "sidebar-left"  // Atau posisi lain tergantung kebutuhan
Nama Plugin: "Berita" 
Konten: ""
Pengaturan: {"limit": 1, "has_image": true, "random": true}
```

### Contoh Widget HTML: Embed Video YouTube
```php
// Widget untuk embed video di sidebar
Nama: "Video Terbaru"
Tipe: HTML
Posisi: "sidebar-left"
Konten: '<iframe width="100%" height="200" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allowfullscreen></iframe>'
Status: Aktif
```

### Contoh Widget Text: Pengumuman
```php
// Widget pengumuman penting
Nama: "Pengumuman Penting"
Tipe: Text
Posisi: "header"
Konten: "Pengumuman: Jadwal libur tahun baru akan diumumkan segera."
Status: Aktif
```

Dengan mengikuti panduan ini, Anda akan mampu membuat dan mengelola widget yang efektif dan aman di sistem stelloCMS, memberikan fleksibilitas tambahan untuk menyesuaikan tampilan dan konten sistem sesuai kebutuhan.