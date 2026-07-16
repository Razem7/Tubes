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
        // Sample users
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        User::firstOrCreate(
            ['email' => 'adul@example.com'],
            [
                'name'     => 'abdul saputra',
                'password' => Hash::make('Adul12345'),
                'role'     => 'user',
            ]
        );

        // Categories
        foreach (['Smartphone', 'Tablet', 'Laptop', 'Aksesori', 'Smartwatch', 'Kamera'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }

        // Seeders
        $this->call([
            AdminSeeder::class,
            MerchantSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
