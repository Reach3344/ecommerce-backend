<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ecommerce.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ],
        );

        $electronics = Category::updateOrCreate(['name' => 'Electronics']);
        $fashion = Category::updateOrCreate(['name' => 'Fashion']);

        Product::updateOrCreate(
            ['name' => 'Wireless Headphones'],
            [
                'category_id' => $electronics->id,
                'description' => 'Comfortable wireless headphones with clear sound.',
                'price' => 49.99,
                'stock' => 25,
            ],
        );

        Product::updateOrCreate(
            ['name' => 'Cotton T-Shirt'],
            [
                'category_id' => $fashion->id,
                'description' => 'Soft everyday cotton t-shirt.',
                'price' => 14.99,
                'stock' => 50,
            ],
        );
    }
}
