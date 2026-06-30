<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "PaginationMeta",
    type: "object"
)]
class PaginationMetaSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $current_page;

    #[OA\Property(type: "integer", example: 1)]
    public int $from;

    #[OA\Property(type: "integer", example: 3)]
    public int $last_page;

    #[OA\Property(type: "string", example: "http://localhost:8000/api/products")]
    public string $path;

    #[OA\Property(type: "integer", example: 12)]
    public int $per_page;

    #[OA\Property(type: "integer", example: 12)]
    public int $to;

    #[OA\Property(type: "integer", example: 30)]
    public int $total;
}
