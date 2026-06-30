<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "AuthResponse",
    type: "object",
    required: ["user", "token"]
)]
class AuthResponseSchema
{
    #[OA\Property(ref: "#/components/schemas/User")]
    public UserSchema $user;

    #[OA\Property(type: "string", example: "1|sanctum-token-value")]
    public string $token;
}
