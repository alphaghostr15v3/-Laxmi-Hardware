<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
        'image_path',
        'caption',
        'sort_order',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Returns the full public URL
    public function getImageUrlAttribute(): string
    {
        return image_url($this->image_path);
    }
}
