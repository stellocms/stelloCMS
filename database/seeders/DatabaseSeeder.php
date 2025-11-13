<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenusSeeder::class,
            BeritaSeeder::class,
            // Tambahkan seeder lainnya di sini jika diperlukan
        ]);
    }
}