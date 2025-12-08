<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@sirkula.test')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@sirkula.test',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '08123456789',
            ]);
        }
    }
}
