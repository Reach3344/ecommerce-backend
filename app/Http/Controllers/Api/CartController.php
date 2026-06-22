<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()
            ->cartItems()
            ->with('product.category')
            ->get();

        return response()->json([
            'items' => $items,
            'total' => $items->sum(fn ($item) => $item->quantity * $item->product->price),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $item = CartItem::firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $data['product_id'],
        ]);

        $item->quantity = $item->exists
            ? $item->quantity + ($data['quantity'] ?? 1)
            : ($data['quantity'] ?? 1);
        $item->save();

        return response()->json($item->load('product.category'), 201);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cartItem->update($data);

        return response()->json($cartItem->load('product.category'));
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $cartItem->delete();

        return response()->json(['message' => 'Removed from cart.']);
    }
}
