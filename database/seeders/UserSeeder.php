<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Marketing
        User::create([
            'name' => 'Tim Marketing',
            'email' => 'marketing@example.com',
            'password' => Hash::make('password123'),
            'role' => 'marketing',
        ]);
    }
}
