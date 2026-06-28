<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'content',
        'status',
    ];

    /**
     * Obtener los comentarios del testimonio.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
}
