<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostDetailController extends Controller
{
    public function show(string $slug)
    {
        $post = Post::with('category', 'user')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('post', compact('post'));
    }
}
