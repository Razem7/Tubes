<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'adul@example.com')->first();

        if (! $user) {
            $this->command->warn('User adul@example.com tidak ditemukan. Skip product seeder.');
            return;
        }

        $products = [
            [
                'title'       => 'iPhone 13 Pro Max 256GB Sierra Blue Fullset',
                'description' => 'iPhone 13 Pro Max kondisi mulus, tidak ada bekas jatuh atau benturan. Layar original, baterai masih 91%. Kelengkapan: dus, charger original, earphone. Pembelian resmi iBox, garansi masih berlaku. Cocok untuk yang cari iPhone flagship dengan performa top.',
                'price'       => 12500000,
                'location'    => 'Jakarta Selatan',
                'brand'       => 'Apple',
                'model'       => 'iPhone 13 Pro Max',
                'condition'   => 'like_new',
                'category'    => 'Smartphone',
            ],
            [
                'title'       => 'Samsung Galaxy S22 Ultra 256GB Phantom Black',
                'description' => 'Samsung Galaxy S22 Ultra bekas pakai 6 bulan, kondisi sangat baik. S-Pen masih berfungsi sempurna, kamera 108MP jernih. Body mulus, tidak ada goresan. Layar AMOLED masih cerah. Dijual karena upgrade ke S23. Lengkap dengan dus dan charger original.',
                'price'       => 9800000,
                'location'    => 'Bandung',
                'brand'       => 'Samsung',
                'model'       => 'Galaxy S22 Ultra',
                'condition'   => 'like_new',
                'category'    => 'Smartphone',
            ],
            [
                'title'       => 'Xiaomi 12 Pro 12/256GB Second Mulus',
                'description' => 'Xiaomi 12 Pro bekas pakai 8 bulan, kondisi baik. Prosesor Snapdragon 8 Gen 1 masih sangat kencang untuk gaming dan multitasking. Layar AMOLED 120Hz halus. Baterai 4600mAh dengan fast charge 120W. Jual karena butuh dana. Harga bisa nego tipis.',
                'price'       => 5500000,
                'location'    => 'Surabaya',
                'brand'       => 'Xiaomi',
                'model'       => 'Xiaomi 12 Pro',
                'condition'   => 'good',
                'category'    => 'Smartphone',
            ],
            [
                'title'       => 'MacBook Air M2 8GB 256GB Space Gray 2022',
                'description' => 'MacBook Air M2 2022, kondisi sangat mulus. Digunakan hanya untuk kerja ringan dan browsing. Baterai cycle count masih di bawah 50. Performa chip M2 sangat kencang dan efisien. Layar Liquid Retina jernih. Lengkap dus, charger MagSafe original. Siap pakai.',
                'price'       => 16000000,
                'location'    => 'Jakarta Pusat',
                'brand'       => 'Apple',
                'model'       => 'MacBook Air M2',
                'condition'   => 'like_new',
                'category'    => 'Laptop',
            ],
            [
                'title'       => 'Laptop ASUS ROG Strix G15 RTX 3060 16GB RAM',
                'description' => 'ASUS ROG Strix G15 gaming laptop, prosesor AMD Ryzen 9, GPU RTX 3060, RAM 16GB DDR4, SSD 512GB NVMe. Mampu jalankan semua game AAA di setting high-ultra. Kondisi baik, layar 165Hz masih prima. Dijual karena tidak sempat dipakai. Harga bisa dinego.',
                'price'       => 14500000,
                'location'    => 'Depok',
                'brand'       => 'ASUS',
                'model'       => 'ROG Strix G15',
                'condition'   => 'good',
                'category'    => 'Laptop',
            ],
            [
                'title'       => 'iPad Pro 11 inch M2 WiFi 128GB Silver 2022',
                'description' => 'iPad Pro 11 inci generasi terbaru dengan chip M2, kondisi seperti baru. Layar Liquid Retina ProMotion 120Hz sangat tajam. Digunakan ringan untuk desain dan presentasi. Tidak ada goresan, sudah pakai screen protector sejak awal. Lengkap dengan dus original.',
                'price'       => 11000000,
                'location'    => 'Tangerang',
                'brand'       => 'Apple',
                'model'       => 'iPad Pro 11 M2',
                'condition'   => 'like_new',
                'category'    => 'Tablet',
            ],
            [
                'title'       => 'Samsung Galaxy Tab S8+ 12.4 inch 128GB WiFi',
                'description' => 'Samsung Galaxy Tab S8+ layar Super AMOLED 12.4 inci, resolusi 2800x1752, sangat cocok untuk menonton dan produktivitas. Sudah include S-Pen. Kondisi mulus pakai 4 bulan. Prosesor Snapdragon 8 Gen 1. Tersedia docking keyboard (tidak termasuk harga).',
                'price'       => 8200000,
                'location'    => 'Bekasi',
                'brand'       => 'Samsung',
                'model'       => 'Galaxy Tab S8+',
                'condition'   => 'like_new',
                'category'    => 'Tablet',
            ],
            [
                'title'       => 'Sony WH-1000XM5 Wireless Noise Cancelling Headphone',
                'description' => 'Sony WH-1000XM5 headphone premium dengan Active Noise Cancellation terbaik di kelasnya. Kualitas suara Hi-Res Audio, baterai tahan 30 jam. Kondisi sangat mulus, beli 3 bulan lalu. Dijual karena punya 2 unit. Lengkap dengan case, kabel, dan dus original Sony.',
                'price'       => 3200000,
                'location'    => 'Jakarta Barat',
                'brand'       => 'Sony',
                'model'       => 'WH-1000XM5',
                'condition'   => 'like_new',
                'category'    => 'Aksesori',
            ],
            [
                'title'       => 'Apple Watch Series 8 45mm GPS Midnight Aluminium',
                'description' => 'Apple Watch Series 8 45mm kondisi sangat baik. Fitur lengkap: ECG, Blood Oxygen, Crash Detection, temperature sensor. Baterai masih normal. Pemakaian 5 bulan dengan screen protector dari awal. Layar LTPO OLED masih cerah. Dijual karena beralih ke Apple Watch Ultra.',
                'price'       => 5800000,
                'location'    => 'Yogyakarta',
                'brand'       => 'Apple',
                'model'       => 'Apple Watch Series 8',
                'condition'   => 'good',
                'category'    => 'Smartwatch',
            ],
            [
                'title'       => 'Sony Alpha A7 III Mirrorless Camera Body Only',
                'description' => 'Sony Alpha A7 III body only, shutter count sekitar 8.000, masih sangat rendah. Sensor full-frame 24.2MP, autofocus Eye AF sangat akurat, video 4K. Kondisi mulus, tidak ada jamur pada sensor. Cocok untuk fotografer profesional atau content creator. Lengkap dus dan tali.',
                'price'       => 18500000,
                'location'    => 'Medan',
                'brand'       => 'Sony',
                'model'       => 'Alpha A7 III',
                'condition'   => 'good',
                'category'    => 'Kamera',
            ],
            [
                'title'       => 'OPPO Reno 10 Pro 12/256GB Glossy Purple',
                'description' => 'OPPO Reno 10 Pro baru dipakai 2 bulan, kondisi mulus. Kamera portrait 70mm telephoto hasilkan foto bokeh alami. Prosesor Snapdragon 778G, layar AMOLED 6.7 inci 120Hz, baterai 4600mAh dengan SuperVOOC 80W. Masih dalam garansi resmi. Jual karena pindah ke flagship.',
                'price'       => 5200000,
                'location'    => 'Semarang',
                'brand'       => 'OPPO',
                'model'       => 'Reno 10 Pro',
                'condition'   => 'like_new',
                'category'    => 'Smartphone',
            ],
            [
                'title'       => 'Samsung Galaxy Watch 5 Pro 45mm Titanium',
                'description' => 'Samsung Galaxy Watch 5 Pro 45mm Titanium Gray, kondisi baik. Layar sapphire crystal tahan gores, GPS bawaan, tracking olahraga lengkap. Baterai tahan 2-3 hari pemakaian normal. Cocok untuk pengguna aktif. Pakai 7 bulan, sudah pakai screen protector. Lengkap dus charger.',
                'price'       => 3800000,
                'location'    => 'Makassar',
                'brand'       => 'Samsung',
                'model'       => 'Galaxy Watch 5 Pro',
                'condition'   => 'good',
                'category'    => 'Smartwatch',
            ],
        ];

        $created = 0;
        foreach ($products as $data) {
            if (Product::where('title', $data['title'])->exists()) {
                continue;
            }

            $category = Category::where('name', $data['category'])->first();

            Product::create([
                'user_id'         => $user->id,
                'title'           => $data['title'],
                'description'     => $data['description'],
                'price'           => $data['price'],
                'location'        => $data['location'],
                'brand'           => $data['brand'],
                'model'           => $data['model'],
                'condition'       => $data['condition'],
                'category_id'     => $category?->id,
                'payment_methods' => 'cod,rekber',
                'is_sold'         => false,
            ]);

            $created++;
        }

        $this->command->info("$created produk berhasil ditambahkan.");
    }
}
