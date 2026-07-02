<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckoutTelegramNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_sends_a_telegram_message_for_new_order(): void
    {
        config([
            'services.telegram.enabled' => true,
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '123456',
        ]);

        Http::fake([
            'https://api.telegram.org/bottest-token/sendMessage' => Http::response(['ok' => true]),
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $category = Category::create(['name' => 'Electronics']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Wireless Headphones',
            'description' => 'Noise cancelling headphones',
            'price' => 89.99,
            'stock' => 10,
        ]);

        CartItem::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/checkout', [
            'shipping_name' => 'John Doe',
            'shipping_email' => 'john@example.com',
            'shipping_phone' => '+85512345678',
            'shipping_address' => '123 Main Street',
            'notes' => 'Please call before delivery.',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('orders', ['user_id' => $user->id, 'status' => 'pending']);

        Http::assertSentCount(1);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.telegram.org/bottest-token/sendMessage'
                && $request['chat_id'] === '123456'
                && str_contains($request['text'], 'New Order Received')
                && str_contains($request['text'], 'Wireless Headphones x2');
        });
    }
}
