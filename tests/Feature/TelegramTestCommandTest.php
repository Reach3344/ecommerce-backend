<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TelegramTestCommandTest extends TestCase
{
    public function test_the_telegram_test_command_sends_a_test_message(): void
    {
        config([
            'services.telegram.enabled' => true,
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '123456',
        ]);

        Http::fake([
            'https://api.telegram.org/bottest-token/sendMessage' => Http::response(['ok' => true]),
        ]);

        $this->artisan('telegram:test', ['message' => 'Hello from Laravel'])
            ->expectsOutputToContain('Telegram test message sent successfully.');

        Http::assertSentCount(1);
    }
}
