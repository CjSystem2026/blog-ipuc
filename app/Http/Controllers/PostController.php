<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Muestra la página de inicio pública con todos los artículos (Blade).
     */
    public function index()
    {
        $posts = Post::with('author')->latest()->take(6)->get();
        $testimonials = Testimonial::where('status', 'approved')->latest()->get();
        $events = \App\Models\Event::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->take(6) // Mostrar máximo 6 eventos en el inicio
            ->get();
        $hasMorePosts = Post::count() > 6;
            
        return view('home', compact('posts', 'testimonials', 'events', 'hasMorePosts'));
    }

    /**
     * Muestra la lista completa de artículos con paginación (Blade).
     */
    public function archive()
    {
        $posts = Post::with('author')->latest()->paginate(9);
        return view('posts.index', compact('posts'));
    }

    /**
     * Muestra un artículo individual (Blade).
     */
    public function show($slug)
    {
        $post = Post::with(['author', 'comments.user'])->where('slug', $slug)->firstOrFail();
        return view('post', compact('post'));
    }

    /**
     * Lista los artículos del autor autenticado en el panel (Inertia/React).
     */
    public function adminIndex()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $posts = Post::with('author')->latest()->get();
        } else {
            $posts = Post::where('author_id', $user->id)->latest()->get();
        }

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'auth' => [
                'user' => $user
            ]
        ]);
    }

    /**
     * Muestra el formulario para crear un artículo (Inertia/React).
     */
    public function create()
    {
        Gate::authorize('create', Post::class);

        return Inertia::render('PostForm', [
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    /**
     * Guarda un nuevo artículo en la base de datos.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . rand(1000, 9999),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'image_path' => $imagePath,
            'author_id' => auth()->id(),
        ]);

        broadcast(new \App\Events\ResourceCreated('post', $post->title, route('posts.show', $post->slug)))->toOthers();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Muestra el formulario de edición (Inertia/React).
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return Inertia::render('PostForm', [
            'post' => $post,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);
    }

    /**
     * Actualiza el artículo en la base de datos.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $post->image_path;
        if ($request->hasFile('image')) {
            if ($post->image_path && !str_starts_with($post->image_path, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image_path);
            }
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . substr($post->slug, -4),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Elimina el artículo de la base de datos.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        if ($post->image_path && !str_starts_with($post->image_path, 'http')) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();
        return redirect()->route('admin.dashboard');
    }
}
