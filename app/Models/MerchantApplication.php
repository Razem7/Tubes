<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantApplication extends Model
{
    protected $fillable = [
        'user_id',
        // Data diri
        'owner_name', 'owner_nik', 'owner_phone', 'owner_address',
        'owner_city', 'owner_province', 'owner_dob', 'id_card_photo',
        // Data toko
        'store_name', 'store_category', 'store_description', 'store_address',
        'store_city', 'store_province', 'store_phone', 'store_email', 'store_logo',
        // Legalitas
        'npwp', 'npwp_photo', 'siup_nib', 'bank_name', 'bank_account_number', 'bank_account_name',
        // Status
        'status', 'rejection_reason', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'owner_dob'   => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'  => 'Menunggu Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => '-',
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'  => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            default    => 'gray',
        };
    }
}
