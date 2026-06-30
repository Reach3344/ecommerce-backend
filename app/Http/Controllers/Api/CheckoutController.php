<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\TelegramOrderNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function __construct(private readonly TelegramOrderNotifier $telegramOrderNotifier) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_email' => ['nullable', 'email', 'max:255'],
            'shipping_phone' => ['nullable', 'string', 'max:50'],
            'shipping_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $user = $request->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => ['Your cart is empty.'],
            ]);
        }

        $order = DB::transaction(function () use ($user, $cartItems, $data) {
            $total = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price);

            $order = Order::create([
                ...$data,
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->quantity * $item->product->price,
                ]);
            }

            $user->cartItems()->delete();

            return $order;
        });

        $order->load('items.product');

        try {
            $this->telegramOrderNotifier->sendOrderCreated($order);
        } catch (\Throwable $exception) {
            Log::warning('Unable to send Telegram order notification.', [
                'order_id' => $order->id,
                'message' => $exception->getMessage(),
            ]);
        }

        return response()->json($order, 201);
    }
}
