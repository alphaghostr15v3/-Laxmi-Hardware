<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'features',
        'specifications',
        'applications',
        'installation',
        'main_image',
        'status',
        'featured',
    ];

    protected $casts = [
        'status' => 'boolean',
        'featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function additionalImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function getSpecificationsAttribute()
    {
        if ($this->relationLoaded('specifications')) {
            return $this->getRelation('specifications');
        }

        return $this->hasMany(ProductSpecification::class)->get();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true)->where('status', true);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('brand', function ($bq) use ($search) {
                      $bq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['category'])) {
            $catSlug = $filters['category'];
            $query->whereHas('category', function ($cq) use ($catSlug) {
                $cq->where('slug', $catSlug);
            });
        }

        if (!empty($filters['subcategory'])) {
            $subSlug = $filters['subcategory'];
            $query->whereHas('subcategory', function ($sq) use ($subSlug) {
                $sq->where('slug', $subSlug);
            });
        }

        if (!empty($filters['brand'])) {
            $brandSlug = $filters['brand'];
            $query->whereHas('brand', function ($bq) use ($brandSlug) {
                $bq->where('slug', $brandSlug);
            });
        }

        if (!empty($filters['application'])) {
            $app = $filters['application'];
            $query->where('applications', 'like', "%{$app}%");
        }

        return $query;
    }

    // Returns features as an array (whether stored as JSON or newline separated)
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

    // Helper for main image URL fallback
    public function getMainImageUrlAttribute(): string
    {
        return image_url($this->main_image);
    }
}
