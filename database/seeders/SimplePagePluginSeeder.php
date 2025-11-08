<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimplePagePluginSeeder extends Seeder
{
    public function run()
    {
        // Create plugin entry if it doesn't exist
        $plugin = DB::table('plugins')->where('name', 'SimplePage')->first();
        
        if (!$plugin) {
            DB::table('plugins')->insert([
                'name' => 'SimplePage',
                'title' => 'Simple Page Plugin',
                'version' => '1.0.0',
                'description' => 'A simple plugin for creating pages',
                'author' => 'StelloCMS Developer',
                'author_url' => 'https://stello-cms.com',
                'category' => 'utility',
                'screenshot' => '',
                'tags' => json_encode(['pages', 'simple', 'utility']),
                'installed' => true,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}