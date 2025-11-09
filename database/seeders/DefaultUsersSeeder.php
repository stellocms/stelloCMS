<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin', 'operator', 
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Admin default
        User::firstOrCreate(
            ['email' => 'admin@simpede.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Password'),
                'role_id' => Role::where('name', 'admin')->first()->id,
            ]
        );
        
        // Call MenusSeeder
        $this->call(MenusSeeder::class);
    }
}