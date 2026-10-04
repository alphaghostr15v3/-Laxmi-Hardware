<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'features',
        'image',
        'icon',
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
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    // Returns the full public URL for the service image
    public function getImageUrlAttribute(): string
    {
        return image_url($this->image);
    }

    public function getFeaturesListAttribute(): array
    {
        if (empty($this->features)) {
            return [];
        }
        $decoded = json_decode($this->features, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return array_values(array_filter(array_map('trim', explode("\n", $this->features))));
    }
}
