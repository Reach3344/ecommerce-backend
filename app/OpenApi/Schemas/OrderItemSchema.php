<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OrderItem",
    type: "object",
    required: ["id", "order_id", "product_id", "product_name", "quantity", "price", "subtotal"]
)]
class OrderItemSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "integer", example: 1)]
    public int $order_id;

    #[OA\Property(type: "integer", example: 12)]
    public int $product_id;

    #[OA\Property(type: "string", example: "Wireless Headphones")]
    public string $product_name;

    #[OA\Property(type: "integer", example: 2)]
    public int $quantity;

    #[OA\Property(type: "string", example: "89.99")]
    public string $price;

    #[OA\Property(type: "string", example: "179.98")]
    public string $subtotal;

    #[OA\Property(ref: "#/components/schemas/Product", nullable: true)]
    public ?ProductSchema $product;
}
