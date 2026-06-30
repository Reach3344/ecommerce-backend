<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "E-Commerce API",
    description: "REST API Documentation",
    contact: new OA\Contact(
        email: "admin@example.com"
    )
)]
#[OA\Server(
    url: "http://localhost:8000/api",
    description: "Local Server"
)]
#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class OpenApi {}