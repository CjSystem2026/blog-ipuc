<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $appends = ['image_url'];

    protected $fillable = [
        'title',
        'date',
        'time',
        'location',
        'description',
        'image_path',
    ];

    /**
     * Obtener la URL completa de la imagen del evento.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            // Imagen por defecto para eventos de la comunidad
            return 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&auto=format&fit=crop&q=60';
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }
}
