<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'profile_photo_url',
        'phone_verified',
        'is_admin',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'phone_verified'    => 'boolean',
            'is_admin'          => 'boolean',
        ];
    }

    // ── Role helpers ────────────────────────────────────────────────────────

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isMerchant(): bool
    {
        return $this->role === 'merchant';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /** Merchant dan super_admin bisa menjual */
    public function canSell(): bool
    {
        return in_array($this->role, ['merchant', 'super_admin']);
    }

    /** Hanya user biasa yang bisa membeli */
    public function canBuy(): bool
    {
        return $this->role === 'user';
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function buyerChats()
    {
        return $this->hasMany(Chat::class, 'buyer_id');
    }

    public function sellerChats()
    {
        return $this->hasMany(Chat::class, 'seller_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function buyerTransactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    public function sellerTransactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }
}
