<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TelegramOrderNotifier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TelegramController extends Controller
{
    public function __construct(private readonly TelegramOrderNotifier $telegramOrderNotifier) {}

    public function test(Request $request): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $this->telegramOrderNotifier->sendTestMessage($data['message']);

            return response()->json([
                'message' => 'Telegram test message sent successfully.',
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Failed to send Telegram message.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
