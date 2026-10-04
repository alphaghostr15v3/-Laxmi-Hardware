<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Returns the full public URL for the gallery image
    public function getImageUrlAttribute(): string
    {
        return image_url($this->image_path);
    }
}
