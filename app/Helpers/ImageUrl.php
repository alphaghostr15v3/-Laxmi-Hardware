<?php

if (!function_exists('image_url')) {
    /**
     * Resolve the public URL for any image path stored in the system.
     *
     * Supports:
     *   - Full http/https URLs           → returned as-is
     *   - Static /images/... assets      → asset(path)
     *   - storage/...                    → asset(storage/path)
     *   - uploads/...                    → asset(uploads/path)
     *   - Relative paths (products/x.jpg)→ checks uploads/ then storage/ then uploads/ fallback
     *   - null / empty                   → returns placeholder
     *
     * @param  string|null  $path
     * @param  string       $placeholder
     * @return string
     */
    function image_url(?string $path, string $placeholder = 'images/placeholder-hardware.svg'): string
    {
        if (empty($path)) {
            return asset($placeholder);
        }

        // Full URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $clean = ltrim($path, '/');

        // Static images asset
        if (str_starts_with($clean, 'images/')) {
            return asset($clean);
        }

        // Already prefixed with storage/
        if (str_starts_with($clean, 'storage/')) {
            return asset($clean);
        }

        // Already prefixed with uploads/
        if (str_starts_with($clean, 'uploads/')) {
            return asset($clean);
        }

        // Check in public/uploads/
        if (file_exists(public_path("uploads/{$clean}"))) {
            return asset("uploads/{$clean}");
        }

        // Check in public/storage/ (old symlink path, backward compat)
        if (file_exists(public_path("storage/{$clean}"))) {
            return asset("storage/{$clean}");
        }

        // Fallback: prefer uploads path
        return asset("uploads/{$clean}");
    }
}
