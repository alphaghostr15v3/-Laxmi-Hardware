<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'company',
        'designation',
        'photo',
        'review',
        'rating',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getPhotoUrlAttribute(): string
    {
        return image_url($this->photo);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order', 'asc');
    }
}
