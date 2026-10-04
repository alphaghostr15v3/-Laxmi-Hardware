<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'featured_image',
        'excerpt',
        'content',
        'author',
        'seo_title',
        'seo_description',
        'status',
        'published_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    // Returns the full public URL for the featured image
    public function getFeaturedImageUrlAttribute(): string
    {
        return image_url($this->featured_image);
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }
}
