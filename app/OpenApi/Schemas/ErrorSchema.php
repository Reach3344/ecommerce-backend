<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ValidationError",
    type: "object",
    required: ["message", "errors"]
)]
class ErrorSchema
{
    #[OA\Property(type: "string", example: "The given data was invalid.")]
    public string $message;

    #[OA\Property(
        type: "object",
        additionalProperties: new OA\AdditionalProperties(
            type: "array",
            items: new OA\Items(type: "string")
        ),
        example: ["email" => ["The email field is required."]]
    )]
    public object $errors;
}
