<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * ImageUploadHelper
 *
 * Stores uploaded files directly into public/uploads/<folder>/<filename>
 * so the image URL is: asset('uploads/folder/filename')
 *
 * No `php artisan storage:link` is required.
 */
trait ImageUploadHelper
{
    /**
     * Store an uploaded file directly into public/uploads/<folder>.
     *
     * @param  UploadedFile  $file
     * @param  string        $folder   e.g. 'products', 'gallery', 'blog'
     * @return string                  Relative path like 'products/xxxx.jpg'
     */
    protected function uploadImage(UploadedFile $file, string $folder): string
    {
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("uploads/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }

    /**
     * Delete a previously uploaded file from public/uploads/<path>.
     *
     * @param  string|null  $relativePath  e.g. 'products/xxxx.jpg'
     * @return void
     */
    protected function deleteUploadedImage(?string $relativePath): void
    {
        if (empty($relativePath)) return;

        // Also try to delete from old storage disk (migration support)
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $fullPath = public_path("uploads/{$relativePath}");
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Get the public URL for an image stored in uploads.
     *
     * @param  string|null  $relativePath
     * @param  string       $placeholder
     * @return string
     */
    protected function getUploadUrl(?string $relativePath, string $placeholder = 'images/placeholder-hardware.svg'): string
    {
        if (empty($relativePath)) {
            return asset($placeholder);
        }

        // Already a full URL
        if (str_starts_with($relativePath, 'http://') || str_starts_with($relativePath, 'https://')) {
            return $relativePath;
        }

        $clean = ltrim($relativePath, '/');

        // Static /images/ asset
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

        // New uploads disk path
        if (file_exists(public_path("uploads/{$clean}"))) {
            return asset("uploads/{$clean}");
        }

        // Old storage symlink path (backward compat)
        if (file_exists(public_path("storage/{$clean}"))) {
            return asset("storage/{$clean}");
        }

        // Fallback: try as uploads
        return asset("uploads/{$clean}");
    }
}
