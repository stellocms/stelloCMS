<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimplePageMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah menu SimplePage sudah ada
        $existingMenu = DB::table('menus')->where('name', 'simplepage')->first();
        
        if (!$existingMenu) {
            DB::table('menus')->insert([
                'name' => 'simplepage',
                'title' => 'Simple Page',
                'route' => 'simplepage.index',
                'icon' => 'fas fa-file-alt',
                'parent_id' => null,
                'order' => 100,  // Setelah menu utama lainnya
                'is_active' => true,
                'plugin_name' => 'SimplePage',
                'roles' => json_encode(['admin', 'kepala-desa', 'sekdes', 'kaur', 'kadus', 'rw', 'rt']), // Sesuai dengan middleware
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}