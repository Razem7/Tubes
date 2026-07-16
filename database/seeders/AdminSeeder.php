<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gadgethub.com'],
            [
                'name'           => 'Admin GadgetHub',
                'password'       => Hash::make('admin123'),
                'phone_number'   => '081234567890',
                'is_admin'       => true,
                'role'           => 'super_admin',
                'phone_verified' => true,
            ]
        );

        echo "✅ Super Admin berhasil dibuat!\n";
        echo "📧 Email: admin@gadgethub.com\n";
        echo "🔑 Password: admin123\n";
    }
}
