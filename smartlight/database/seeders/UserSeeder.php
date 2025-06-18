<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('email', 'admin@smartlight.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@smartlight.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }

        // Update or create demo user
        User::updateOrCreate(
            ['email' => 'demo@smartlight.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
            ]
        );
        
        // Create additional users if running in development environment
        if (app()->environment('local', 'development')) {
            // Create additional random users (skip if email already exists)
            User::factory(3)->create();
        }
    }
}
