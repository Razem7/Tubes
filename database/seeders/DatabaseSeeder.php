<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('Admin1234!'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'adul@example.com'],
            [
                'name'     => 'abdul saputra',
                'password' => Hash::make('Adul12345'),
                'is_admin' => false,
            ]
        );

        // Categories
        foreach (['Smartphone', 'Tablet', 'Laptop', 'Aksesori', 'Smartwatch', 'Kamera'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        // Seeders
        $this->call([
            AdminSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
