<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Status constants
    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'payment_method',
        'amount',
        'status',
        'notes',
        'shipping_address',
        'confirmed_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'confirmed_at' => 'datetime',
        'rejected_at'  => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    /** Label + warna Tailwind untuk badge status */
    public function statusBadge(): array
    {
        return match($this->status) {
            self::STATUS_PENDING   => ['Menunggu Konfirmasi', 'bg-yellow-100 text-yellow-700'],
            self::STATUS_CONFIRMED => ['Dikonfirmasi',        'bg-blue-100 text-blue-700'],
            self::STATUS_REJECTED  => ['Ditolak',             'bg-red-100 text-red-700'],
            self::STATUS_COMPLETED => ['Selesai',             'bg-green-100 text-green-700'],
            self::STATUS_CANCELLED => ['Dibatalkan',          'bg-gray-100 text-gray-600'],
            default                => [$this->status,         'bg-gray-100 text-gray-600'],
        };
    }
}
