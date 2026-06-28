<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Almacena un comentario polimórfico (Post, Testimonio, Petición de Oración).
     */
    public function store(Request $request)
    {
        $request->validate([
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string|in:post,testimonial,prayer',
            'guest_name' => 'nullable|string|max:100',
            'content' => 'required|string|max:1000',
        ]);

        $typeMap = [
            'post' => \App\Models\Post::class,
            'testimonial' => \App\Models\Testimonial::class,
            'prayer' => \App\Models\PrayerRequest::class,
        ];

        $modelClass = $typeMap[$request->commentable_type];
        
        // Verificar que el recurso padre exista
        $parent = $modelClass::findOrFail($request->commentable_id);

        Comment::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'guest_name' => auth()->check() ? null : ($request->guest_name ?: 'Invitado'),
            'content' => $request->content,
            'commentable_id' => $parent->id,
            'commentable_type' => $modelClass,
        ]);

        return back()->with('success', 'Tu comentario ha sido publicado con éxito.');
    }
}
