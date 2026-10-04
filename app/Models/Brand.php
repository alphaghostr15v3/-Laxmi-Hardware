<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'website',
        'featured',
        'status',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    // Returns the full public URL for the brand logo
    public function getLogoUrlAttribute(): string
    {
        return image_url($this->logo, '');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('status', true);
    }
}
