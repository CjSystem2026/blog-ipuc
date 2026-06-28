<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrayerRequestController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SupportChatController;
use Illuminate\Support\Facades\Route;

// API de Consejería Anónima (Pública)
Route::get('/api/support-chat', [SupportChatController::class, 'getChat']);
Route::post('/api/support-chat', [SupportChatController::class, 'sendMessage']);

// Rutas Públicas (Blade)
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/articulos', [PostController::class, 'archive'])->name('posts.archive');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Peticiones de Oración públicas
Route::get('/oraciones', [PrayerRequestController::class, 'publicIndex'])->name('prayer-requests.index');
Route::get('/oraciones/{id}', [PrayerRequestController::class, 'publicShow'])->name('prayer-requests.show');
Route::post('/prayer-requests', [PrayerRequestController::class, 'store'])->name('prayer-requests.store');

// Testimonios públicos
Route::get('/testimonios', [TestimonialController::class, 'publicIndex'])->name('testimonials.index');
Route::get('/testimonios/crear', [TestimonialController::class, 'publicCreate'])->name('testimonials.create');
Route::get('/testimonios/{id}', [TestimonialController::class, 'publicShow'])->name('testimonials.show');
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// Comentarios
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// Rutas de Autenticación de Invitados (Inertia/React)
Route::middleware(['guest', 'inertia'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Ruta de Cierre de Sesión (Inertia POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rutas de Administración Protegidas (Inertia/React)
Route::middleware(['auth', 'inertia', 'can_access_admin'])->prefix('admin')->group(function () {
    Route::get('/', [PostController::class, 'adminIndex'])->name('admin.dashboard');
    Route::get('/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');

    // Rutas de Peticiones de Oración en Administración
    Route::get('/prayer-requests', [PrayerRequestController::class, 'index'])->name('admin.prayer-requests.index');
    Route::put('/prayer-requests/{prayerRequest}', [PrayerRequestController::class, 'update'])->name('admin.prayer-requests.update');
    Route::delete('/prayer-requests/{prayerRequest}', [PrayerRequestController::class, 'destroy'])->name('admin.prayer-requests.destroy');

    // Rutas de Testimonios en Administración
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('admin.testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');

    // Rutas de Eventos en Administración
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::post('/events', [EventController::class, 'store'])->name('admin.events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');

    // Rutas de Consejería en Administración
    Route::get('/support-chats', [SupportChatController::class, 'adminIndex'])->name('admin.support-chats.index');
    Route::post('/support-chats/{chat}/reply', [SupportChatController::class, 'adminReply'])->name('admin.support-chats.reply');
    Route::delete('/support-chats/{chat}', [SupportChatController::class, 'adminDestroy'])->name('admin.support-chats.destroy');
});
