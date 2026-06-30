<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Cart",
    type: "object",
    required: ["items", "total"]
)]
class CartResponseSchema
{
    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/CartItem"))]
    public array $items;

    #[OA\Property(type: "number", format: "float", example: 179.98)]
    public float $total;
}
