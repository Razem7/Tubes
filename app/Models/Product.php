<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'location',
        'brand',
        'model',
        'condition',
        'payment_methods',
        'category_id',
        'is_sold',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_sold' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class)->orderBy('display_order');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function getPaymentMethodsArray()
    {
        return explode(',', $this->payment_methods);
    }
}
