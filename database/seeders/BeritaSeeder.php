<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Plugins\Berita\Models\Berita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan user admin ada terlebih dahulu
        $adminUser = \App\Models\User::first();
        if (!$adminUser) {
            $adminUser = \App\Models\User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]);
        }

        // Hapus data berita lama jika ada
        DB::table('berita')->truncate();

        // Data dummy berita
        $beritaData = [
            [
                'judul' => 'Pembukaan Festival Seni dan Budaya 2025',
                'isi' => '<p>Festival Seni dan Budaya 2025 resmi dibuka kemarin dengan meriah. Ribuan pengunjung memadati lokasi acara yang berlangsung di Alun-alun Kota. Berbagai pertunjukan seni tradisional hingga modern turut meramaikan acara pembukaan ini.</p><p>Acara ini akan berlangsung selama satu minggu penuh dengan berbagai rangkaian kegiatan menarik. Masyarakat sangat antusias menyambut acara ini yang digelar setelah dua tahun vakum karena pandemi.</p>',
                'tanggal_publikasi' => now()->subDays(1),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang pembukaan Festival Seni dan Budaya 2025 yang meriah di Alun-alun Kota',
                'gambar' => null,
            ],
            [
                'judul' => 'Pembenahan Jalan Raya Menuju Musim Hujan',
                'isi' => '<p>Dinas Pekerjaan Umum mulai melakukan pembenahan pada beberapa ruas jalan utama menyambut musim hujan. Proyek ini ditargetkan selesai sebelum akhir tahun untuk mengantisipasi banjir dan kerusakan jalan akibat curah hujan tinggi.</p><p>Beberapa titik rawan banjir juga akan mendapatkan perhatian khusus dalam proyek pembenahan jalan ini. Warga diimbau untuk menghindari jalur-jalur yang sedang dalam perbaikan.</p>',
                'tanggal_publikasi' => now()->subDays(3),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Update terkini tentang pembenahan jalan raya menjelang musim hujan',
                'gambar' => null,
            ],
            [
                'judul' => 'Pembangunan Puskesmas Baru Dimulai',
                'isi' => '<p>Pembangunan Puskesmas baru di Kecamatan Selatan resmi dimulai minggu ini. Fasilitas kesehatan ini akan menjadi salah satu yang terlengkap di wilayah tersebut dengan berbagai layanan unggulan.</p><p>Dengan adanya Puskesmas baru ini, diharapkan akses masyarakat terhadap pelayanan kesehatan akan semakin meningkat. Proyek ditargetkan selesai dalam waktu 12 bulan.</p>',
                'tanggal_publikasi' => now()->subDays(5),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang pembangunan puskesmas baru di Kecamatan Selatan',
                'gambar' => null,
            ],
            [
                'judul' => 'Pameran Produk UMKM Lokal Meriahkan Akhir Pekan',
                'isi' => '<p>Pameran produk UMKM lokal kembali digelar akhir pekan ini di Taman Rekreasi. Ratusan pelaku UMKM turut serta memeriahkan acara yang menjadi ajang promosi produk-produk asli daerah.</p><p>Acara ini juga menjadi wadah bagi pelaku UMKM untuk bertukar informasi dan pengalaman dalam mengembankan usahanya. Minat masyarakat terhadap produk lokal terus meningkat dari tahun ke tahun.</p>',
                'tanggal_publikasi' => now()->subDays(7),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang pameran produk UMKM lokal yang meriahkan akhir pekan',
                'gambar' => null,
            ],
            [
                'judul' => 'Program Beasiswa untuk Mahasiswa Berprestasi Diperluas',
                'isi' => '<p>Pemkot secara resmi memperluas program beasiswa untuk mahasiswa berprestasi dari keluarga tidak mampu. Tahun ini, jumlah kuota beasiswa dinaikkan 50% dari tahun sebelumnya.</p><p>Program ini merupakan bentuk komitmen pemerintah daerah dalam mendukung pendidikan tinggi. Pendaftaran sudah dibuka dan akan ditutup dalam dua minggu ke depan.</p>',
                'tanggal_publikasi' => now()->subDays(10),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Info terbaru tentang perluasan program beasiswa untuk mahasiswa berprestasi',
                'gambar' => null,
            ],
            [
                'judul' => 'Lomba Desa Wisata Tingkat Kabupaten 2025 Dimulai',
                'isi' => '<p>Kegiatan lomba desa wisata tingkat kabupaten resmi digelar tahun ini. Sebanyak 50 desa ikut serta dalam kompetisi yang bertujuan meningkatkan kualitas desa wisata dan perekonomian masyarakat.</p><p>Penilaian dilakukan oleh tim independen dengan kriteria seperti kelestarian budaya, kebersihan lingkungan, dan inovasi dalam pengembangan destinasi wisata. Pemenang akan mendapatkan dana pengembangan desa.</p>',
                'tanggal_publikasi' => now()->subDays(12),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang lomba desa wisata tingkat kabupaten yang baru dimulai',
                'gambar' => null,
            ],
            [
                'judul' => 'Penghargaan Adipura Diterima untuk Kedua Kalinya',
                'isi' => '<p>Kota ini kembali menerima penghargaan Adipura untuk kedua kalinya dalam tiga tahun terakhir. Penghargaan ini diterima langsung oleh Walikota pada acara nasional di Jakarta.</p><p>Prestasi ini merupakan hasil dari kerja keras seluruh elemen masyarakat dan pemerintah dalam menjaga kebersihan dan kelestarian lingkungan. Program-program inovatif turut andil dalam pencapaian ini.</p>',
                'tanggal_publikasi' => now()->subDays(15),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang penerimaan kembali penghargaan Adipura oleh Kota ini',
                'gambar' => null,
            ],
            [
                'judul' => 'Layanan Online Perizinan Berbasis Digital Diluncurkan',
                'isi' => '<p>Pemkot meluncurkan layanan perizinan berbasis digital yang dapat diakses secara online. Sistem ini memungkinkan masyarakat mengurus perizinan tanpa harus datang ke kantor secara fisik.</p><p>Langkah ini merupakan bagian dari transformasi digital pemerintahan untuk meningkatkan efisiensi dan kenyamanan pelayanan publik. Masyarakat hanya perlu mengunggah dokumen dan dapat melacak status permohonan secara real-time.</p>',
                'tanggal_publikasi' => now()->subDays(18),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Update tentang peluncuran layanan online perizinan berbasis digital',
                'gambar' => null,
            ],
            [
                'judul' => 'Kampanye Gizi Seimbang untuk Anak Usia Dini Dimulai',
                'isi' => '<p>Dinas Kesehatan meluncurkan kampanye gizi seimbang untuk anak usia dini. Program ini menargetkan seluruh posyandu dan sekolah dasar untuk menerapkan prinsip gizi seimbang dalam makanan anak.</p><p>Kampanye ini melibatkan para ahli gizi dan tenaga kesehatan yang turun langsung ke lapangan memberikan edukasi kepada orang tua dan pendidik. Program ini diharapkan dapat menurunkan angka kekurangan gizi pada anak.</p>',
                'tanggal_publikasi' => now()->subDays(20),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Informasi tentang kampanye gizi seimbang untuk anak usia dini',
                'gambar' => null,
            ],
            [
                'judul' => 'Peningkatan Keamanan di Kawasan Wisata Menjelang Liburan',
                'isi' => '<p>Menjelang liburan panjang, pihak keamanan meningkatkan pengawasan di seluruh kawasan wisata. Penambahan personel dilakukan secara serentak di tempat-tempat wisata yang diperkirakan akan ramai dikunjungi.</p><p>Para pengunjung juga diimbau untuk tetap menjaga keselamatan dan mengikuti protokol yang ditetapkan. Petugas siaga 24 jam selama masa liburan untuk memastikan kenyamanan dan keamanan wisatawan.</p>',
                'tanggal_publikasi' => now()->subDays(22),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang peningkatan keamanan di kawasan wisata menjelang liburan',
                'gambar' => null,
            ],
            [
                'judul' => 'Pelatihan Digital Marketing untuk UKM Diselenggarakan',
                'isi' => '<p>Dinas Perdagangan dan UKM menyelenggarakan pelatihan digital marketing untuk pelaku usaha mikro. Pelatihan ini bertujuan meningkatkan penjualan produk UKM melalui pemasaran digital.</p><p>Partisipan pelatihan berasal dari berbagai sektor usaha, mulai dari kuliner, kerajinan, hingga fashion. Instruktur pelatihan merupakan praktisi digital marketing yang berpengalaman di bidangnya.</p>',
                'tanggal_publikasi' => now()->subDays(25),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Info tentang pelatihan digital marketing untuk pelaku UKM',
                'gambar' => null,
            ],
            [
                'judul' => 'Penanaman Ribuan Pohon dalam Gerakan Hijau Kota',
                'isi' => '<p>Gerakan hijau kota kembali digelar dengan menanam ribuan pohon di seluruh wilayah kota. Kegiatan ini diikuti oleh aparatur sipil negara, pelajar, dan masyarakat umum.</p><p>Penanaman pohon ini merupakan bagian dari upaya mengurangi dampak perubahan iklim dan meningkatkan kualitas udara. Berbagai jenis pohon buah dan pohon pelindung ditanam di lokasi-lokasi strategis.</p>',
                'tanggal_publikasi' => now()->subDays(28),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang penanaman ribuan pohon dalam gerakan hijau kota',
                'gambar' => null,
            ],
            [
                'judul' => 'Konser Musik Tradisional Meriahkan Hari Jadi Kota',
                'isi' => '<p>Konser musik tradisional digelar meriah dalam rangka peringatan hari jadi kota yang ke-50. Berbagai kesenian daerah ditampilkan oleh seniman-seniman lokal dan nasional.</p><p>Konser ini menjadi ajang pelestarian kesenian tradisional sekaligus hiburan gratis bagi masyarakat. Ribuan warga memadati lokasi acara yang berlangsung di lapangan utama kota.</p>',
                'tanggal_publikasi' => now()->subDays(30),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Berita tentang konser musik tradisional dalam rangka hari jadi kota',
                'gambar' => null,
            ],
            [
                'judul' => 'Program Vaksinasi Masal untuk Lansia Diperluas',
                'isi' => '<p>Dinas Kesehatan memperluas program vaksinasi massal untuk lansia menyusul masih tingginya kasus terkonfirmasi di kalangan usia lanjut. Pelayanan vaksinasi kini disediakan di berbagai titik di seluruh kota.</p><p>Masyarakat lansia diimbau untuk segera mendatangi gerai vaksin terdekat dengan membawa kartu identitas. Proses vaksinasi dilakukan oleh tenaga kesehatan yang terlatih dan bersertifikat.</p>',
                'tanggal_publikasi' => now()->subDays(32),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Update tentang perluasan program vaksinasi untuk lansia',
                'gambar' => null,
            ],
            [
                'judul' => 'Penutupan Jalan untuk Acara Sepeda Santai Akhir Pekan',
                'isi' => '<p>Sejumlah ruas jalan utama akan ditutup sementara untuk acara sepeda santai akhir pekan mendatang. Penutupan jalan berlangsung dari pukul 06.00 hingga 10.00 pagi.</p><p>Masyarakat diimbau untuk mencari rute alternatif selama pelaksanaan acara. Petugas lalu lintas akan disiagakan untuk membantu mengatur arus kendaraan. Acara ini bertujuan meningkatkan kesadaran masyarakat akan gaya hidup sehat.</p>',
                'tanggal_publikasi' => now()->subDays(35),
                'aktif' => true,
                'user_id' => $adminUser->id,
                'meta_description' => 'Info tentang penutupan jalan untuk acara sepeda santai akhir pekan',
                'gambar' => null,
            ],
        ];

        foreach ($beritaData as $data) {
            Berita::create($data);
        }
    }
}