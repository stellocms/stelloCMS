<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if menu already exists
        $menuExists = DB::table('menus')->where('name', 'settings')->first();
        
        if (!$menuExists) {
            // Find the 'Pengaturan' parent menu
            $settingsParent = DB::table('menus')->where('title', 'Pengaturan')->first();
            
            DB::table('menus')->insert([
                'name' => 'settings',
                'title' => 'Setting',
                'route' => 'settings.index',
                'icon' => 'fas fa-cog',
                'parent_id' => $settingsParent ? $settingsParent->id : null,
                'order' => 10,
                'is_active' => true,
                'roles' => json_encode(['admin', 'kepala-desa', 'sekdes']),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('menus')->where('name', 'settings')->delete();
    }
};