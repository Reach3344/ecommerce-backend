<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    public function products(Request $request)
    {
        $products = Product::with('category')
            ->withAvg('reviews', 'rating')
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('min_price'), fn ($query) => $query->where('price', '>=', $request->input('min_price')))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->input('max_price')))
            ->latest()
            ->paginate($request->integer('per_page', 12));

        return response()->json($products);
    }

    public function product(Product $product)
    {
        return $product->load(['category', 'reviews.user:id,name']);
    }
}
