<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicTestimonialController extends Controller
{
    /**
     * Show the formal to share a testimonial.
     */
    public function share()
    {
        return view('testimonios.share');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'name'  => 'required|string|max:255',
            'body'  => 'required|string|min:20',
        ]);

        // We use the 'posts' table and store it as unpublished
        Post::create([
            'title'        => $validated['title'] . ' - Por ' . $validated['name'],
            'type'         => 'testimonial',
            'slug'         => Str::slug($validated['title'] . '-' . uniqid()),
            'body'         => $validated['body'],
            'is_published' => false, // Important: moderation required
            'user_id'      => 1, // Default to admin for now, or null if nullable
            'category_id'  => 1, // Default or generic category
        ]);

        return redirect()->route('blog', ['type' => 'testimonial'])
            ->with('status', '¡Gracias por compartir! Tu testimonio ha sido enviado y será publicado tras una breve revisión.');
    }
}
