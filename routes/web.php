<?php

use App\Http\Controllers\PostDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\PrayerRequestController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\Category;

use App\Services\VerseOfTheDayService;

Route::get('/', function () {
    return view('home', [
        'posts'      => Post::with('category')->published()->latest()->limit(6)->get(),
        'categories' => Category::withCount(['posts' => fn($q) => $q->where('is_published', true)])->having('posts_count', '>', 0)->get(),
        'verse'      => VerseOfTheDayService::getToday(),
    ]);
});

Route::get('/posts/{slug}', [PostDetailController::class, 'show'])->name('post.show');

Route::get('/peticiones', [PrayerRequestController::class, 'index'])->name('prayers.index');
Route::post('/peticiones', [PrayerRequestController::class, 'store'])->name('prayers.store')->middleware('auth');

Route::get('/blog', function () {
    $categoryId = request('category');
    $query = Post::with('category')->published()->latest();
    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }
    return view('blog', [
        'posts'           => $query->paginate(9)->withQueryString(),
        'categories'      => Category::withCount(['posts' => fn($q) => $q->where('is_published', true)])->having('posts_count', '>', 0)->get(),
        'activeCategoryId' => $categoryId,
    ]);
})->name('blog');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/posts', PostController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
