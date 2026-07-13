<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price'); // Price in IDR (no decimals)
            $table->unsignedBigInteger('compare_price')->nullable(); // Strikethrough price
            $table->string('sku')->unique()->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('weight')->default(0); // Weight in grams
            $table->json('images')->nullable(); // Array of image paths
            $table->decimal('rating', 2, 1)->default(0); // 0.0 - 5.0
            $table->unsignedInteger('rating_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index(['is_featured', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
