<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin GadgetHub',
            'email' => 'admin@gadgethub.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '081234567890',
            'is_admin' => true,
            'phone_verified' => true,
        ]);

        echo "✅ Admin berhasil dibuat!\n";
        echo "📧 Email: admin@gadgethub.com\n";
        echo "🔑 Password: admin123\n";
    }
}
