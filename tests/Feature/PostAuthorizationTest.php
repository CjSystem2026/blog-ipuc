<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Readers cannot access the admin panel.
     */
    public function test_readers_cannot_access_admin_dashboard(): void
    {
        $reader = User::create([
            'name' => 'Reader User',
            'email' => 'reader@test.com',
            'password' => bcrypt('password'),
            'role' => 'reader',
        ]);

        $response = $this->actingAs($reader)->get('/admin');

        $response->assertStatus(403);
    }

    /**
     * Writers can access the admin panel.
     */
    public function test_writers_can_access_admin_dashboard(): void
    {
        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $response = $this->actingAs($writer)->get('/admin');

        $response->assertStatus(200);
    }

    /**
     * Admins can access the admin panel.
     */
    public function test_admins_can_access_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
    }

    /**
     * Writers can only edit their own posts.
     */
    public function test_writers_can_only_edit_their_own_posts(): void
    {
        $writer1 = User::create([
            'name' => 'Writer 1',
            'email' => 'writer1@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $writer2 = User::create([
            'name' => 'Writer 2',
            'email' => 'writer2@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $post = Post::create([
            'title' => 'Writer 1 Post',
            'slug' => 'writer-1-post',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'author_id' => $writer1->id,
        ]);

        // Writer 1 can edit their own post
        $response1 = $this->actingAs($writer1)->get("/admin/posts/{$post->id}/edit");
        $response1->assertStatus(200);

        // Writer 2 cannot edit Writer 1's post
        $response2 = $this->actingAs($writer2)->get("/admin/posts/{$post->id}/edit");
        $response2->assertStatus(403);
    }

    /**
     * Admins can edit anyone's posts.
     */
    public function test_admins_can_edit_anyones_posts(): void
    {
        $writer = User::create([
            'name' => 'Writer',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $post = Post::create([
            'title' => 'Writer Post',
            'slug' => 'writer-post',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'author_id' => $writer->id,
        ]);

        $response = $this->actingAs($admin)->get("/admin/posts/{$post->id}/edit");
        $response->assertStatus(200);
    }

    /**
     * Users can upload an image when creating a post.
     */
    public function test_users_can_create_post_with_image(): void
    {
        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        \Illuminate\Support\Facades\Storage::fake('public');

        $imageFile = \Illuminate\Http\UploadedFile::fake()->image('cover.jpg');

        $response = $this->actingAs($writer)->post('/admin/posts', [
            'title' => 'Post with Image',
            'excerpt' => 'An excerpt',
            'content' => 'Content here',
            'image' => $imageFile,
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $post = Post::where('title', 'Post with Image')->first();
        $this->assertNotNull($post);
        $this->assertNotNull($post->image_path);

        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($post->image_path);
    }
}
