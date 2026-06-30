<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramOrderNotifier
{
    public function sendOrderCreated(Order $order): void
    {
        if (! config('services.telegram.enabled')) {
            return;
        }

        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $botToken || ! $chatId) {
            Log::warning('Telegram order notification skipped because credentials are missing.');

            return;
        }

        $order->loadMissing(['user', 'items']);

        $response = Http::timeout(10)
            ->asJson()
            ->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $this->message($order),
                'parse_mode' => 'HTML',
            ]);

        if ($response->failed()) {
            Log::warning('Telegram order notification failed.', [
                'order_id' => $order->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }

    private function message(Order $order): string
    {
        $items = $order->items
            ->map(fn ($item) => "- {$this->escape($item->product_name)} x{$item->quantity}: $" . number_format((float) $item->subtotal, 2))
            ->implode("\n");

        return implode("\n", array_filter([
            '<b>New Order Received</b>',
            "Order ID: #{$order->id}",
            'Customer: ' . $this->escape($order->shipping_name),
            'Email: ' . $this->escape($order->shipping_email),
            'Phone: ' . $this->escape($order->shipping_phone),
            'Address: ' . $this->escape($order->shipping_address),
            '',
            '<b>Items</b>',
            $items,
            '',
            '<b>Total:</b> $' . number_format((float) $order->total, 2),
            $order->notes ? 'Notes: ' . $this->escape($order->notes) : null,
        ]));
    }

    private function escape(?string $value): string
    {
        return htmlspecialchars($value ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
