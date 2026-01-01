<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kolom 'role' ada di users (migration add_role_to_users_table)

        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'operator@mail.com'],
            ['name' => 'Operator', 'password' => Hash::make('password'), 'role' => 'operator']
        );

        User::updateOrCreate(
            ['email' => 'pimpinan@mail.com'],
            ['name' => 'Pimpinan', 'password' => Hash::make('password'), 'role' => 'pimpinan']
        );

        User::updateOrCreate(
            ['email' => 'user@mail.com'],
            ['name' => 'User Viewer', 'password' => Hash::make('password'), 'role' => 'user']
        );
    }
}
