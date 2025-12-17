<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin Super',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer user
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
