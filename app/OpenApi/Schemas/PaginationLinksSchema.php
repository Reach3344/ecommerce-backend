<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "PaginationLinks",
    type: "object"
)]
class PaginationLinksSchema
{
    #[OA\Property(type: "string", nullable: true, example: "http://localhost:8000/api/products?page=1")]
    public ?string $first;

    #[OA\Property(type: "string", nullable: true, example: "http://localhost:8000/api/products?page=3")]
    public ?string $last;

    #[OA\Property(type: "string", nullable: true, example: null)]
    public ?string $prev;

    #[OA\Property(type: "string", nullable: true, example: "http://localhost:8000/api/products?page=2")]
    public ?string $next;
}
