<?php

namespace Tests\Unit;

use App\Models\Concerns\HasPhotoUrl;
use PHPUnit\Framework\TestCase;

class HasPhotoUrlTest extends TestCase
{
    public function test_it_normalizes_public_storage_paths_to_storage_urls(): void
    {
        $model = new class {
            use HasPhotoUrl;
        };

        $this->assertSame('/storage/products/example.jpg', $model->getPhotoUrlAttribute('public/products/example.jpg'));
        $this->assertSame('/storage/products/example.jpg', $model->getPhotoUrlAttribute('storage/products/example.jpg'));
        $this->assertSame('/storage/products/example.jpg', $model->getPhotoUrlAttribute('/storage/products/example.jpg'));
        $this->assertSame('https://example.com/example.jpg', $model->getPhotoUrlAttribute('https://example.com/example.jpg'));
        $this->assertNull($model->getPhotoUrlAttribute(''));
    }
}
