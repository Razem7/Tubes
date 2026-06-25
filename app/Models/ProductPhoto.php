<?php

namespace App\Models;

use App\Models\Concerns\HasPhotoUrl;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasPhotoUrl;

    protected $fillable = [
        'product_id',
        'photo_url',
        'display_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
