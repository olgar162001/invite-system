<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Ensure you import the User model

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if user already exists to prevent duplication
        if (User::where('email', 'admin@niacraft.com')->doesntExist()) {
            // Create an admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@niacraft.com',
                'password' => Hash::make('12345678'), // Use a secure password
            ]);
        }

        if (User::where('email', 'olgar162001@gmail.com')->doesntExist()) {
            // Create an admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'olgar162001@gmail.com',
                'password' => Hash::make('12345678'), // Use a secure password
            ]);
        }
    }
}
