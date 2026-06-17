<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title', 'type', 'slug', 'excerpt', 'body', 'image',
        'is_published', 'published_at', 'category_id', 'user_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include articles.
     */
    public function scopeArticles($query)
    {
        return $query->where('type', 'article');
    }

    /**
     * Scope a query to only include testimonials.
     */
    public function scopeTestimonials($query)
    {
        return $query->where('type', 'testimonial');
    }
}
