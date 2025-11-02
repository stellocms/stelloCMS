# Contributing to stelloCMS

Kami sangat menghargai kontribusi Anda pada proyek stelloCMS! Dokumen ini memberikan panduan untuk berkontribusi pada pengembangan stelloCMS.

## Cara Kontribusi

### Melaporkan Bug
Sebelum membuat issue baru, harap:
1. Cari issue yang sudah ada untuk memastikan bug belum dilaporkan
2. Periksa dokumentasi dan troubleshooting guide
3. Pastikan Anda menggunakan versi terbaru stelloCMS

Ketika membuat bug report, sertakan:
- Versi stelloCMS yang digunakan
- Langkah-langkah untuk mereproduksi bug
- Hasil yang diharapkan vs hasil aktual
- Informasi lingkungan (PHP version, database, OS, dll.)

### Mengusulkan Fitur
Untuk mengusulkan fitur baru:
1. Cari issue yang sudah ada untuk memastikan fitur belum diajukan
2. Jelaskan dengan jelas kebutuhan dan manfaat fitur tersebut
3. Sertakan contoh kasus penggunaan

### Mengirim Pull Request
1. Fork repository
2. Buat branch fitur baru dari `develop`
3. Lakukan perubahan dengan mengikuti panduan kode
4. Tambahkan test untuk perubahan yang signifikan
5. Perbarui dokumentasi jika diperlukan
6. Kirim pull request ke branch `develop`

## Panduan Kode

### Standar Penulisan Kode
- Ikuti [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- Gunakan type hinting yang sesuai
- Tulis docblock untuk semua method publik
- Gunakan nama variabel dan fungsi yang deskriptif

### Struktur Direktori
```
/app
├── Http
├── Models
├── Plugins
├── Providers
├── Services
├── Themes
└── helpers.php
```

### Penamaan
- Gunakan camelCase untuk nama variabel dan method
- Gunakan PascalCase untuk nama kelas
- Gunakan UPPER_CASE untuk konstanta
- Gunakan snake_case untuk nama tabel dan kolom database

## Testing

### Menjalankan Test
```bash
php artisan test
```

### Menulis Test
- Gunakan PHPUnit untuk unit test
- Gunakan Pest untuk feature test (opsional)
- Tulis test yang mencakup edge cases
- Pastikan semua test berjalan dengan baik sebelum membuat pull request

## Dokumentasi

### Menulis Dokumentasi
- Tulis dokumentasi dalam bahasa Indonesia
- Gunakan format Markdown
- Ikuti struktur dokumentasi yang sudah ada
- Perbarui dokumentasi setiap kali ada perubahan fitur

## Code Review

Pull request akan ditinjau oleh tim pengembang. Proses review bertujuan untuk:
- Memastikan kualitas kode
- Memastikan tidak ada bug
- Memastikan dokumentasi sudah cukup
- Memastikan test sudah mencakup perubahan

## Lisensi

Dengan berkontribusi pada stelloCMS, Anda setuju bahwa kontribusi Anda akan dilisensikan di bawah lisensi MIT.

## Pertanyaan?

Jika Anda memiliki pertanyaan tentang kontribusi:
1. Buka issue di repository
2. Hubungi tim pengembang di hello@stello-cms.com
3. Bergabung dengan komunitas Discord (jika tersedia)

Terima kasih atas kontribusi Anda untuk stelloCMS!