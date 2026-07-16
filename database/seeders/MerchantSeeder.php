<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'merchant@gadgethub.com'],
            [
                'name'           => 'Toko Demo Merchant',
                'password'       => Hash::make('merchant123'),
                'phone_number'   => '082345678901',
                'is_admin'       => false,
                'role'           => 'merchant',
                'phone_verified' => true,
            ]
        );

        echo "✅ Merchant demo berhasil dibuat!\n";
        echo "📧 Email: merchant@gadgethub.com\n";
        echo "🔑 Password: merchant123\n";
    }
}
