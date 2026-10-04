<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'project_type',
        'product_category',
        'location',
        'requirement',
        'message',
        'attachment_path',
        'status',
        'admin_notes',
    ];

    public function getAttachmentUrlAttribute(): ?string
    {
        if (!$this->attachment_path) {
            return null;
        }
        return asset('storage/' . $this->attachment_path);
    }
}
