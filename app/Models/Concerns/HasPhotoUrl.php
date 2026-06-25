<?php

namespace App\Models\Concerns;

trait HasPhotoUrl
{
    public function getPhotoUrlAttribute($value)
    {
        if (! empty($value) && file_exists(storage_path('app/public/' . $value))) {
            return 'storage/' . $value;
        }

        return null;
    }
}
