<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => "Customer $i",
                'email' => "customer$i@gmail.com",
                'password' => bcrypt('password'),
                'role' => 'customer',
                'is_trial_used' => $i % 2 === 0,
            ]);
        }
    }
}
