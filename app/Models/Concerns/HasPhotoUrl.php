<?php

namespace App\Models\Concerns;

trait HasPhotoUrl
{
    public function getPhotoUrlAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        $normalizedPath = ltrim($value, '/');

        if (str_starts_with($normalizedPath, 'storage/')) {
            return '/' . $normalizedPath;
        }

        return '/storage/' . $normalizedPath;
    }
}
