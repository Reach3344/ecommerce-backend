<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Product",
    type: "object",
    required: ["id", "category_id", "name", "price", "stock"]
)]
class ProductSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "integer", example: 1)]
    public int $category_id;

    #[OA\Property(type: "string", example: "Wireless Headphones")]
    public string $name;

    #[OA\Property(type: "string", nullable: true, example: "Noise-cancelling over-ear headphones.")]
    public ?string $description;

    #[OA\Property(type: "string", example: "89.99")]
    public string $price;

    #[OA\Property(type: "integer", example: 25)]
    public int $stock;

    #[OA\Property(type: "string", nullable: true, example: "products/headphones.jpg")]
    public ?string $image;

    #[OA\Property(type: "string", nullable: true, example: "/storage/products/headphones.jpg")]
    public ?string $image_url;

    #[OA\Property(ref: "#/components/schemas/Category", nullable: true)]
    public ?CategorySchema $category;

    #[OA\Property(type: "number", format: "float", nullable: true, example: 4.5)]
    public ?float $reviews_avg_rating;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $created_at;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $updated_at;
}
