<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Review",
    type: "object",
    required: ["id", "user_id", "product_id", "rating"]
)]
class ReviewSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "integer", example: 3)]
    public int $user_id;

    #[OA\Property(type: "integer", example: 12)]
    public int $product_id;

    #[OA\Property(type: "integer", minimum: 1, maximum: 5, example: 5)]
    public int $rating;

    #[OA\Property(type: "string", nullable: true, example: "Excellent product.")]
    public ?string $comment;

    #[OA\Property(ref: "#/components/schemas/User", nullable: true)]
    public ?UserSchema $user;

    #[OA\Property(ref: "#/components/schemas/Product", nullable: true)]
    public ?ProductSchema $product;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $created_at;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $updated_at;
}
