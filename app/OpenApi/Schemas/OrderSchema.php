<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Order",
    type: "object",
    required: ["id", "user_id", "status", "total"]
)]
class OrderSchema
{
    #[OA\Property(type: "integer", example: 1)]
    public int $id;

    #[OA\Property(type: "integer", example: 3)]
    public int $user_id;

    #[OA\Property(type: "string", example: "pending")]
    public string $status;

    #[OA\Property(type: "string", example: "179.98")]
    public string $total;

    #[OA\Property(type: "string", nullable: true, example: "Reach Talab")]
    public ?string $shipping_name;

    #[OA\Property(type: "string", format: "email", nullable: true, example: "reach@gmail.com")]
    public ?string $shipping_email;

    #[OA\Property(type: "string", nullable: true, example: "+85512345678")]
    public ?string $shipping_phone;

    #[OA\Property(type: "string", nullable: true, example: "123 Market Street")]
    public ?string $shipping_address;

    #[OA\Property(type: "string", nullable: true, example: "Leave at reception.")]
    public ?string $notes;

    #[OA\Property(type: "integer", nullable: true, example: 2)]
    public ?int $items_count;

    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/OrderItem"))]
    public array $items;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $created_at;

    #[OA\Property(type: "string", format: "date-time", example: "2026-06-22T12:40:00.000000Z")]
    public string $updated_at;
}
