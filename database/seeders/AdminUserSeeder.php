<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Ensure uniqueness
            [
                'name' => 'Admin User',
                'phone' => '1234567890',
                'password' => Hash::make('password'), // Change the password after setup
                'role' => 'admin', // Role is now added in users table
                'status' => 1 // Active user
            ]
        );
    }
}
