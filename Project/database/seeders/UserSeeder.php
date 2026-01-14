<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create default staff user
        User::create([
            'name' => 'Staff Perpus',
            'email' => 'staff@perpus.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
    }
}
