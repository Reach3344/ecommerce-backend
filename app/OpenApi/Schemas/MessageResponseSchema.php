<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "MessageResponse",
    type: "object",
    required: ["message"]
)]
class MessageResponseSchema
{
    #[OA\Property(type: "string", example: "Removed from cart.")]
    public string $message;
}
