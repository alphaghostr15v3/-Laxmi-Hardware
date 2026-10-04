<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'location',
        'client_type',
        'description',
        'materials',
        'duration',
        'featured_image',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    // Returns the full public URL for the featured image
    public function getFeaturedImageUrlAttribute(): string
    {
        return image_url($this->featured_image, 'images/feature_1.jpg');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order', 'asc');
    }

    public function getMaterialsListAttribute(): array
    {
        if (empty($this->materials)) {
            return [];
        }
        $decoded = json_decode($this->materials, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return array_values(array_filter(array_map('trim', explode("\n", $this->materials))));
    }
}
