<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Anyone can submit a testimonial.
     */
    public function test_anyone_can_submit_testimonial(): void
    {
        $response = $this->post('/testimonials', [
            'name' => 'María Delgado',
            'content' => 'Dios ha sido fiel en mi vida.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('testimonials', [
            'name' => 'María Delgado',
            'content' => 'Dios ha sido fiel en mi vida.',
            'status' => 'pending',
        ]);
    }

    /**
     * Guests cannot view the testimonials admin page.
     */
    public function test_guests_cannot_view_testimonials(): void
    {
        $response = $this->get('/admin/testimonials');
        $response->assertRedirect('/login');
    }

    /**
     * Writers and admins can view the testimonials admin page.
     */
    public function test_authorized_users_can_view_testimonials(): void
    {
        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $response = $this->actingAs($writer)->get('/admin/testimonials');
        $response->assertStatus(200);
    }

    /**
     * Admins and writers can update testimonial status.
     */
    public function test_authorized_users_can_update_testimonial_status(): void
    {
        $writer = User::create([
            'name' => 'Writer User',
            'email' => 'writer@test.com',
            'password' => bcrypt('password'),
            'role' => 'writer',
        ]);

        $testimonial = Testimonial::create([
            'name' => 'Test Name',
            'content' => 'Test content',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($writer)->put("/admin/testimonials/{$testimonial->id}", [
            'status' => 'approved',
        ]);

        $response->assertStatus(302);
        $this->assertEquals('approved', $testimonial->fresh()->status);
    }

    /**
     * Admins can delete testimonials, but writers cannot.
     */
    public function test_only_admins_can_delete_testimonials(): void
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

        $testimonial = Testimonial::create([
            'name' => 'Test Name',
            'content' => 'Test content',
        ]);

        // Writer delete attempt -> 403
        $response1 = $this->actingAs($writer)->delete("/admin/testimonials/{$testimonial->id}");
        $response1->assertStatus(403);
        $this->assertDatabaseHas('testimonials', ['id' => $testimonial->id]);

        // Admin delete attempt -> 302 redirect back
        $response2 = $this->actingAs($admin)->delete("/admin/testimonials/{$testimonial->id}");
        $response2->assertStatus(302);
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }
}
