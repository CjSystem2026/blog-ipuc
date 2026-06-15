<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Posts/Index', [
            'posts' => Post::with('category', 'user')->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Posts/Create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $isPublished = $request->boolean('is_published');

        $request->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('posts.index')->with('message', 'Artículo creado.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $isPublished = $request->boolean('is_published');

        $post->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'category_id' => $validated['category_id'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'is_published' => $isPublished,
            'published_at' => ($isPublished && !$post->is_published) ? now() : $post->published_at,
        ]);

        return redirect()->route('posts.index')->with('message', 'Artículo actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->back()->with('message', 'Artículo eliminado.');
    }
}
