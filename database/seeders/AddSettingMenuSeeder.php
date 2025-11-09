<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddSettingMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if 'Setting' menu already exists in database
        $settingMenu = DB::table('menus')->where('name', 'setting')->first();
        
        if (!$settingMenu) {
            // Create 'Pengaturan' parent menu if it doesn't exist
            $pengaturanMenu = DB::table('menus')->where('name', 'pengaturan')->first();
            
            if (!$pengaturanMenu) {
                // Create parent 'Pengaturan' menu
                $pengaturanMenuId = DB::table('menus')->insertGetId([
                    'name' => 'pengaturan',
                    'title' => 'Pengaturan',
                    'icon' => 'fas fa-cog',
                    'parent_id' => null,
                    'order' => 100,
                    'is_active' => true,
                    'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $pengaturanMenuId = $pengaturanMenu->id;
            }
            
            // Now create 'Setting' submenu under 'Pengaturan'
            DB::table('menus')->insert([
                'name' => 'setting',
                'title' => 'Setting',
                'route' => 'setting.index',  // Using the actual route I created
                'icon' => 'fas fa-sliders-h',
                'parent_id' => $pengaturanMenuId,
                'order' => 1,
                'is_active' => true,
                'plugin_name' => null,
                'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}