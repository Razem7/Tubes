<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$rows = Illuminate\Support\Facades\DB::select('select id, photo_url from product_photos limit 20');
foreach ($rows as $row) {
    echo $row->id . ' ' . $row->photo_url . "\n";
    $file = __DIR__ . '/storage/app/public/' . $row->photo_url;
    echo (file_exists($file) ? 'EXISTS ' . $file : 'MISSING ' . $file) . "\n";
}
