<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->after('id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->after('id')->constrained()->cascadeOnDelete();
            $table->string('name')->after('category_id');
            $table->text('description')->nullable()->after('name');
            $table->decimal('price', 10, 2)->after('description');
            $table->unsignedInteger('stock')->default(0)->after('price');
            $table->string('image')->nullable()->after('stock');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending')->after('user_id');
            $table->decimal('total', 10, 2)->default(0)->after('status');
            $table->string('shipping_name')->nullable()->after('total');
            $table->string('shipping_email')->nullable()->after('shipping_name');
            $table->string('shipping_phone')->nullable()->after('shipping_email');
            $table->text('shipping_address')->nullable()->after('shipping_phone');
            $table->text('notes')->nullable()->after('shipping_address');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->after('order_id')->constrained()->cascadeOnDelete();
            $table->string('product_name')->after('product_id');
            $table->unsignedInteger('quantity')->after('product_name');
            $table->decimal('price', 10, 2)->after('quantity');
            $table->decimal('subtotal', 10, 2)->after('price');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->after('product_id');
            $table->text('comment')->nullable()->after('rating');
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id']);
            $table->dropConstrainedForeignId('product_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['rating', 'comment']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
            $table->dropConstrainedForeignId('order_id');
            $table->dropColumn(['product_name', 'quantity', 'price', 'subtotal']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
                'status',
                'total',
                'shipping_name',
                'shipping_email',
                'shipping_phone',
                'shipping_address',
                'notes',
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn(['name', 'description', 'price', 'stock', 'image']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
