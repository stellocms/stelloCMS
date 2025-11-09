<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if 'settings' menu already exists
        $existingMenu = DB::table('menus')->where('name', 'setting')->first();
        
        if (!$existingMenu) {
            // Find the parent 'Settings' menu (the main Settings menu)
            $settingsParent = DB::table('menus')->where('title', 'Pengaturan')->first();
            
            if (!$settingsParent) {
                // If 'Pengaturan' doesn't exist, we need to create it first
                $settingsParentId = DB::table('menus')->insertGetId([
                    'name' => 'settings-main',
                    'title' => 'Pengaturan',
                    'icon' => 'fas fa-cog',
                    'parent_id' => null,
                    'order' => 10,
                    'is_active' => true,
                    'plugin_name' => null,
                    'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $settingsParentId = $settingsParent->id;
            }
            
            // Insert the 'Setting' submenu
            DB::table('menus')->insert([
                'name' => 'setting',
                'title' => 'Setting',
                'route' => 'settings.index',
                'icon' => 'fas fa-sliders-h',
                'parent_id' => $settingsParentId,
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