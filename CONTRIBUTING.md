# Contributing to stelloCMS

Kami menyambut kontribusi dari komunitas untuk membuat stelloCMS menjadi lebih baik!

## Cara Kontribusi

### 1. Fork Repository
1. Fork repository ini ke akun GitHub Anda
2. Clone fork Anda ke mesin lokal
3. Tambahkan upstream repository: `git remote add upstream https://github.com/stellocms/core.git`

### 2. Buat Branch Fitur
```bash
git checkout -b feature/nama-fitur-anda
```

### 3. Lakukan Perubahan
- Ikuti pedoman penulisan kode Laravel
- Tulis dokumentasi yang jelas untuk setiap fitur baru
- Tambahkan test untuk setiap perubahan yang signifikan
- Gunakan commit message yang deskriptif

### 4. Commit dan Push
```bash
git add .
git commit -m "feat: tambahkan fitur baru untuk ..."
git push origin feature/nama-fitur-anda
```

### 5. Buat Pull Request
1. Buka pull request dari branch Anda ke branch `develop` di repository utama
2. Jelaskan perubahan yang Anda buat
3. Tunggu review dari tim pengembang

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
- Gunatkan Pest untuk feature test (opsional)
- Tulis test yang mencakup edge cases
- Pastikan semua test berjalan dengan baik sebelum membuat pull request

## Dokumentasi

### Menulis Dokumentasi
- Tulis dokumentasi dalam bahasa Indonesia
- Gunakan format Markdown
- Ikuti struktur dokumentasi yang sudah ada
- Perbarui dokumentasi setiap kali ada perubahan fitur

## Issues

### Melaporkan Bug
1. Pastikan bug belum dilaporkan
2. Gunakan template issue yang tersedia
3. Jelaskan langkah-langkah untuk mereproduksi bug
4. Sertakan informasi sistem dan versi stelloCMS

### Meminta Fitur
1. Jelaskan kebutuhan fitur dengan jelas
2. Berikan contoh kasus penggunaan
3. Diskusikan dengan komunitas sebelum membuat permintaan

## Code of Conduct

### Etika Kontribusi
- Bersikap sopan dan profesional
- Hormati pendapat orang lain
- Bantu sesama kontributor
- Jaga kualitas kode dan dokumentasi
- Jangan melakukan plagiat

## Pertanyaan?

Jika Anda memiliki pertanyaan tentang kontribusi, silakan:
1. Buka issue di repository
2. Hubungi tim pengembang di hello@stello-cms.com
3. Bergabung dengan komunitas Discord (jika tersedia)

Terima kasih atas kontribusi Anda untuk stelloCMS!