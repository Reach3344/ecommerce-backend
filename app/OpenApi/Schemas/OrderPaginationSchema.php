<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OrderPagination",
    type: "object",
    required: ["data", "links", "meta"]
)]
class OrderPaginationSchema
{
    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/Order"))]
    public array $data;

    #[OA\Property(ref: "#/components/schemas/PaginationLinks")]
    public PaginationLinksSchema $links;

    #[OA\Property(ref: "#/components/schemas/PaginationMeta")]
    public PaginationMetaSchema $meta;
}
