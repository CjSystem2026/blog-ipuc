<?php

namespace Tests\Feature;

use App\Models\PrayerRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrayerRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Anyone can submit a prayer request.
     */
    public function test_anyone_can_submit_prayer_request(): void
    {
        $response = $this->post('/prayer-requests', [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'message' => 'Orar por mi salud y mi familia.',
            'is_private' => true,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('prayer_requests', [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'message' => 'Orar por mi salud y mi familia.',
            'is_private' => true,
            'status' => 'pending',
        ]);
    }

    /**
     * Guests cannot view the prayer requests admin page.
     */
    public function test_guests_cannot_view_prayer_requests(): void
    {
        $response = $this->get('/admin/prayer-requests');
        $response->assertRedirect('/login');
    }

    /**
     * Writers and admins can view the prayer requests admin page.
     */
    public function test_authorized_users_can_view_prayer_requests(): void
    {
        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $response = $this->actingAs($writer)->get('/admin/prayer-requests');
        $response->assertStatus(200);
    }

    /**
     * Admins can delete prayer requests, but writers cannot.
     */
    public function test_only_admins_can_delete_prayer_requests(): void
    {
        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $request = PrayerRequest::create([
            'name' => 'Test',
            'message' => 'Test message',
        ]);

        // Writer delete attempt -> 403
        $response1 = $this->actingAs($writer)->delete("/admin/prayer-requests/{$request->id}");
        $response1->assertStatus(403);
        $this->assertDatabaseHas('prayer_requests', ['id' => $request->id]);

        // Admin delete attempt -> 302 redirect back
        $response2 = $this->actingAs($admin)->delete("/admin/prayer-requests/{$request->id}");
        $response2->assertStatus(302);
        $this->assertDatabaseMissing('prayer_requests', ['id' => $request->id]);
    }
}
