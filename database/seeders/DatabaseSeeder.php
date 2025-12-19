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
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'profile_picture' => 'images/profile-picture/embung.jpg',
            'phone' => '081320919314', 
            'role' => 'superadmin',
            'address' => 'Margahayu, Bandung',
            'gender' => 'l',
        ]);
    }
}
