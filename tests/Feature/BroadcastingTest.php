<?php

namespace Tests\Feature;

use App\Events\ResourceCreated;
use App\Models\Post;
use App\Models\PrayerRequest;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BroadcastingTest extends TestCase
{
    use RefreshDatabase;

    protected User $author;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::create([
            'name' => 'Pastor Evento',
            'email' => 'pastoreventos@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);
    }

    /**
     * Creating a post dispatches ResourceCreated event.
     */
    public function test_post_creation_dispatches_event(): void
    {
        Event::fake();

        $this->actingAs($this->author)->post('/admin/posts', [
            'title' => 'Un Mensaje de Esperanza',
            'excerpt' => 'Breve extracto',
            'content' => 'Todo el contenido del post aquí.',
        ]);

        Event::assertDispatched(ResourceCreated::class, function ($event) {
            return $event->type === 'post' && $event->title === 'Un Mensaje de Esperanza';
        });
    }

    /**
     * Approving a testimonial dispatches ResourceCreated event.
     */
    public function test_testimonial_approval_dispatches_event(): void
    {
        Event::fake();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $testimonial = Testimonial::create([
            'name' => 'Felipe',
            'content' => 'Dios abrió puertas en mi trabajo.',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)->put("/admin/testimonials/{$testimonial->id}", [
            'status' => 'approved',
        ]);

        Event::assertDispatched(ResourceCreated::class, function ($event) use ($testimonial) {
            return $event->type === 'testimonial' && str_contains($event->title, 'Felipe');
        });
    }

    /**
     * Storing a public prayer request dispatches ResourceCreated event.
     */
    public function test_public_prayer_request_dispatches_event(): void
    {
        Event::fake();

        $this->post('/prayer-requests', [
            'name' => 'Marta',
            'email' => 'marta@test.com',
            'message' => 'Oración por mi familia.',
            'is_private' => false,
        ]);

        Event::assertDispatched(ResourceCreated::class, function ($event) {
            return $event->type === 'prayer' && str_contains($event->title, 'Marta');
        });
    }

    /**
     * Storing a private prayer request does NOT dispatch ResourceCreated event.
     */
    public function test_private_prayer_request_does_not_dispatch_event(): void
    {
        Event::fake();

        $this->post('/prayer-requests', [
            'name' => 'Marta Privado',
            'email' => 'marta@test.com',
            'message' => 'Oración muy privada.',
            'is_private' => true,
        ]);

        Event::assertNotDispatched(ResourceCreated::class);
    }
}
