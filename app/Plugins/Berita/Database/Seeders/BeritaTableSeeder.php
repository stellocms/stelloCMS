<?php

namespace App\Plugins\Berita\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BeritaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for berita table
        $berita = [
            [
                'judul' => 'Peluncuran Aplikasi SimPeDe',
                'isi' => 'Kami dengan bangga mengumumkan peluncuran aplikasi SimPeDe (Sistem Informasi Pemerintahan Desa) yang dirancang untuk membantu pemerintahan desa dalam mengelola informasi dan layanan kepada masyarakat.',
                'gambar' => null,
                'tanggal_publikasi' => now(),
                'aktif' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Program Bantuan Sosial Tahap I',
                'isi' => 'Pemerintah desa menginformasikan bahwa program bantuan sosial tahap pertama telah dimulai. Silakan kunjungi kantor desa untuk informasi lebih lanjut mengenai persyaratan dan tata cara pengajuan.',
                'gambar' => null,
                'tanggal_publikasi' => now()->subDays(5),
                'aktif' => true,
                'user_id' => 1,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'judul' => 'Jadwal Kegiatan Bulan Ini',
                'isi' => 'Berikut jadwal kegiatan bulan ini:
                - Minggu pertama: Musyawarah Rencana Pembangunan (Musrenbang)
                - Minggu kedua: Vaksinasi COVID-19
                - Minggu ketiga: Posyandu Balita
                - Minggu keempat: Rapat Evaluasi Program',
                'gambar' => null,
                'tanggal_publikasi' => now()->subDays(10),
                'aktif' => true,
                'user_id' => 1,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
        ];

        // Insert sample data
        DB::table('berita')->insert($berita);
    }
}