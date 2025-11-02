# stelloCMS Core Repository

Selamat datang di repository inti stelloCMS! Repository ini berisi kode sumber utama untuk stelloCMS - Content Management System berbasis Laravel yang dirancang untuk memudahkan pengelolaan konten website.

## Tentang Repository Ini

Repository ini berisi:
- Kode sumber inti stelloCMS
- Sistem tema dan plugin modular
- Manajemen pengguna berbasis role
- Konfigurasi dan dokumentasi lengkap
- Workflow GitHub Actions untuk CI/CD

## Struktur Repository

```
stelloCMS/
├── app/                    # Kode sumber inti aplikasi
│   ├── Http/              # Controllers, middleware, dan request
│   ├── Models/            # Model database
│   ├── Plugins/           # Plugin sistem
│   ├── Providers/         # Service providers
│   ├── Services/          # Service classes
│   ├── Themes/            # Tema sistem
│   └── helpers.php        # Helper functions
├── config/                # File konfigurasi
├── database/              # Migrasi dan seeder database
├── doc/                   # Dokumentasi lengkap
├── public/                # File publik (assets, index.php)
├── resources/             # View, bahasa, dan assets
├── routes/                # Definisi route
├── storage/               # File storage (logs, cache, uploads)
├── tests/                 # Unit dan feature tests
└── vendor/                # Dependensi Composer
```

## GitHub Actions

Repository ini menggunakan GitHub Actions untuk:
- **Deploy**: Deployment otomatis ke server produksi
- **Test**: Testing otomatis untuk setiap perubahan
- **Code Quality**: Analisis kualitas kode dan gaya penulisan

Workflow tersedia di direktori `.github/workflows/`.

## Kontribusi

Kami menyambut kontribusi dari komunitas! Silakan baca:
- [CONTRIBUTING.md](CONTRIBUTING.md) - Panduan kontribusi
- [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) - Kode etik komunitas
- [SUPPORT.md](SUPPORT.md) - Panduan dukungan

## Lisensi

Kode sumber ini dilisensikan di bawah lisensi MIT. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## Kontak

Untuk pertanyaan dan dukungan:
- Email: hello@stello-cms.com
- Website: https://stello-cms.com
- GitHub Discussions: [Diskusi Komunitas](https://github.com/stellocms/core/discussions)