<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@bookvault.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        // Create Default Regular User
        User::updateOrCreate(
            ['email' => 'user@bookvault.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        // Run BookSeeder
        $this->call(BookSeeder::class);
    }
}
