<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()
            ->wishlistItems()
            ->with('product.category')
            ->latest()
            ->get();
    }

    public function store(Request $request, Product $product)
    {
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return response()->json($wishlist->load('product.category'), 201);
    }

    public function destroy(Request $request, Product $product)
    {
        Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json(['message' => 'Removed from wishlist.']);
    }
}
