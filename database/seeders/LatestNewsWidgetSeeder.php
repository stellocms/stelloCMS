<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LatestNewsWidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah widget berita terbaru sudah ada
        $existingWidget = DB::table('widgets')->where('name', 'berita-terbaru-widget')->first();
        
        if (!$existingWidget) {
            // Tambahkan widget berita terbaru
            DB::table('widgets')->insert([
                'name' => 'berita-terbaru-widget',
                'type' => 'plugin',
                'position' => 'sidebar-right',  // Cocok untuk sidebar kanan
                'status' => 'aktif',
                'content' => null,
                'plugin_name' => 'Berita',  // Nama plugin harus sesuai
                'order' => 1,
                'settings' => json_encode([
                    'limit' => 5,
                    'show_date' => true,
                    'show_thumbnails' => false
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            echo "Widget 'Berita Terbaru' berhasil ditambahkan\n";
        } else {
            echo "Widget 'Berita Terbaru' sudah ada\n";
        }
    }
}