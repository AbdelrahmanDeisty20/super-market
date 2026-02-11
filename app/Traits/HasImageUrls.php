<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImageUrls
{
    /**
     * Get the full URL for an image stored in the public disk.
     *
     * @param string|null $path
     * @param string $default
     * @return string
     */
    public function getImageUrl(?string $path, string $default = ''): string
    {
        if (!$path) {
            return $default;
        }

        // Check if the path is already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}