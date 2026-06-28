<?php

namespace Tests\Feature;

use App\Models\SupportChat;
use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_chat_without_token_returns_empty_messages()
    {
        $response = $this->getJson('/api/support-chat');

        $response->assertStatus(200);
        $response->assertJson(['messages' => []]);
    }

    public function test_send_message_creates_new_chat_and_token()
    {
        $response = $this->postJson('/api/support-chat', [
            'message' => 'Necesito hablar con un pastor.'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'token', 'status', 'messages']);
        $this->assertDatabaseHas('support_chats', [
            'status' => 'pending'
        ]);
        $this->assertDatabaseHas('support_messages', [
            'message' => 'Necesito hablar con un pastor.',
            'sender' => 'user'
        ]);
    }

    public function test_send_message_appends_to_existing_chat()
    {
        $chat = SupportChat::create(['token' => 'test-token-123', 'status' => 'replied']);

        $response = $this->postJson('/api/support-chat', [
            'message' => 'Otro mensaje más.',
            'token' => 'test-token-123'
        ]);

        $response->assertStatus(200);
        $this->assertEquals('pending', $chat->fresh()->status);
        $this->assertCount(1, $chat->fresh()->messages);
        $this->assertDatabaseHas('support_messages', [
            'support_chat_id' => $chat->id,
            'message' => 'Otro mensaje más.',
            'sender' => 'user'
        ]);
    }

    public function test_admin_can_view_support_chats_index()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/admin/support-chats');

        $response->assertStatus(200);
    }

    public function test_admin_can_reply_to_chat()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $chat = SupportChat::create(['token' => 'test-token-123', 'status' => 'pending']);

        $response = $this->actingAs($user)->post("/admin/support-chats/{$chat->id}/reply", [
            'message' => 'Dios te bendiga, estamos orando por ti.'
        ]);

        $response->assertStatus(302);
        $this->assertEquals('replied', $chat->fresh()->status);
        $this->assertDatabaseHas('support_messages', [
            'support_chat_id' => $chat->id,
            'message' => 'Dios te bendiga, estamos orando por ti.',
            'sender' => 'admin'
        ]);
    }

    public function test_admin_can_delete_chat()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $chat = SupportChat::create(['token' => 'test-token-123', 'status' => 'pending']);

        $response = $this->actingAs($user)->delete("/admin/support-chats/{$chat->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('support_chats', [
            'id' => $chat->id
        ]);
    }
}
