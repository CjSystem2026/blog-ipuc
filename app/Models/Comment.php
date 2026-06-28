<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'content',
        'commentable_id',
        'commentable_type',
    ];

    /**
     * Obtiene el modelo padre (Post, Testimonial, o PrayerRequest).
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Obtiene el usuario que publicó el comentario (si está autenticado).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el nombre del autor del comentario (autenticado o invitado).
     */
    public function getAuthorNameAttribute()
    {
        return $this->user ? $this->user->name : ($this->guest_name ?: 'Invitado');
    }
}
