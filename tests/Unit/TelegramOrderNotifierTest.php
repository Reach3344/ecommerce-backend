<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\TelegramOrderNotifier;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TelegramOrderNotifierTest extends TestCase
{
    public function test_it_sends_order_created_message_to_telegram(): void
    {
        config([
            'services.telegram.enabled' => true,
            'services.telegram.bot_token' => 'test-token',
            'services.telegram.chat_id' => '123456',
        ]);

        Http::fake([
            'https://api.telegram.org/bottest-token/sendMessage' => Http::response(['ok' => true]),
        ]);

        $order = new Order([
            'shipping_name' => 'Reach <Talab>',
            'shipping_email' => 'reach@gmail.com',
            'shipping_phone' => '+85512345678',
            'shipping_address' => '123 Market Street',
            'total' => '179.98',
            'notes' => 'Leave at reception & call.',
        ]);
        $order->id = 10;
        $order->setRelation('items', collect([
            new OrderItem([
                'product_name' => 'Wireless Headphones',
                'quantity' => 2,
                'subtotal' => '179.98',
            ]),
        ]));

        app(TelegramOrderNotifier::class)->sendOrderCreated($order);

        Http::assertSent(fn ($request) => $request->url() === 'https://api.telegram.org/bottest-token/sendMessage'
            && $request['chat_id'] === '123456'
            && str_contains($request['text'], 'New Order Received')
            && str_contains($request['text'], 'Order ID: #10')
            && str_contains($request['text'], 'Reach &lt;Talab&gt;')
            && str_contains($request['text'], 'Leave at reception &amp; call.')
            && str_contains($request['text'], 'Wireless Headphones x2')
        );
    }
}
