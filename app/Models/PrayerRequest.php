<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    protected $fillable = [
        'user_id', 'body', 'is_anonymous', 'is_published', 'amen_count'
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
