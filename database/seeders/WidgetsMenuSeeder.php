<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WidgetsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah menu untuk widgets sudah ada
        $existingMenu = DB::table('menus')->where('name', 'widgets')->first();

        if (!$existingMenu) {
            // Cari parent menu 'Pengaturan' atau buat jika belum ada
            $pengaturanMenu = DB::table('menus')->where('name', 'pengaturan')->first();
            
            if (!$pengaturanMenu) {
                // Buat menu Pengaturan jika belum ada
                $pengaturanMenuId = DB::table('menus')->insertGetId([
                    'name' => 'pengaturan',
                    'title' => 'Pengaturan',
                    'route' => '#', // Parent menu without specific route
                    'icon' => 'fas fa-cog',
                    'parent_id' => null,
                    'order' => 999, // Letakkan di posisi akhir
                    'is_active' => true,
                    'plugin_name' => null,
                    'roles' => json_encode(['admin', 'operator']),
                    'type' => 'admin',
                    'position' => 'sidebar-left',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $pengaturanMenuId = $pengaturanMenu->id;
            }

            // Tambahkan menu Widgets sebagai submenu dari Pengaturan
            DB::table('menus')->insert([
                'name' => 'widgets',
                'title' => 'Widgets',
                'route' => 'widgets.index',
                'icon' => 'fas fa-th-large',
                'parent_id' => $pengaturanMenuId,
                'order' => 1,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin', 'operator']),
                'type' => 'admin',
                'position' => 'sidebar-left',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            echo "Menu Widgets berhasil ditambahkan ke menu Pengaturan\n";
        } else {
            echo "Menu Widgets sudah ada\n";
        }
    }
}