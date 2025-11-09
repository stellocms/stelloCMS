<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main menu items
        $mainMenus = [
            [
                'name' => 'dashboard',
                'title' => 'Dashboard',
                'route' => 'panel.dashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'order' => 1,
                'is_active' => true,
                'roles' => null
            ],
            [
                'name' => 'themes',
                'title' => 'Tema',
                'route' => 'themes.index',
                'icon' => 'nav-icon fas fa-paint-brush',
                'order' => 2,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa']
            ],
            [
                'name' => 'plugins',
                'title' => 'Plugin',
                'route' => 'plugins.index',
                'icon' => 'nav-icon fas fa-plug',
                'order' => 3,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa']
            ],
            [
                'name' => 'menus',
                'title' => 'Menu',
                'route' => 'menus.index',
                'icon' => 'nav-icon fas fa-bars',
                'order' => 4,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa']
            ],
            [
                'name' => 'users',
                'title' => 'Pengguna',
                'icon' => 'nav-icon fas fa-users',
                'order' => 5,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa'],
                'url' => '#'
            ]
        ];

        foreach ($mainMenus as $menuData) {
            Menu::updateOrCreate(
                ['name' => $menuData['name']],
                $menuData
            );
        }
    }
}