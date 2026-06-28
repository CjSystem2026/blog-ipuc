<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PrayerRequest;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected User $author;
    protected Post $post;
    protected Testimonial $testimonial;
    protected PrayerRequest $prayer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::create([
            'name' => 'Pastor Test',
            'email' => 'pastor@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $this->post = Post::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'excerpt' => 'Excerpt',
            'content' => 'Content here',
            'author_id' => $this->author->id,
        ]);

        $this->testimonial = Testimonial::create([
            'name' => 'Juan',
            'content' => 'Dios sanó a mi familia.',
            'status' => 'approved',
        ]);

        $this->prayer = PrayerRequest::create([
            'name' => 'Ana',
            'email' => 'ana@test.com',
            'message' => 'Oración por salud.',
            'is_private' => false,
        ]);
    }

    /**
     * Guests can comment on a post, testimonial or prayer request.
     */
    public function test_guest_can_comment_on_resources(): void
    {
        // 1. Post
        $response1 = $this->post('/comments', [
            'commentable_id' => $this->post->id,
            'commentable_type' => 'post',
            'guest_name' => 'Pedro',
            'content' => 'Excelente devocional.',
        ]);
        $response1->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'guest_name' => 'Pedro',
            'content' => 'Excelente devocional.',
            'commentable_id' => $this->post->id,
            'commentable_type' => Post::class,
            'user_id' => null,
        ]);

        // 2. Testimonial
        $response2 = $this->post('/comments', [
            'commentable_id' => $this->testimonial->id,
            'commentable_type' => 'testimonial',
            'guest_name' => 'María',
            'content' => '¡Gloria a Dios por este milagro!',
        ]);
        $response2->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'guest_name' => 'María',
            'content' => '¡Gloria a Dios por este milagro!',
            'commentable_id' => $this->testimonial->id,
            'commentable_type' => Testimonial::class,
        ]);

        // 3. Prayer Request
        $response3 = $this->post('/comments', [
            'commentable_id' => $this->prayer->id,
            'commentable_type' => 'prayer',
            'guest_name' => 'Lucas',
            'content' => 'Estaremos orando por tu situación, hermana Ana.',
        ]);
        $response3->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'guest_name' => 'Lucas',
            'content' => 'Estaremos orando por tu situación, hermana Ana.',
            'commentable_id' => $this->prayer->id,
            'commentable_type' => PrayerRequest::class,
        ]);
    }

    /**
     * Authenticated users can comment, and their user_id is saved.
     */
    public function test_authenticated_user_can_comment(): void
    {
        $user = User::create([
            'name' => 'Member User',
            'email' => 'member@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $response = $this->actingAs($user)->post('/comments', [
            'commentable_id' => $this->post->id,
            'commentable_type' => 'post',
            'content' => 'Un comentario autenticado.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'guest_name' => null,
            'content' => 'Un comentario autenticado.',
            'commentable_id' => $this->post->id,
            'commentable_type' => Post::class,
        ]);
    }

    /**
     * Comments require content.
     */
    public function test_comment_requires_content(): void
    {
        $response = $this->post('/comments', [
            'commentable_id' => $this->post->id,
            'commentable_type' => 'post',
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }
}
