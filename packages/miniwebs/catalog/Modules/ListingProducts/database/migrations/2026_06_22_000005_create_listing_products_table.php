<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['listing_id', 'slug']);
            $table->index('listing_id');
        });

        Schema::create('listing_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('business_location_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longText('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('show_price')->default(true);
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->integer('quantity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('whatsapp_contact', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['listing_id', 'slug']);
            $table->index('listing_id');
            $table->index('category_id');
        });

        Schema::create('listing_product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->unsignedBigInteger('listing_product_id');
            $table->string('path');
            $table->string('filename');
            $table->string('original_name');
            $table->string('extension', 20)->nullable();
            $table->string('mime_type', 150)->nullable();
            $table->bigInteger('size')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('listing_product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_product_images');
        Schema::dropIfExists('listing_products');
        Schema::dropIfExists('listing_product_categories');
    }
};
