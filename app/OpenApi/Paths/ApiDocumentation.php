<?php

namespace App\OpenApi\Paths;

use OpenApi\Attributes as OA;

class ApiDocumentation
{
    #[OA\Get(
        path: "/categories",
        summary: "List categories",
        tags: ["Catalog"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Category list",
                content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/Category"))
            ),
        ]
    )]
    public function categories(): void {}

    #[OA\Get(
        path: "/products",
        summary: "List products",
        tags: ["Catalog"],
        parameters: [
            new OA\Parameter(name: "category_id", in: "query", schema: new OA\Schema(type: "integer"), example: 1),
            new OA\Parameter(name: "search", in: "query", schema: new OA\Schema(type: "string"), example: "headphones"),
            new OA\Parameter(name: "min_price", in: "query", schema: new OA\Schema(type: "number", format: "float"), example: 10),
            new OA\Parameter(name: "max_price", in: "query", schema: new OA\Schema(type: "number", format: "float"), example: 200),
            new OA\Parameter(name: "per_page", in: "query", schema: new OA\Schema(type: "integer", default: 12), example: 12),
            new OA\Parameter(name: "page", in: "query", schema: new OA\Schema(type: "integer", default: 1), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: "Paginated product list", content: new OA\JsonContent(ref: "#/components/schemas/ProductPagination")),
        ]
    )]
    public function products(): void {}

    #[OA\Get(
        path: "/products/{product}",
        summary: "Show product",
        tags: ["Catalog"],
        parameters: [
            new OA\Parameter(name: "product", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 12),
        ],
        responses: [
            new OA\Response(response: 200, description: "Product details", content: new OA\JsonContent(ref: "#/components/schemas/Product")),
            new OA\Response(response: 404, description: "Product not found"),
        ]
    )]
    public function product(): void {}

    #[OA\Post(
        path: "/register",
        summary: "Register a customer",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(required: ["name", "email", "password", "password_confirmation"], properties: [
                new OA\Property(property: "name", type: "string", maxLength: 255, example: "Reach Talab"),
                new OA\Property(property: "email", type: "string", format: "email", maxLength: 255, example: "reach@gmail.com"),
                new OA\Property(property: "password", type: "string", minLength: 8, example: "password123"),
                new OA\Property(property: "password_confirmation", type: "string", minLength: 8, example: "password123"),
            ])
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 201, description: "Registered", content: new OA\JsonContent(ref: "#/components/schemas/AuthResponse")),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function register(): void {}

    #[OA\Post(
        path: "/login",
        summary: "Log in a customer",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(required: ["email", "password"], properties: [
                new OA\Property(property: "email", type: "string", format: "email", example: "reach@gmail.com"),
                new OA\Property(property: "password", type: "string", example: "password123"),
            ])
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200, description: "Logged in", content: new OA\JsonContent(ref: "#/components/schemas/AuthResponse")),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function login(): void {}

    #[OA\Post(
        path: "/logout",
        summary: "Log out current customer",
        security: [["sanctum" => []]],
        tags: ["Auth"],
        responses: [
            new OA\Response(response: 200, description: "Logged out", content: new OA\JsonContent(ref: "#/components/schemas/MessageResponse")),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function logout(): void {}

    #[OA\Get(
        path: "/profile",
        summary: "Show current customer profile",
        security: [["sanctum" => []]],
        tags: ["Profile"],
        responses: [
            new OA\Response(response: 200, description: "Profile", content: new OA\JsonContent(ref: "#/components/schemas/User")),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function profile(): void {}

    #[OA\Put(
        path: "/profile",
        summary: "Update current customer profile",
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(required: ["name", "email"], properties: [
                new OA\Property(property: "name", type: "string", maxLength: 255, example: "Reach Talab"),
                new OA\Property(property: "email", type: "string", format: "email", maxLength: 255, example: "reach@gmail.com"),
            ])
        ),
        tags: ["Profile"],
        responses: [
            new OA\Response(response: 200, description: "Profile updated", content: new OA\JsonContent(ref: "#/components/schemas/User")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function updateProfile(): void {}

    #[OA\Put(
        path: "/profile/password",
        summary: "Change current customer password",
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(required: ["current_password", "password", "password_confirmation"], properties: [
                new OA\Property(property: "current_password", type: "string", example: "old-password"),
                new OA\Property(property: "password", type: "string", minLength: 8, example: "new-password"),
                new OA\Property(property: "password_confirmation", type: "string", minLength: 8, example: "new-password"),
            ])
        ),
        tags: ["Profile"],
        responses: [
            new OA\Response(response: 200, description: "Password changed", content: new OA\JsonContent(ref: "#/components/schemas/MessageResponse")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function changePassword(): void {}

    #[OA\Get(
        path: "/wishlist",
        summary: "List wishlist items",
        security: [["sanctum" => []]],
        tags: ["Wishlist"],
        responses: [
            new OA\Response(response: 200, description: "Wishlist", content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/Wishlist"))),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function wishlist(): void {}

    #[OA\Post(
        path: "/wishlist/{product}",
        summary: "Add product to wishlist",
        security: [["sanctum" => []]],
        tags: ["Wishlist"],
        parameters: [
            new OA\Parameter(name: "product", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 12),
        ],
        responses: [
            new OA\Response(response: 201, description: "Added to wishlist", content: new OA\JsonContent(ref: "#/components/schemas/Wishlist")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 404, description: "Product not found"),
        ]
    )]
    public function storeWishlist(): void {}

    #[OA\Delete(
        path: "/wishlist/{product}",
        summary: "Remove product from wishlist",
        security: [["sanctum" => []]],
        tags: ["Wishlist"],
        parameters: [
            new OA\Parameter(name: "product", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 12),
        ],
        responses: [
            new OA\Response(response: 200, description: "Removed from wishlist", content: new OA\JsonContent(ref: "#/components/schemas/MessageResponse")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 404, description: "Product not found"),
        ]
    )]
    public function destroyWishlist(): void {}

    #[OA\Get(
        path: "/cart",
        summary: "Show cart",
        security: [["sanctum" => []]],
        tags: ["Cart"],
        responses: [
            new OA\Response(response: 200, description: "Cart", content: new OA\JsonContent(ref: "#/components/schemas/Cart")),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function cart(): void {}

    #[OA\Post(
        path: "/cart",
        summary: "Add product to cart",
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(required: ["product_id"], properties: [
                new OA\Property(property: "product_id", type: "integer", example: 12),
                new OA\Property(property: "quantity", type: "integer", minimum: 1, nullable: true, example: 2),
            ])
        ),
        tags: ["Cart"],
        responses: [
            new OA\Response(response: 201, description: "Added to cart", content: new OA\JsonContent(ref: "#/components/schemas/CartItem")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function storeCart(): void {}

    #[OA\Put(
        path: "/cart/{cartItem}",
        summary: "Update cart item quantity",
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(required: ["quantity"], properties: [
            new OA\Property(property: "quantity", type: "integer", minimum: 1, example: 3),
        ])),
        tags: ["Cart"],
        parameters: [
            new OA\Parameter(name: "cartItem", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: "Updated cart item", content: new OA\JsonContent(ref: "#/components/schemas/CartItem")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 403, description: "Forbidden"),
            new OA\Response(response: 404, description: "Cart item not found"),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function updateCart(): void {}

    #[OA\Delete(
        path: "/cart/{cartItem}",
        summary: "Remove cart item",
        security: [["sanctum" => []]],
        tags: ["Cart"],
        parameters: [
            new OA\Parameter(name: "cartItem", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: "Removed from cart", content: new OA\JsonContent(ref: "#/components/schemas/MessageResponse")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 403, description: "Forbidden"),
            new OA\Response(response: 404, description: "Cart item not found"),
        ]
    )]
    public function destroyCart(): void {}

    #[OA\Post(
        path: "/checkout",
        summary: "Create order from cart",
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(required: ["shipping_name", "shipping_address"], properties: [
                new OA\Property(property: "shipping_name", type: "string", maxLength: 255, example: "Reach Talab"),
                new OA\Property(property: "shipping_email", type: "string", format: "email", nullable: true, maxLength: 255, example: "reach@gmail.com"),
                new OA\Property(property: "shipping_phone", type: "string", nullable: true, maxLength: 50, example: "+85512345678"),
                new OA\Property(property: "shipping_address", type: "string", example: "123 Market Street"),
                new OA\Property(property: "notes", type: "string", nullable: true, example: "Leave at reception."),
            ])
        ),
        tags: ["Checkout"],
        responses: [
            new OA\Response(response: 201, description: "Order created", content: new OA\JsonContent(ref: "#/components/schemas/Order")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function checkout(): void {}

    #[OA\Get(
        path: "/orders",
        summary: "List current customer orders",
        security: [["sanctum" => []]],
        tags: ["Orders"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", schema: new OA\Schema(type: "integer", default: 1), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: "Paginated order list", content: new OA\JsonContent(ref: "#/components/schemas/OrderPagination")),
            new OA\Response(response: 401, description: "Unauthenticated"),
        ]
    )]
    public function orders(): void {}

    #[OA\Get(
        path: "/orders/{order}",
        summary: "Show order",
        security: [["sanctum" => []]],
        tags: ["Orders"],
        parameters: [
            new OA\Parameter(name: "order", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: "Order details", content: new OA\JsonContent(ref: "#/components/schemas/Order")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 403, description: "Forbidden"),
            new OA\Response(response: 404, description: "Order not found"),
        ]
    )]
    public function order(): void {}

    #[OA\Get(
        path: "/products/{product}/reviews",
        summary: "List product reviews",
        tags: ["Reviews"],
        parameters: [
            new OA\Parameter(name: "product", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 12),
            new OA\Parameter(name: "page", in: "query", schema: new OA\Schema(type: "integer", default: 1), example: 1),
        ],
        responses: [
            new OA\Response(response: 200, description: "Paginated review list", content: new OA\JsonContent(ref: "#/components/schemas/ReviewPagination")),
            new OA\Response(response: 404, description: "Product not found"),
        ]
    )]
    public function reviews(): void {}

    #[OA\Post(
        path: "/products/{product}/reviews",
        summary: "Create or update current customer product review",
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(required: ["rating"], properties: [
            new OA\Property(property: "rating", type: "integer", minimum: 1, maximum: 5, example: 5),
            new OA\Property(property: "comment", type: "string", nullable: true, example: "Excellent product."),
        ])),
        tags: ["Reviews"],
        parameters: [
            new OA\Parameter(name: "product", in: "path", required: true, schema: new OA\Schema(type: "integer"), example: 12),
        ],
        responses: [
            new OA\Response(response: 201, description: "Review saved", content: new OA\JsonContent(ref: "#/components/schemas/Review")),
            new OA\Response(response: 401, description: "Unauthenticated"),
            new OA\Response(response: 404, description: "Product not found"),
            new OA\Response(response: 422, description: "Validation error", content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")),
        ]
    )]
    public function storeReview(): void {}
}
