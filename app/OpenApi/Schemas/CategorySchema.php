<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Category",
    type: "object",
    required: ["id", "name"]
)]
class CategorySchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "string", example: "Electronics")]
    public string $name;

    #[OA\Property(type: "integer", example: 8)]
    public int $products_count;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $created_at;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $updated_at;
}
