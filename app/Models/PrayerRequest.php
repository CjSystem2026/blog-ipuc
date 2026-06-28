<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'is_private',
        'status',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    /**
     * Obtener los comentarios de la petición de oración.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
}
