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
        // Create main menu items with proper type and position
        $mainMenus = [
            [
                'name' => 'dashboard',
                'title' => 'Dashboard',
                'route' => 'panel.dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'order' => 1,
                'is_active' => true,
                'roles' => null,
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'users',
                'title' => 'Pengguna',
                'icon' => 'fas fa-users',
                'order' => 2,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa'],
                'url' => '#', // Parent menu without specific route
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'settings',
                'title' => 'Pengaturan',
                'icon' => 'fas fa-cog',
                'order' => 3,
                'is_active' => true,
                'roles' => ['admin'],
                'url' => '#', // Parent menu without specific route
                'type' => 'admin',
                'position' => 'sidebar-left'
            ]
        ];

        foreach ($mainMenus as $menuData) {
            $menu = Menu::updateOrCreate(
                ['name' => $menuData['name']],
                $menuData
            );
            
            // Store menu IDs for submenu creation
            if ($menuData['name'] === 'users') {
                $usersMenuId = $menu->id;
            } elseif ($menuData['name'] === 'settings') {
                $settingsMenuId = $menu->id;
            }
        }

        // Create submenu items for users parent menu
        $userSubmenus = [
            [
                'name' => 'users_management',
                'title' => 'Manajemen Pengguna',
                'route' => 'users.index',
                'icon' => 'fas fa-user',
                'parent_id' => $usersMenuId ?? null, // Using the stored ID
                'order' => 1,
                'is_active' => true,
                'roles' => ['admin'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'roles_management',
                'title' => 'Manajemen Peran',
                'route' => 'roles.index',
                'icon' => 'fas fa-user-tag',
                'parent_id' => $usersMenuId ?? null, // Using the stored ID
                'order' => 2,
                'is_active' => true,
                'roles' => ['admin'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ]
        ];

        foreach ($userSubmenus as $submenuData) {
            if ($submenuData['parent_id']) {
                Menu::updateOrCreate(
                    ['name' => $submenuData['name']],
                    $submenuData
                );
            }
        }

        // Create submenu items for settings parent menu (Tema, Plugin, Menu, Setting)
        $settingsSubmenus = [
            [
                'name' => 'themes_management',
                'title' => 'Tema',
                'route' => 'themes.index',
                'icon' => 'fas fa-paint-brush',
                'parent_id' => $settingsMenuId ?? null, // Using the stored ID
                'order' => 1,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'plugins_management',
                'title' => 'Plugin',
                'route' => 'plugins.index',
                'icon' => 'fas fa-plug',
                'parent_id' => $settingsMenuId ?? null, // Using the stored ID
                'order' => 2,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'menus_management',
                'title' => 'Menu',
                'route' => 'menus.index',
                'icon' => 'fas fa-bars',
                'parent_id' => $settingsMenuId ?? null, // Using the stored ID
                'order' => 3,
                'is_active' => true,
                'roles' => ['admin', 'kepala-desa'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'settings_management',
                'title' => 'Setting',
                'route' => 'setting.index',
                'icon' => 'fas fa-cog',
                'parent_id' => $settingsMenuId ?? null, // Using the stored ID
                'order' => 4,
                'is_active' => true,
                'roles' => ['admin'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ],
            [
                'name' => 'update',
                'title' => 'Update',
                'url' => '/panel/update',
                'icon' => 'fas fa-sync-alt',
                'parent_id' => $settingsMenuId ?? null, // Using the stored ID
                'order' => 5,
                'is_active' => true,
                'roles' => ['admin'],
                'type' => 'admin',
                'position' => 'sidebar-left'
            ]
        ];

        foreach ($settingsSubmenus as $submenuData) {
            if ($submenuData['parent_id']) {
                Menu::updateOrCreate(
                    ['name' => $submenuData['name']],
                    $submenuData
                );
            }
        }
    }
}