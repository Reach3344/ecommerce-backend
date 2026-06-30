<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "User",
    type: "object",
    required: ["id", "name", "email"]
)]
class UserSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "string", example: "Reach Talab")]
    public string $name;

    #[OA\Property(type: "string", format: "email", example: "reach@gmail.com")]
    public string $email;

    #[OA\Property(type: "boolean", example: false)]
    public bool $is_admin;

    #[OA\Property(type: "string", nullable: true, example: "profile-images/customer.jpg")]
    public ?string $profile_image;

    #[OA\Property(type: "string", nullable: true, example: "/storage/profile-images/customer.jpg")]
    public ?string $profile_image_url;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $created_at;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $updated_at;
}
