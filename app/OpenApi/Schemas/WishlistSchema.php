<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Wishlist",
    type: "object",
    required: ["id", "user_id", "product_id"]
)]
class WishlistSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "integer", example: 3)]
    public int $user_id;

    #[OA\Property(type: "integer", example: 12)]
    public int $product_id;

    #[OA\Property(ref: "#/components/schemas/Product", nullable: true)]
    public ?ProductSchema $product;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $created_at;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $updated_at;
}
