<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function approve(Order $order)
    {
        $error = null;

        DB::transaction(function () use ($order, &$error) {
            $order = Order::whereKey($order->id)->lockForUpdate()->first();

            if ($order->status !== 'pending') {
                $error = 'Only pending orders can be approved.';
                return;
            }

            $order->load('items');

            foreach ($order->items as $item) {
                $product = Product::whereKey($item->product_id)->lockForUpdate()->first();

                if (! $product) {
                    $error = "Product {$item->product_name} no longer exists.";
                    return;
                }

                if ($product->stock < $item->quantity) {
                    $error = "{$product->name} only has {$product->stock} in stock.";
                    return;
                }
            }

            foreach ($order->items as $item) {
                Product::whereKey($item->product_id)->decrement('stock', $item->quantity);
            }

            $order->update(['status' => 'approved']);
        });

        if ($error) {
            return back()->with('error', $error);
        }

        return back()->with('success', 'Order approved and stock updated.');
    }
}
