<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramOrderNotifier
{
    public function sendOrderCreated(Order $order): void
    {
        $order->loadMissing(['user', 'items']);

        $this->sendMessage($this->message($order), [
            'order_id' => $order->id,
            'context' => 'order_created',
        ]);
    }

    public function sendTestMessage(string $message): void
    {
        $this->sendMessage($message, [
            'context' => 'test_message',
        ]);
    }

    private function sendMessage(string $text, array $context = []): void
    {
        if (! config('services.telegram.enabled')) {
            return;
        }

        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $botToken || ! $chatId) {
            Log::warning('Telegram notification skipped because credentials are missing.', $context);

            return;
        }

        // TLS verification strategy - prefer explicit config, then php.ini values.
        $caCertConfig = config('services.telegram.ca_cert');
        $iniCurlCainfo = ini_get('curl.cainfo') ?: null;
        $iniOpenSsl = ini_get('openssl.cafile') ?: null;

        $candidates = array_filter([$caCertConfig, $iniCurlCainfo, $iniOpenSsl]);

        // Default: let the HTTP client use system defaults (true). If we find
        // a valid CA bundle file, set that path. If the developer explicitly
        // disables verification in local env, set verify=false.
        $verifyOption = true;
        $invalidCaCandidates = [];
        foreach ($candidates as $candidate) {
            if (! is_string($candidate) || $candidate === '') {
                continue;
            }

            $candidatePath = $candidate;

            if ($this->isUsableCaBundle($candidatePath)) {
                $verifyOption = $candidatePath;
                Log::info('Telegram will use CA bundle for TLS verification.', ['ca_cert' => $candidatePath]);
                break;
            }

            $invalidCaCandidates[] = $candidate;
            Log::warning('Telegram CA candidate invalid or not readable.', ['candidate' => $candidate]);
        }

        // Local-only unsafe bypass
        $disableVerify = filter_var(env('TELEGRAM_DISABLE_SSL_VERIFY', false), FILTER_VALIDATE_BOOLEAN);
        if ($disableVerify && app()->environment('local')) {
            Log::warning('Telegram SSL verification is disabled via TELEGRAM_DISABLE_SSL_VERIFY (local only).', []);
            $verifyOption = false;
        }

        if ($verifyOption === true && $invalidCaCandidates !== [] && app()->environment('local')) {
            Log::warning('Telegram SSL verification is disabled because local PHP CA config is invalid.', [
                'candidates' => $invalidCaCandidates,
            ]);
            $verifyOption = false;
        }

        $client = Http::timeout(10);
        if ($verifyOption !== true) {
            $client = $client->withOptions(['verify' => $verifyOption]);
        }

        try {
            $response = $client
                ->asJson()
                ->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML',
                ]);

            if ($response->failed()) {
                Log::warning('Telegram notification failed.', [
                    ...$context,
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'verify' => $verifyOption,
                ]);

                throw new \RuntimeException('Telegram API request failed.');
            }
        } catch (\Throwable $e) {
            $diagnostics = [
                'exception_message' => $e->getMessage(),
                'verify' => $verifyOption,
                'ini_curl_cainfo' => $iniCurlCainfo,
                'ini_openssl_cafile' => $iniOpenSsl,
                'ca_config' => $caCertConfig,
            ];

            Log::error('Telegram HTTP request exception.', array_merge($context, $diagnostics));

            throw $e;
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

    private function isUsableCaBundle(string $path): bool
    {
        return file_exists($path)
            && is_readable($path)
            && str_contains((string) file_get_contents($path, false, null, 0, 2048), 'BEGIN CERTIFICATE');
    }
}
