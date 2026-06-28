<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = ['support_chat_id', 'sender', 'message'];

    public function chat()
    {
        return $this->belongsTo(SupportChat::class, 'support_chat_id');
    }
}
