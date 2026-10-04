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
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->index();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('features')->nullable();
            $table->text('specifications')->nullable();
            $table->text('applications')->nullable();
            $table->text('installation')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('spec_key');
            $table->text('spec_value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};
