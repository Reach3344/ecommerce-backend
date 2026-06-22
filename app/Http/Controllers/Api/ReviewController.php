<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        return $product->reviews()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $review = Review::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ],
            $data,
        );

        return response()->json($review->load('user:id,name'), 201);
    }
}
