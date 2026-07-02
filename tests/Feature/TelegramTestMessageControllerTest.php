<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TelegramTestMessageControllerTest extends TestCase
{
    public function test_authenticated_user_can_send_a_telegram_test_message(): void
    {
        config()->set('services.telegram.enabled', true);
        config()->set('services.telegram.bot_token', 'test-token');
        config()->set('services.telegram.chat_id', '123456');

        Http::fake([
            'https://api.telegram.org/*' => Http::response(['ok' => true], 200),
        ]);

        $user = new User([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/telegram/test', [
            'message' => 'Hello from Postman',
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => 'Telegram test message sent successfully.',
            ]);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.telegram.org/bottest-token/sendMessage'
                && $request['chat_id'] === '123456'
                && $request['text'] === 'Hello from Postman';
        });
    }
}
