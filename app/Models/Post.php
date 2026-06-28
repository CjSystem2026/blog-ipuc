<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $appends = ['image_url'];

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_path',
        'author_id',
    ];

    /**
     * Obtener el autor del post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Obtener la URL completa de la imagen.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop&q=60';
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }

    /**
     * Obtener los comentarios del post.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
}
