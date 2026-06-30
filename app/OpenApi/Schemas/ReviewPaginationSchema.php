<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ReviewPagination",
    type: "object",
    required: ["data", "links", "meta"]
)]
class ReviewPaginationSchema
{
    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/Review"))]
    public array $data;

    #[OA\Property(ref: "#/components/schemas/PaginationLinks")]
    public PaginationLinksSchema $links;

    #[OA\Property(ref: "#/components/schemas/PaginationMeta")]
    public PaginationMetaSchema $meta;
}
