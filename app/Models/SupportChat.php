<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
    protected $fillable = ['token', 'status'];

    public function messages()
    {
        return $this->hasMany(SupportMessage::class)->orderBy('created_at', 'asc');
    }
}
